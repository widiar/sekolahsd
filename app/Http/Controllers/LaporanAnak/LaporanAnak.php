<?php

namespace app\Http\Controllers\LaporanAnak;

use app\Models\mGuru;
use app\Models\mKelas;
use app\Models\mLaporanAnak;
use app\Models\mNilai;
use app\Models\mOrangTua;
use app\Models\mSiswa;
use app\Models\mMataPelajaran;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LaporanAnak extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->breadcrumb = [
            [
                'label' => $cons['laporan_anak'],
                'route' => ''
            ]
        ];
    }

    function index(Request $request)
    {
        $user = Session::get('user');
        if(isset($user->id_karyawan)){
            $id_siswa = $user->id_karyawan;
            $id_orang_tua = mOrangTua::where('id_siswa', $id_siswa)->first()->id_orang_tua;
        }
        else if(isset($user->id_siswa)){
            $id_siswa = $user->id_siswa;
            $id_orang_tua = $user->id_orang_tua;
        }

        $siswa = mSiswa::where('id_siswa', $id_siswa)->first();
        $nilai = mNilai::where('id_siswa', $id_siswa)->get();
        $orang_tua = mOrangTua::where('id_orang_tua', $id_orang_tua)->first();

        // dd($user, $siswa);
        $kelas = mKelas::where('id_kelas', $siswa->id_kelas)->first();
        $guru_wali = mGuru::where('id_guru', $kelas->id_guru)->first();

        $data = [
            'siswa' => $siswa,
            'nilai' => $nilai,
            'guru_wali' => $guru_wali,
            'orang_tua' => $orang_tua
        ];
        // dd($data,$user);

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->loadView('laporananak/laporananakPdf', $data);

        return $pdf
            ->setPaper('A4', 'portrait')
            ->stream('Raport Anak');
    }


    function data_table(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];

        if ($keywords) {
            $total_data = mLaporanAnak
                ::whereLike('id_laporan_anak', $keywords)
                ->orWhereLike('lpa_nilai', $keywords)
                ->count();
        } else {
            $total_data = mLaporanAnak
                ::count();
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_laporan_anak'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mLaporanAnak
            ::with('siswa');
        if ($keywords) {
            $data_list = $data_list
                ->whereLike('id_laporan_anak', $keywords)
                ->orWhereLike('ort_nama_ayah', $keywords);
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
            $id_laporan_anak = Main::encrypt($row->id_laporan_anak);

            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['no'] = $no;
            $nestedData['swa_nama'] = $row->siswa->swa_nama;
            $nestedData['mpj_nama'] = $row->mata_pelajaran->mpj_nama;
            $nestedData['lpa_nilai'] = $row->lpa_nilai;
            $nestedData['lpa_keterangan_guru'] = $row->lpa_keterangan_guru;
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
                            data-route="' . route('laporananakEditModal', ['id_laporan_anak' => $id_laporan_anak]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('laporananakDelete', ['id_laporan_anak' => $id_laporan_anak]) . '">
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
            'id_mata_pelajaran' => 'required',
            'lpa_nilai' => 'required',
            'lpa_keterangan_guru' => 'required',
        ]);

        $data = $request->except('_token');
        mLaporanAnak::create($data);
    }

    function edit_modal($id_laporan_anak)
    {
        $id_laporan_anak = Main::decrypt($id_laporan_anak);
        $edit = mLaporanAnak::where('id_laporan_anak', $id_laporan_anak)->first();
        $siswa = mSiswa::orderBy('swa_nama', 'ASC')->get();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'siswa' => $siswa,
            'mata_pelajaran' => $mata_pelajaran,
        ];

        return view('laporananak/laporananakEditModal', $data);
    }

    function delete($id_laporan_anak)
    {
        $id_laporan_anak = Main::decrypt($id_laporan_anak);
        mLaporanAnak::where('id_laporan_anak', $id_laporan_anak)->delete();
    }

    function update(Request $request, $id_laporan_anak)
    {
        $id_laporan_anak = Main::decrypt($id_laporan_anak);
        $request->validate([
            'id_siswa' => 'required',
            'id_mata_pelajaran' => 'required',
            'lpa_nilai' => 'required',
            'lpa_keterangan_guru' => 'required',
        ]);
        $data = $request->except("_token");
        mLaporanAnak::where(['id_laporan_anak' => $id_laporan_anak])->update($data);
    }
}
