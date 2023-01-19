<?php

namespace app\Http\Controllers\Kelas;

use app\Models\mKelas;
use app\Models\mGuru;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;

class Kelas extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->breadcrumb = [
            [
                'label' => $cons['kelas'],
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
        $data_list = DB::table('kelas')
            ->leftJoin('guru', 'guru.id_guru', '=', 'kelas.id_guru')
            ->get();
        $guru = mGuru::orderBy('gru_nama', 'ASC')->get();

        $datatable_column = [
            ["data" => "kls_nama"],
            ["data" => "kls_jumlah_siswa"],
            ["data" => "gru_nama"],
            ["data" => "swa_id_ketua"],
            ["data" => "swa_id_wakil"],
            ["data" => "swa_id_sekretaris"],
            ["data" => "swa_id_bendahara"],
            ["data" => "options"],
        ];

        $kls = mKelas::groupBy('kls_nama')->get();
        // dd($kls);
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

        return view('kelas/kelasList', $data);
    }


    function data_table(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];
        $kls = $data_post['kelas'];

        if ($keywords) {
            $total_data = mKelas
                ::whereLike('id_kelas', $keywords)
                ->orWhereLike('kls_nama', $keywords)
                ->count();
        } else {
            $total_data = mKelas
                ::count();
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_kelas'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mKelas
            ::with('guru');
        if ($keywords) {
            $data_list = $data_list
                ->whereLike('id_kelas', $keywords)
                ->orWhereLike('kls_nama', $keywords);
        }

        $data_list = $data_list
            ->offset($start)
            ->limit($limit)
            ->orderBy($order_column, $order_type)
            ->where('kls_nama', $kls)
            ->get();

        $total_data++;

        $data = array();
        foreach ($data_list as $key => $row) {
            $key++;
            $id_kelas = Main::encrypt($row->id_kelas);

            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['kls_nama'] = $row->kls_nama . $row->sub_kelas;
            $nestedData['kls_jumlah_siswa'] = $row->kls_jumlah_siswa;
            $nestedData['gru_nama'] = $row->guru->gru_nama;
            $nestedData['swa_id_ketua'] = $row->swa_id_ketua;
            $nestedData['swa_id_wakil'] = $row->swa_id_wakil;
            $nestedData['swa_id_sekretaris'] = $row->swa_id_sekretaris;
            $nestedData['swa_id_bendahara'] = $row->swa_id_bendahara;
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
                            data-route="' . route('kelasEditModal', ['id_kelas' => $id_kelas]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('kelasDelete', ['id_kelas' => $id_kelas]) . '">
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
            'kls_nama' => 'required',
            'sub_kelas' => 'required',
            'kls_jumlah_siswa' => 'required',
            'id_guru' => 'required',
            'swa_id_ketua' => 'required',
            'swa_id_wakil' => 'required',
            'swa_id_sekretaris' => 'required',
            'swa_id_bendahara' => 'required',
        ]);

        $data = $request->except('_token');
        mKelas::create($data);
    }

    function edit_modal($id_kelas)
    {
        $id_kelas = Main::decrypt($id_kelas);
        $edit = mKelas::where('id_kelas', $id_kelas)->first();
        $guru = mGuru::orderBy('gru_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'guru' => $guru,
        ];

        return view('kelas/kelasEditModal', $data);
    }

    function delete($id_kelas)
    {
        $id_kelas = Main::decrypt($id_kelas);
        mKelas::where('id_kelas', $id_kelas)->delete();
    }

    function update(Request $request, $id_kelas)
    {
        $id_kelas = Main::decrypt($id_kelas);
        $request->validate([
            'kls_nama' => 'required',
            'kls_jumlah_siswa' => 'required',
            'id_guru' => 'required',
            'swa_id_ketua' => 'required',
            'swa_id_wakil' => 'required',
            'swa_id_sekretaris' => 'required',
            'swa_id_bendahara' => 'required',
        ]);
        $data = $request->except("_token");
        mKelas::where(['id_kelas' => $id_kelas])->update($data);
    }
}
