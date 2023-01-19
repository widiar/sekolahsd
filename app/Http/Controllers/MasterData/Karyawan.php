<?php

namespace app\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use app\Helpers\Main;
use Illuminate\Support\Facades\Route;

use app\Models\mKaryawan;

class Karyawan extends Controller
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
                'label' => $cons['master_staf'],
                'route' => ''
            ]
        ];
    }

    function index()
    {
        $data = Main::data($this->breadcrumb);
        $data = array_merge($data, [
            'data' => mKaryawan::orderBy('nama_karyawan', 'ASC')->get()
        ]);
        return view('masterData/karyawan/karyawanList', $data);
    }

    function insert(Request $request)
    {
        $request->validate([
            'nama_karyawan' => 'required',
            'posisi_karyawan' => 'required',
            'telp_karyawan' => 'required',
            'alamat_karyawan' => 'required',
            'email_karyawan' => 'required|email',
        ]);

        $data = $request->except(['_token']);

        mKaryawan::create($data);
    }

    function edit_modal($id)
    {
        $id = Main::decrypt($id);
        $karyawan = mKaryawan::where('id', $id)->first();
        $data = [
            'edit' => $karyawan
        ];

        return view('masterData/karyawan/karyawanEditModal', $data);
    }

    function delete($id)
    {
        $id = Main::decrypt($id);
        mKaryawan::where('id', $id)->delete();
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'nama_karyawan' => 'required',
            'posisi_karyawan' => 'required',
            'telp_karyawan' => 'required',
            'alamat_karyawan' => 'required',
            'email_karyawan' => 'required|email'
        ]);

        $id = Main::decrypt($id);
        $data = $request->except(["_token"]);

        mKaryawan::where(['id' => $id])->update($data);
    }
}
