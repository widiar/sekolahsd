<?php

namespace app\Http\Controllers\MataPelajaran;

use app\Models\mGuru;
use app\Models\mMataPelajaran;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use app\Models\mKelas;
use Illuminate\Support\Facades\DB;

class MataPelajaran extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->breadcrumb = [
            [
                'label' => $cons['mata_pelajaran'],
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
        
        $data_list = DB::table('mata_pelajaran')
            ->leftJoin('guru', 'guru.id_guru', '=', 'mata_pelajaran.id_guru')
            ->get();
        $guru = mGuru::orderBy('gru_nama', 'ASC')->get();


        $datatable_column = [
            ["data" => "no"],
            ["data" => "mpj_kode"],
            ["data" => "mpj_nama"],
            ["data" => "mpj_kelas"],
            ["data" => "mpj_nilai_lulus"],
            ["data" => "gru_nama"],
            ["data" => "options"],
        ];
        $kls = mKelas::groupBy('kls_nama')->get();
        $data = array_merge($data, [
            'data' => $data_list,
            'guru' => $guru,
            'kelas' => $kls,
            'datatable_column' => $datatable_column,
            'date_filter' => $date_filter,
            'table_data_post' => array(
                'date_from_db' => $date_from_db,
                'date_to_db' => $date_to_db,
                'keywords' => $keywords,
                'kelas' => 'I'
            ),
        ]);
        // dd($data);
        return view('matapelajaran/matapelajaranList', $data);
    }


    function data_table(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];
        $kls = $data_post['kelas'];

        if ($keywords) {
            $total_data = mMataPelajaran
                ::whereLike('id_mata_pelajaran', $keywords)
                ->orWhereLike('mpj_nama', $keywords)
                ->count();
        } else {
            $total_data = mMataPelajaran
                ::count();
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_mata_pelajaran'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mMataPelajaran
            ::with('guru');
        if ($keywords) {
            $data_list = $data_list
                ->whereLike('id_mata_pelajaran', $keywords)
                ->orWhereLike('mpj_nama', $keywords);
        }

        $data_list = $data_list
            ->offset($start)
            ->limit($limit)
            ->orderBy($order_column, $order_type)
            ->where('mpj_kelas', $kls)
            ->get();

        $total_data++;

        $data = array();
        foreach ($data_list as $key => $row) {
            $key++;
            $id_mata_pelajaran = Main::encrypt($row->id_mata_pelajaran);

            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['no'] = $key;
            $nestedData['mpj_kode'] = $row->mpj_kode;
            $nestedData['mpj_nama'] = $row->mpj_nama;
            $nestedData['mpj_kelas'] = $row->mpj_kelas;
            $nestedData['mpj_nilai_lulus'] = $row->mpj_nilai_lulus;
            $nestedData['gru_nama'] = $row->guru->gru_nama;
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
                            data-route="' . route('matapelajaranEditModal', ['id_mata_pelajaran' => $id_mata_pelajaran]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('matapelajaranDelete', ['id_mata_pelajaran' => $id_mata_pelajaran]) . '">
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
            'mpj_kode' => 'required',
            'mpj_nama' => 'required',
            'mpj_kelas' => 'required',
            'mpj_nilai_lulus' => 'required',
            'id_guru' => 'required',
        ]);

        $data = $request->except('_token');
        mMataPelajaran::create($data);
    }

    function edit_modal($id_mata_pelajaran)
    {
        $id_mata_pelajaran = Main::decrypt($id_mata_pelajaran);
        $edit = mMataPelajaran::where('id_mata_pelajaran', $id_mata_pelajaran)->first();
        $guru = mGuru::orderBy('gru_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'guru' => $guru,
        ];

        return view('matapelajaran/matapelajaranEditModal', $data);
    }

    function delete($id_mata_pelajaran)
    {
        $id_mata_pelajaran = Main::decrypt($id_mata_pelajaran);
        mMataPelajaran::where('id_mata_pelajaran', $id_mata_pelajaran)->delete();
    }

    function update(Request $request, $id_mata_pelajaran)
    {
        $id_mata_pelajaran = Main::decrypt($id_mata_pelajaran);
        $request->validate([
            'mpj_kode' => 'required',
            'mpj_nama' => 'required',
            'id_guru' => 'required',
            'mpj_nilai_lulus' => 'required',
        ]);
        $data = $request->except("_token");
        mMataPelajaran::where(['id_mata_pelajaran' => $id_mata_pelajaran])->update($data);
    }
}
