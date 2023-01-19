<?php

namespace app\Http\Controllers\MasterData;

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
                'label' => $cons['masterData'],
                'route' => ''
            ],
            [
                'label' => $cons['master_kelas'],
                'route' => ''
            ]
        ];
    }

    function index(Request $request)
    {
        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('kelas')
            ->leftJoin('guru', 'guru.id_guru', '=', 'kelas.id_guru')
            ->get();
        $guru = mGuru::orderBy('gru_nama', 'ASC')->get();

        $data = array_merge($data, [
            'data' => $data_list,
            'guru' => $guru,

        ]);

        return view('kelas/kelasList', $data);
    }

    function insert(Request $request)
    {
        $request->validate([
            'kls_nama' => 'required',
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
