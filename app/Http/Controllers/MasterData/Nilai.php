<?php

namespace app\Http\Controllers\MasterData;

use app\Models\mAbsen;
use app\Models\mNilai;
use app\Models\mSiswa;
use app\Models\mKelas;
use app\Models\mMataPelajaran;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;

class Nilai extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->breadcrumb = [
            [
                'label' => $cons['masterData'],
                'route' => ''
            ],
            [
                'label' => $cons['master_nilai'],
                'route' => ''
            ]
        ];
    }

    function index(Request $request)
    {
        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('nilai')
            ->leftJoin('absen', 'absen.id_absen', '=', 'nilai.id_absen')
            ->leftJoin('siswa', 'siswa.id_siswa', '=', 'nilai.id_siswa')
            ->leftJoin('kelas', 'kelas.id_kelas', '=', 'nilai.id_kelas')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id_mata_pelajaran', '=', 'nilai.id_mata_pelajaran')
            ->get();
        $absen = mAbsen::orderBy('abs_nomber', 'ASC')->get();
        $siswa = mSiswa::orderBy('swa_nama', 'ASC')->get();
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->get();

        $data = array_merge($data, [
            'data' => $data_list,
            'absen' => $absen,
            'siswa' => $siswa,
            'kelas' => $kelas,
            'mata_pelajaran' => $mata_pelajaran,
        ]);

        return view('nilai/nilaiList', $data);
    }

    function insert(Request $request)
    {
        $request->validate([
            'id_absen' => 'required',
            'id_siswa' => 'required',
            'id_kelas' => 'required',
            'id_mata_pelajaran' => 'required',
            'nilai' => 'required',
        ]);

        $data = $request->except('_token');
        mNilai::create($data);
    }

    function edit_modal($id_nilai)
    {
        $id_nilai = Main::decrypt($id_nilai);
        $edit = mNilai::where('id_nilai', $id_nilai)->first();
        $absen = mAbsen::orderBy('abs_nomber', 'ASC')->get();
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();
        $siswa = mSiswa::orderBy('swa_nama', 'ASC')->get();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'kelas' => $kelas,
            'siswa' => $siswa,
            'absen' => $absen,
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
            'id_absen' => 'required',
            'id_siswa' => 'required',
            'id_kelas' => 'required',
            'id_mata_pelajaran' => 'required',
            'nilai' => 'required',

        ]);
        $data = $request->except("_token");
        mNilai::where(['id_nilai' => $id_nilai])->update($data);
    }
}
