<?php

namespace app\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Hash;
use app\Rules\UsernameChecker;
use app\Rules\UsernameCheckerUpdate;
use Illuminate\Support\Facades\Config;

use app\Models\mKaryawan;
use app\Models\mUser;
use app\Models\mUserRole;
use app\Models\mGuru;
use app\Models\mSiswa;

class User extends Controller
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
                'label' => $cons['master_user'],
                'route' => ''
            ]
        ];
    }

    function index()
    {
        $data = Main::data($this->breadcrumb);
        $user_role = mUserRole::orderBy('role_name', 'ASC')->get();
        $user = mUser::with(['user_role'])->orderBy('username', 'ASC')->get();
        $guru = mGuru::get();
        $siswa = mSiswa::get();

        $data = array_merge($data, [
            'user_role' => $user_role,
            'data' => $user,
            'guru' => $guru,
            'siswa' => $siswa
        ]);

        return view('masterData/user/userList', $data);
    }

    function insert(Request $request)
    {
        $request->validate([
            'id_user_role' => 'required',
            'username' => ['required', new UsernameChecker],
            'password' => 'required'
        ]);

        $data = $request->except('_token');
        if(isset($request->id_guru)) $data['id_karyawan'] = $request->id_guru;
        if(isset($request->id_siswa)) $data['id_karyawan'] = $request->id_siswa;
        $data['password'] = Hash::make($data['password']);
        mUser::create($data);
    }

    function edit_modal($id)
    {
        $id = Main::decrypt($id);
        $user = mUser::where('id', $id)->first();
        $user_role = mUserRole::orderBy('role_name', 'ASC')->get();
        $data = [
            'edit' => $user,
            'user_role' => $user_role,
            'guru' => mGuru::get(),
            'siswa' => mSiswa::get(),
        ];

        return view('masterData/user/userEditModal', $data);
    }

    function delete($id)
    {
        $id = Main::decrypt($id);
        mUser::where('id', $id)->delete();
    }

    function update(Request $request, $id)
    {
        $id = Main::decrypt($id);
        $request->validate([
            'id_user_role' => 'required',
            'username' => ['required', new UsernameCheckerUpdate($id)],
            //'password' => 'required'
        ]);
        $data = $request->except("_token");
        if ($request->input('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $role = mUserRole::where('id', $request->id_user_role)->first();
        if(strtolower($role->role_name) != 'wali kelas' && strtolower($role->role_name) != 'siswa') $data['id_karyawan'] = NULL;
        mUser::where(['id' => $id])->update($data);
    }
}
