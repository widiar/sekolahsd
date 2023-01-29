<?php

namespace app\Http\Controllers\Absen;

use app\Models\mAbsen;
use app\Models\mSiswa;
use app\Models\mKelas;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;

class Absen extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->breadcrumb = [
            [
                'label' => $cons['absen'],
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


        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('absen')
            ->leftJoin('siswa', 'siswa.id_siswa', '=', 'absen.id_siswa')
            ->leftJoin('kelas', 'kelas.id_kelas', '=', 'absen.id_kelas')
            ->get();
        $klspl = mKelas::where('kls_nama', $kls)->orderBy('sub_kelas', 'asc')->pluck('id_kelas');
        $siswa = mSiswa::with('kelas')->orderBy('swa_nama', 'ASC')->whereIn('id_kelas', $klspl)->get();
        // dd($siswa);
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();
        $kelaspilih = mKelas::where('kls_nama', $kls)->orderBy('sub_kelas', 'asc')->get();
        $datatable_column = [
            ["data" => "no"],
            ["data" => "swa_nis"],
            ["data" => "swa_nama"],
            // ["data" => "kls_nama"],
            ["data" => "abs_tanggal"],
            ["data" => "abs_keterangan"],
            ["data" => "options"],

        ];

        $data = array_merge($data, [
            'data' => $data_list,
            'siswa' => $siswa,
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

        return view('absen/absenList', $data);
    }


    function data_table(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];
        $kls = $data_post['kls'];
        $sub_kelas = $data_post['subkelas'];

        if ($keywords) {
            $total_data = mAbsen
                ::whereLike('id_absen', $keywords)
                ->orWhereLike('abs_nomber', $keywords)
                ->count();
        } else {
            $total_data = mAbsen
                ::count();
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_absen'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mAbsen
            ::with('siswa');
        if ($keywords) {
            $data_list = $data_list
                ->whereLike('id_absen', $keywords)
                ->orWhereLike('abs_nomber', $keywords);
        }
        $data_list = $data_list
            ->offset($start)
            ->limit($limit)
            ->orderBy($order_column, $order_type)
            ->whereHas('kelas', function ($q) use ($kls, $sub_kelas) {
                return $q->where('kls_nama', $kls)->where('sub_kelas', $sub_kelas);
            })
            ->get();

        $total_data++;

        $data = array();
        $no = 1;
        foreach ($data_list as $key => $row) {
            $key++;
            $id_absen = Main::encrypt($row->id_absen);

            // if ($order_type == 'asc') {
            //     $no = $key + $start;
            // } else {
            //     $no = $total_data - $key - $start;
            // }

            $nestedData['no'] = $no++;
            $nestedData['swa_nis'] = $row->siswa->swa_nis;
            $nestedData['swa_nama'] = $row->siswa->swa_nama;
            // $nestedData['kls_nama'] = $row->siswa->kelas->kls_nama;
            $nestedData['abs_tanggal'] = $row->abs_tanggal;
            $nestedData['abs_keterangan'] = $row->abs_keterangan;
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
                            data-route="' . route('absenEditModal', ['id_absen' => $id_absen]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('absenDelete', ['id_absen' => $id_absen]) . '">
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
            'id_siswa' => 'required',
            // 'id_kelas' => 'required',
            'abs_tanggal' => 'required',
            'abs_keterangan' => 'required',
        ]);

        $data = $request->except('_token');
        $siswa = mSiswa::where('id_siswa', $request->id_siswa)->first();
        $data['id_kelas'] = $siswa->id_kelas;
        mAbsen::create($data);
    }

    function edit_modal($id_absen)
    {
        $id_absen = Main::decrypt($id_absen);
        $edit = mAbsen::with('siswa')->where('id_absen', $id_absen)->first();
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();
        $siswa = mSiswa::orderBy('swa_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'kelas' => $kelas,
            'siswa' => $siswa

        ];

        return view('absen/absenEditModal', $data);
    }


    function delete($id_absen)
    {
        $id_absen = Main::decrypt($id_absen);
        mAbsen::where('id_absen', $id_absen)->delete();
    }

    function update(Request $request, $id_absen)
    {
        $id_absen = Main::decrypt($id_absen); 
        $request->validate([
            // 'id_siswa' => 'required',
            // 'id_kelas' => 'required',
            'abs_tanggal' => 'required',
            'abs_keterangan' => 'required',

        ]);
        $data = $request->except("_token");
        mAbsen::where(['id_absen' => $id_absen])->update($data);
    }
}
