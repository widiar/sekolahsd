<?php

namespace app\Http\Controllers\MasterData;

use app\Models\mOrangTua;
use app\Models\mSiswa;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;

class OrangTua extends Controller
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
                'label' => $cons['master_orang_tua'],
                'route' => ''
            ]
        ];
    }

    function index(Request $request)
    {
        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('orang_tua')
            ->leftJoin('siswa', 'siswa.id_siswa', '=', 'orang_tua.id_siswa')
            ->get();
        $siswa = mSiswa::orderBy('swa_nama', 'ASC')->get();

        $data = array_merge($data, [
            'data' => $data_list,
            'siswa' => $siswa,
        ]);

        return view('orangtua/orangtuaList', $data);
    }

    function insert(Request $request)
    {
        $request->validate([
            'ort_nama_ayah' => 'required',
            'ort_nama_ibu' => 'required',
            'id_siswa' => 'required',
            'ort_alamat' => 'required',
        ]);

        $data = $request->except('_token');
        mOrangTua::create($data);
    }

    function edit_modal($id_orang_tua)
    {
        $id_orang_tua = Main::decrypt($id_orang_tua);
        $edit = mOrangTua::where('id_orang_tua', $id_orang_tua)->first();
        $siswa = mSiswa::orderBy('swa_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'siswa' => $siswa,
        ];

        return view('orangtua/orangtuaEditModal', $data);
    }

    function delete($id_orang_tua)
    {
        $id_orang_tua = Main::decrypt($id_orang_tua);
        mOrangTua::where('id_orang_tua', $id_orang_tua)->delete();
    }

    function update(Request $request, $id_orang_tua)
    {
        $id_orang_tua = Main::decrypt($id_orang_tua);
        $request->validate([
            'ort_nama_ayah' => 'required',
            'ort_nama_ibu' => 'required',
            'id_siswa' => 'required',
            'ort_alamat' => 'required',
        ]);
        $data = $request->except("_token");
        mOrangTua::where(['id_orang_tua' => $id_orang_tua])->update($data);
    }
}
