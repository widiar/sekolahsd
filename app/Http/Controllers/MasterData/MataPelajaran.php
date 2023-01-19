<?php

namespace app\Http\Controllers\MasterData;

use app\Models\mMataPelajaran;
use app\Models\mGuru;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;

class MataPelajaran extends Controller
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
                'label' => $cons['master_mata_pelajaran'],
                'route' => ''
            ]
        ];
    }

    function index()
    {
        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('mata_pelajaran')
            ->leftJoin('guru', 'guru.id_guru', '=', 'mata_pelajaran.id_guru')
            ->get();
        $guru = mGuru::orderBy('gru_nama', 'ASC')->get();

        $data = array_merge($data, [
            'data' => $data_list,
            'guru' => $guru,
        ]);

        return view('matapelajaran/matapelajaranList', $data);
    }

    function insert(Request $request)
    {
        $request->validate([
            'mpj_kode' => 'required',
            'mpj_nama' => 'required',
            'id_guru' => 'required',
        ]);

        $data = $request->except('_token');
        mMataPelajaran::create($data);
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

    function delete($id_mata_pelajaran)
    {
        $id_mata_pelajaran = Main::decrypt($id_mata_pelajaran);
        mMataPelajaran::where('id_mata_pelajaran', $id_mata_pelajaran)->delete();
    }

    function update(Request $request, $id_mata_pelajaran)
    {
        $id_mata_pelajaran = Main::decrypt($id_mata_pelajaran);
        $request->validate([
            'mpj_kode' => 'required',
            'mpj_nama' => 'required',
            'id_guru' => 'required',
        ]);
        $data = $request->except("_token");
        mMataPelajaran::where(['id_mata_pelajaran' => $id_mata_pelajaran])->update($data);
    }
}
