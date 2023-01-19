<?php

namespace app\Http\Controllers\Nilai;

use app\Models\mNilai;
use app\Models\mSiswa;
use app\Models\mKelas;
use app\Models\mAbsen;
use app\Models\mMataPelajaran;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use app\Models\mGuru;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Nilai extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->breadcrumb = [
            [
                'label' => $cons['nilai'],
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

        // dd($kls);
        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('nilai')
            ->leftJoin('absen', 'absen.id_absen', '=', 'nilai.id_absen')
            ->leftJoin('siswa', 'siswa.id_siswa', '=', 'nilai.id_siswa')
            ->leftJoin('kelas', 'kelas.id_kelas', '=', 'nilai.id_kelas')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id_mata_pelajaran', '=', 'nilai.id_mata_pelajaran')
            ->get();
        $absen = mAbsen::orderBy('abs_nomber', 'ASC')->get();
        $klspl = mKelas::where('kls_nama', $kls)->orderBy('sub_kelas', 'asc')->pluck('id_kelas');
        $siswa = mSiswa::with('kelas')->orderBy('swa_nama', 'ASC')->whereIn('id_kelas', $klspl)->get();
        // dd($siswa);
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();
        $kelaspilih = mKelas::where('kls_nama', $kls)->orderBy('sub_kelas', 'asc')->get();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->where('mpj_kelas', $kls)->get();
        $datatable_column = [
            ["data" => "no"],
            ["data" => "swa_nis"],
            ["data" => "swa_nama"],
            // ["data" => "kls_nama"],
            ["data" => "mpj_nama"],
            ["data" => "nilai"],
            ["data" => "options"],
        ];


        $data = array_merge($data, [
            'data' => $data_list,
            'absen' => $absen,
            'siswa' => $siswa,
            'kelas' => $kelas,
            'kelaspilih' => $kelaspilih,
            'mata_pelajaran' => $mata_pelajaran,
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
        // dd($data);
        return view('nilai/nilaiList', $data);
    }


    function data_table(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];
        $kls = $data_post['kls'];
        $sub_kelas = $data_post['subkelas'];

        if ($keywords) {
            $total_data = mNilai
                ::whereLike('id_nilai', $keywords)
                ->orWhereLike('nilai', $keywords)
                ->count();
        } else {
            $total_data = mNilai
                ::count();
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_nilai'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mNilai
            ::with('siswa');
        if ($keywords) {
            $data_list = $data_list
                ->whereLike('id_nilai', $keywords)
                ->orWhereLike('nilai', $keywords);
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
        foreach ($data_list as $key => $row) {
            $key++;
            $id_nilai = Main::encrypt($row->id_nilai);

            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['no'] = $no;
            $nestedData['swa_nis'] = $row->siswa->swa_nis;
            $nestedData['swa_nama'] = $row->siswa->swa_nama;
            // $nestedData['kls_nama'] = $row->kelas->kls_nama;
            $nestedData['mpj_nama'] = $row->mata_pelajaran->mpj_nama;
            $nestedData['nilai'] = $row->nilai;
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
                            data-route="' . route('nilaiEditModal', ['id_nilai' => $id_nilai]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('nilaiDelete', ['id_nilai' => $id_nilai]) . '">
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
            'id_kelas' => 'required',
            'id_mata_pelajaran' => 'required',
            'nilai' => 'required',
        ]);
        $data = $request->except('_token');

        $siswa = mSiswa::where('id_siswa', $request->id_siswa)->first();
        $data['id_kelas'] = $siswa->id_kelas;
        mNilai::create($data);
    }

    function edit_modal($id_nilai)
    {
        $id_nilai = Main::decrypt($id_nilai);
        $edit = mNilai::with('siswa', 'mata_pelajaran')->where('id_nilai', $id_nilai)->first();
        $absen = mAbsen::orderBy('abs_nomber', 'ASC')->get();
        $siswa = mSiswa::orderBy('swa_nama', 'ASC')->get();
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'absen' => $absen,
            'siswa' => $siswa,
            'kelas' => $kelas,
            'mata_pelajaran' => $mata_pelajaran,
        ];

        return view('nilai/nilaiEditModal', $data);
    }

    function delete($id_nilai)
    {
        $id_nilai = Main::decrypt($id_nilai);
        mNilai::where('id_nilai', $id_nilai)->delete();
    }

    function update(Request $request, $id_nilai)
    {
        $id_nilai = Main::decrypt($id_nilai);
        $request->validate([
            // 'id_siswa' => 'required',
            // 'id_kelas' => 'required',
            // 'id_mata_pelajaran' => 'required',
            'nilai' => 'required',
        ]);
        $data = $request->except("_token");
        mNilai::where(['id_nilai' => $id_nilai])->update($data);
    }
}
