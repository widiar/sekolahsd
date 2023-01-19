<?php

namespace app\Http\Controllers\Siswa;

use app\Models\mSiswa;
use app\Models\mKelas;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;

class Siswa extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->breadcrumb = [
            [
                'label' => $cons['siswa'],
                'route' => ''
            ]
        ];
    }

    function index($kls, Request $request)
    {

        $filter_component = Main::date_filter($request, ['keywords']);
        $date_from_db = $filter_component['date_from_db'];
        $date_to_db = $filter_component['date_to_db'];
        $date_filter = $filter_component['date_filter'];
        $keywords = $filter_component['keywords'];

        // $data_test =  DB::table('siswa')
        //     ->join('kelas', function ($join) {
        //         $join->on('kelas.id_kelas', '=', 'siswa.id_kelas')
        //                 ->whereNull('siswa.deleted_at');
        //     })
        //     ->get();

        // dd($data_test->count());
        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('siswa')
            ->leftJoin('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
            ->get();
        // dd($data_list);
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();
        $kelaspilih = mKelas::where('kls_nama', $kls)->orderBy('sub_kelas', 'asc')->get();
        // dd($kelaspilih[0]->sub_kelas);
        $datatable_column = [
            ["data" => "no"],
            ["data" => "swa_nis"],
            ["data" => "swa_nama"],
            ["data" => "kls_nama"],
            ["data" => "swa_alamat"],
            ["data" => "options"],
        ];

        $data = array_merge($data, [
            'data' => $data_list,
            'kelas' => $kelas,
            'kelaspilih' => $kelaspilih,
            'datatable_column' => $datatable_column,
            'date_filter' => $date_filter,
            'table_data_post' => array(
                'date_from_db' => $date_from_db,
                'date_to_db' => $date_to_db,
                'keywords' => $keywords,
                'kls' => $kls,
                'subkelas' => $kelaspilih[0]->sub_kelas,
            ),
        ]);
        // dd($data['menu']);
        return view('siswa/siswaList', $data);
    }


    function data_table(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];
        $kls = $data_post['kls'];
        $sub_kelas = $data_post['subkelas'];

        if ($keywords) {
            $total_data = mSiswa
                ::whereLike('id_siswa', $keywords)
                ->orWhereLike('swa_nama', $keywords)
                ->count();
        } else {
            $total_data = mSiswa
                ::count();
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_siswa'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mSiswa::with('kelas');

        if ($keywords) {
            $data_list = $data_list
                ->whereLike('id_siswa', $keywords)
                ->orWhereLike('swa_nama', $keywords);
        }

        $data_list = $data_list
            ->offset($start)
            ->limit($limit)
            ->orderBy($order_column, $order_type)
            ->whereHas('kelas', function ($q) use ($kls, $sub_kelas) {
                return $q->where('kls_nama', $kls)->where('sub_kelas', $sub_kelas);
            })
            ->get();

        // $data_list = $data_list
        //     ->wherelike('kls_nama','i')
        //     ->get();

        $total_data++;

        $data = array();
        foreach ($data_list as $key => $row) {
            $key++;
            $id_siswa = Main::encrypt($row->id_siswa);

            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['no'] = $no;
            $nestedData['swa_nis'] = $row->swa_nis;
            $nestedData['swa_nama'] = $row->swa_nama;
            $nestedData['kls_nama'] = $row->kelas->kls_nama;
            $nestedData['swa_alamat'] = $row->swa_alamat;
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
                            data-route="' . route('siswaEditModal', ['id_siswa' => $id_siswa]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('siswaDelete', ['id_siswa' => $id_siswa]) . '">
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

    function data_table1(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];

        if ($keywords) {
            $total_data = mSiswa
                ::whereLike('id_siswa', $keywords)
                ->orWhereLike('swa_nama', $keywords)
                ->count();
        } else {
            $total_data = mSiswa
                ::count();
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_siswa'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mSiswa::with('kelas');

        if ($keywords) {
            $data_list = $data_list
                ->whereLike('id_siswa', $keywords)
                ->orWhereLike('swa_nama', $keywords);
        }

        $data_list = $data_list
            ->where('id_kelas', 1)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order_column, $order_type)
            ->get();

        // $data_list = $data_list
        //     ->wherelike('kls_nama','i')
        //     ->get();

        $total_data++;

        $data = array();
        foreach ($data_list as $key => $row) {
            $key++;
            $id_siswa = Main::encrypt($row->id_siswa);

            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['no'] = $no;
            $nestedData['swa_nis'] = $row->swa_nis;
            $nestedData['swa_nama'] = $row->swa_nama;
            $nestedData['kls_nama'] = $row->kelas->kls_nama;
            $nestedData['swa_alamat'] = $row->swa_alamat;
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
                            data-route="' . route('siswaEditModal', ['id_siswa' => $id_siswa]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('siswaDelete', ['id_siswa' => $id_siswa]) . '">
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

    function data_table2(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];

        if ($keywords) {
            $total_data = mSiswa
                ::whereLike('id_siswa', $keywords)
                ->orWhereLike('swa_nama', $keywords)
                ->count();
        } else {
            $total_data = mSiswa
                ::count();
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_siswa'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mSiswa::with('kelas');

        if ($keywords) {
            $data_list = $data_list
                ->whereLike('id_siswa', $keywords)
                ->orWhereLike('swa_nama', $keywords);
        }

        $data_list = $data_list
            ->where('id_kelas', 2)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order_column, $order_type)
            ->get();

        // $data_list = $data_list
        //     ->wherelike('kls_nama','i')
        //     ->get();

        $total_data++;

        $data = array();
        foreach ($data_list as $key => $row) {
            $key++;
            $id_siswa = Main::encrypt($row->id_siswa);

            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['no'] = $no;
            $nestedData['swa_nis'] = $row->swa_nis;
            $nestedData['swa_nama'] = $row->swa_nama;
            $nestedData['kls_nama'] = $row->kelas->kls_nama;
            $nestedData['swa_alamat'] = $row->swa_alamat;
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
                            data-route="' . route('siswaEditModal', ['id_siswa' => $id_siswa]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('siswaDelete', ['id_siswa' => $id_siswa]) . '">
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
            'swa_nis' => 'required',
            'swa_nama' => 'required',
            'id_kelas' => 'required',
            'swa_alamat' => 'required',
        ]);

        $data = $request->except('_token');
        mSiswa::create($data);
    }

    function edit_modal($id_siswa)
    {
        $id_siswa = Main::decrypt($id_siswa);
        $edit = mSiswa::where('id_siswa', $id_siswa)->first();
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'kelas' => $kelas,
        ];

        return view('siswa/siswaEditModal', $data);
    }

    function delete($id_siswa)
    {
        $id_siswa = Main::decrypt($id_siswa);
        mSiswa::where('id_siswa', $id_siswa)->delete();
    }

    function update(Request $request, $id_siswa)
    {
        $id_siswa = Main::decrypt($id_siswa);
        $request->validate([
            'swa_nis' => 'required',
            'swa_nama' => 'required',
            'id_kelas' => 'required',
            'swa_alamat' => 'required',
        ]);
        $data = $request->except("_token");
        mSiswa::where(['id_siswa' => $id_siswa])->update($data);
    }
}
