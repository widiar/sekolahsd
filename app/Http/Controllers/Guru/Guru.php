<?php

namespace app\Http\Controllers\Guru;

use app\Models\mMataPelajaran;
use app\Models\mGuru;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;

class Guru extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->breadcrumb = [
            [
                'label' => $cons['guru'],
                'route' => ''
            ]
        ];
    }

    function index(Request $request)
    {
        $filter_component = Main::date_filter($request, ['keywords']);
        $date_from_db = $filter_component['date_from_db'];
        $date_to_db = $filter_component['date_to_db'];
        $date_filter = $filter_component['date_filter'];
        $keywords = $filter_component['keywords'];


        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('guru')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id_mata_pelajaran', '=', 'guru.id_mata_pelajaran')
            ->get();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->get();
        $datatable_column = [
            ["data" => "no"],
            ["data" => "gru_nip"],
            ["data" => "gru_nama"],
            ["data" => "gru_alamat"],
            ["data" => "options"],
        ];

        $data = array_merge($data, [
            'data' => $data_list,
            'mata_pelajaran' => $mata_pelajaran,
            'datatable_column' => $datatable_column,
            'date_filter' => $date_filter,
            'table_data_post' => array(
                'date_from_db' => $date_from_db,
                'date_to_db' => $date_to_db,
                'keywords' => $keywords
            ),
        ]);

        return view('guru/guruList', $data);
    }


    function data_table(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];

        if ($keywords) {
            $total_data = mGuru
                ::whereLike('id_guru', $keywords)
                ->orWhereLike('gru_nama', $keywords)
                ->count();
        } else {
            $total_data = mGuru
                ::count();
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_guru'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mGuru
            ::with('mata_pelajaran');
        if ($keywords) {
            $data_list = $data_list
                ->whereLike('id_guru', $keywords)
                ->orWhereLike('gru_nama', $keywords);
        }

        $data_list = $data_list
            ->offset($start)
            ->limit($limit)
            ->orderBy($order_column, $order_type)
            ->get();

        $total_data++;

        $data = array();
        foreach ($data_list as $key => $row) {
            $key++;
            $id_guru = Main::encrypt($row->id_guru);

            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['no'] = $key;
            $nestedData['gru_nip'] = $row->gru_nip;
            $nestedData['gru_nama'] = $row->gru_nama;
            $nestedData['gru_alamat'] = $row->gru_alamat;
            $nestedData['options'] = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-accent dropdown-toggle m-btn--pill"
                            type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        Menu
                    </button>
                    <div class="dropdown-menu dropdown-menu-right"
                         aria-labelledby="dropdownMenuButton">
                        <a class="akses-action_wait_cancel dropdown-item btn-modal-general"
                           href="#"
                            data-route="' . route('guruEditModal', ['id_guru' => $id_guru]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('guruDelete', ['id_guru' => $id_guru]) . '">
                            <i class="la la-remove"></i>
                            Hapus
                        </a>
                    </div>
                </div>
            ';


            $data[] = $nestedData;

        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($total_data - 1),
            "recordsFiltered" => intval($total_data - 1),
            "data" => $data,
            'all_request' => $request->all(),
            'keywords' => $keywords
        );

        return $json_data;
    }

    function insert(Request $request)
    {
        $request->validate([
            'gru_nip' => 'required',
            'gru_nama' => 'required',
            // 'id_mata_pelajaran' => 'required',
            'gru_alamat' => 'required',
        ]);

        $data = $request->except('_token');
        mGuru::create($data);
    }

    function edit_modal($id_guru)
    {
        $id_guru = Main::decrypt($id_guru);
        $edit = mGuru::where('id_guru', $id_guru)->first();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'mata_pelajaran' => $mata_pelajaran,
        ];

        return view('guru/guruEditModal', $data);
    }

    function delete($id_guru)
    {
        $id_guru = Main::decrypt($id_guru);
        mGuru::where('id_guru', $id_guru)->delete();
    }

    function update(Request $request, $id_guru)
    {
        $id_guru = Main::decrypt($id_guru);
        $request->validate([
            'gru_nip' => 'required',
            'gru_nama' => 'required',
            // 'id_mata_pelajaran' => 'required',
            'gru_alamat' => 'required',
        ]);
        $data = $request->except("_token");
        // dd($data);
        mGuru::where('id_guru',$id_guru)->update($data);
    }
}
