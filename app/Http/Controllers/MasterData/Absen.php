<?php

namespace app\Http\Controllers\MasterData;

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
                'label' => $cons['masterData'],
                'route' => ''
            ],
            [
                'label' => $cons['master_absen'],
                'route' => ''
            ]
        ];
    }

    function index(Request $request)
    {
        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('absen')
            ->leftJoin('siswa', 'siswa.id_siswa', '=', 'absen.id_siswa')
            ->leftJoin('kelas', 'kelas.id_kelas', '=', 'absen.id_kelas')
            ->get();
        $siswa = mSiswa::orderBy('swa_nama', 'ASC')->get();
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();

        $data = array_merge($data, [
            'data' => $data_list,
            'siswa' => $siswa,
            'kelas' => $kelas,

        ]);

        return view('absen/absenList', $data);
    }

    function insert(Request $request)
    {
        $request->validate([
            'abs_nomber' => 'required',
            'id_siswa' => 'required',
            'id_kelas' => 'required',
            'abs_tanggal' => 'required',
            'abs_keterangan' => 'required',
        ]);

        $data = $request->except('_token');
        mAbsen::create($data);
    }

    function edit_modal($id_absen)
    {
        $id_absen = Main::decrypt($id_absen);
        $edit = mAbsen::where('id_absen', $id_absen)->first();
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
            'abs_nomber' => 'required',
            'id_siswa' => 'required',
            'id_kelas' => 'required',
            'abs_tanggal' => 'required',
            'abs_keterangan' => 'required',

        ]);
        $data = $request->except("_token");
        mAbsen::where(['id_absen' => $id_absen])->update($data);
    }
}
