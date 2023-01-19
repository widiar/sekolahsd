<?php

namespace app\Http\Controllers\MasterData;

use app\Models\mMataPelajaran;
use app\Models\mJadwal;
use app\Models\mKelas;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;

class Jadwal extends Controller
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
                'label' => $cons['jadwal'],
                'route' => ''
            ]
        ];
    }

    function index(Request $request)
    {
        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('jadwal')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id_mata_pelajaran', '=', 'jadwal.id_mata_pelajaran')
            ->leftJoin('kelas', 'kelas.id_kelas', '=', 'jadwal.id_kelas')
            ->get();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->get();
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();

        $data = array_merge($data, [
            'data' => $data_list,
            'mata_pelajaran' => $mata_pelajaran,
            'kelas' => $kelas,
        ]);

        return view('jadwal/jadwalList', $data);
    }

    function insert(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required',
            'jam_dari' => 'required',
            'jam_ke' => 'required',
            'id_mata_pelajaran' => 'required',
            'hari' => 'required',


        ]);

        $data = $request->except('_token');
        mJadwal::create($data);
    }

    function edit_modal($id_jadwal)
    {
        $id_jadwal = Main::decrypt($id_jadwal);
        $edit = mJadwal::where('id_jadwal', $id_jadwal)->first();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'mata_pelajaran' => $mata_pelajaran
        ];

        return view('jadwal/jadwalEditModal', $data);
    }


    function delete($id_jadwal)
    {
        $id_jadwal = Main::decrypt($id_jadwal);
        mJadwal::where('id_jadwal', $id_jadwal)->delete();
    }

    function update(Request $request, $id_jadwal)
    {
        $id_jadwal = Main::decrypt($id_jadwal);
        $request->validate([
            'jam_dari' => 'required',
            'jam_ke' => 'required',
            'id_mata_pelajaran' => 'required',
            'hari' => 'required',
        ]);
        $data = $request->except("_token");
        mJadwal::where(['id_jadwal' => $id_jadwal])->update($data);
    }
}
