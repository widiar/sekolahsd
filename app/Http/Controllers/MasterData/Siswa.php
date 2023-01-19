<?php

namespace app\Http\Controllers\MasterData;

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
                'label' => $cons['masterData'],
                'route' => ''
            ],
            [
                'label' => $cons['master_siswa'],
                'route' => ''
            ]
        ];
    }

    function index(Request $request)
    {
        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('siswa')
            ->leftJoin('kelas', 'kelas.id_kelas', '=', 'siswa.id_kelas')
            ->get();
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();

        $data = array_merge($data, [
            'data' => $data_list,
            'kelas' => $kelas,

        ]);

        return view('siswa/siswaList', $data);
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
