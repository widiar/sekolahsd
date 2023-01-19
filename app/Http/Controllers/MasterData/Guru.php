<?php

namespace app\Http\Controllers\MasterData;

use app\Models\mGuru;
use app\Models\mMataPelajaran;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;

class Guru extends Controller
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
                'label' => $cons['guru'],
                'route' => ''
            ]
        ];
    }

    function index()
    {
        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('guru')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id_mata_pelajaran', '=', 'guru.id_mata_pelajaran')
            ->get();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->get();

        $data = array_merge($data, [
            'data' => $data_list,
            'mata_pelajaran' => $mata_pelajaran,
        ]);

        return view('guru/guruList', $data);
    }

    function insert(Request $request)
    {
        $request->validate([
            'gru_nip' => 'required',
            'gru_nama' => 'required',
            'id_mata_pelajaran' => 'required',
            'gru_alamat' => 'required',
        ]);

        $data = $request->except('_token');
        mGuru::create($data);
    }

    function edit_modal($id_guru)
    {
        $id_guru = Main::decrypt($id_guru);
        $edit = mGuru::where('id_guru', $id_guru)->first();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'mata_pelajaran' => $mata_pelajaran,
        ];

        return view('guru/guruEditModal', $data);
    }

    function delete($id_guru)
    {
        $id_guru = Main::decrypt($id_guru);
        mGuru::where('id_guru', $id_guru)->delete();
    }

    function update(Request $request, $id_guru)
    {
        $id_guru = Main::decrypt($id_guru);
        $request->validate([
            'gru_nip' => 'required',
            'gru_nama' => 'required',
            'id_mata_pelajaran' => 'required',
            'gru_alamat' => 'required',
        ]);
        $data = $request->except("_token");
        mGuru::where(['id_guru' => $id_guru])->update($data);
    }
}
