<?php

namespace app\Http\Controllers\General;

use app\Models\mDistributor;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use app\Models\mKaryawan;
use app\Models\mUser;

use app\Rules\UsernameCheckerUpdate;
use app\Rules\UsernameDistributorCheckerUpdate;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class Profile extends Controller
{

    function index()
    {
        $breadcrumb = [
            [
                'label' => 'Profil',
                'route' => ''
            ]
        ];
        $data = Main::data($breadcrumb);
        return view('general/profile_administrator', $data);
    }

    function update_administrator(Request $request)
    {
        $user = Session::get('user');
        $id = $user->id;
        $id_karyawan = $user->id_karyawan;

        $request->validate([
            'username' => ['bail', 'required', new UsernameCheckerUpdate($id)],
            'password' => 'bail',
            'password_confirm' => 'bail|same:password',
            'nama_karyawan' => 'required',
            'alamat_karyawan' => 'required',
            'telp_karyawan' => 'required',
            'posisi_karyawan' => 'required',
            'email_karyawan' => 'bail|required|email'
        ]);

        $data_user = [
            'username' => $request->input('username'),
        ];
        if ($request->filled('password')) {
            $data_user['password'] = Hash::make($request->input('password'));
        }

        mUser::where('id', $id)->update($data_user);

        $data_karyawan = [
            'nama_karyawan' => $request->nama_karyawan,
            'alamat_karyawan' => $request->alamat_karyawan,
            'telp_karyawan' => $request->telp_karyawan,
            'posisi_karyawan' => $request->posisi_karyawan,
            'email_karyawan' => $request->email_karyawan
        ];

        if ($request->hasFile('foto_karyawan')) {
            $file = $request->file('foto_karyawan');
            $file->move('upload', $file->getClientOriginalName());
            $data_karyawan['foto_karyawan'] = $file->getClientOriginalName();
        }
        mKaryawan::where('id', $id_karyawan)->update($data_karyawan);

        $user = mUser::with('karyawan')->where('id', $id)->first();
        Session::put(['user' => $user]);

    }

    function update_distributor(Request $request)
    {
        $user = Session::get('user');
        $id_distributor = $user->id;

        $request->validate([
            'username' => ['bail', 'required', new UsernamedistributorCheckerUpdate($id_distributor)],
            'password' => 'bail',
            'password_confirm' => 'bail|same:password',
            'nama_distributor' => 'required',
            'alamat_distributor' => 'required',
            'telp_distributor' => 'required',
            'email_distributor' => 'bail|required|email'
        ]);

        $data_distributor = [
            'username' => $request->input('username'),
        ];
        if ($request->filled('password')) {
            $data_distributor['password'] = Hash::make($request->input('password'));
        }

        mDistributor::where('id', $id_distributor)->update($data_distributor);

        $data_distributor = [
            'nama_distributor' => $request->nama_distributor,
            'alamat_distributor' => $request->alamat_distributor,
            'telp_distributor' => $request->telp_distributor,
            'email_distributor' => $request->email_distributor
        ];

        if ($request->hasFile('foto_distributor')) {
            $file = $request->file('foto_distributor');
            $file->move('upload', $file->getClientOriginalName());
            $data_distributor['foto_distributor'] = $file->getClientOriginalName();
        }
        mDistributor::where('id', $id_distributor)->update($data_distributor);

        $user = mDistributor::find($id_distributor);

        if ($user->foto_distributor == '') {
            $user->foto_distributor = 'empty.png';
        }

        Session::put(['user' => $user]);

    }
}
