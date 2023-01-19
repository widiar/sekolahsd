<?php

namespace app\Http\Controllers\MasterData;

use app\Helpers\Main;
use app\Models\mUser;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

use app\Models\mUserRole;
use DB;
use Illuminate\Support\Facades\Session;

class UserRole extends Controller
{

    private $breadcrumb;
    private $menuActive;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->menuActive = $cons['master_role_user'];
        $this->breadcrumb = [
            [
                'label' => $cons['masterData'],
                'route' => ''
            ],
            [
                'label' => $cons['master_role_user'],
                'route' => ''
            ]
        ];
    }

    function index()
    {
        $data = Main::data($this->breadcrumb);
        $data['list'] = mUserRole::orderBy('role_name', 'ASC')->get();

        return view('masterData/userRole/userRoleList', $data);
    }

    function insert(Request $request)
    {
        $request->validate([
            'role_name' => 'required'
        ]);

        $data = $request->except('_token');
        mUserRole::create($data);
    }

    function delete($id)
    {
        $id = Main::decrypt($id);
        $check_user = mUser::where('id_user_role', $id)->count();

        if ($check_user > 0) {
            $response = [
                'title' => 'Perhatian ...',
                'message' => 'Role User sudah digunakan di <strong>Menu ' . Main::menuAction(Config::get('constants.topMenu.master_5')) . '</strong>'
            ];
            return response($response, 422);
        } else {
            mUserRole::where('id', $id)->delete();
        }
    }

    function edit($id)
    {
        $id = Main::decrypt($id);
        $edit = mUserRole::where('id', $id)->first();
        $data = [
            'edit' => $edit
        ];
        return view('masterData/userRole/userRoleEditModal', $data);
    }

    function update(Request $request, $id)
    {
        $request->validate([
            'role_name' => 'required'
        ]);

        $id = Main::decrypt($id);
        $data = $request->except("_token");
        mUserRole::where(['id' => $id])->update($data);
        return redirect(route('userRolePage'));
    }

    function akses($id)
    {
        $id = Main::decrypt($id);
        $breadcrumb = array_merge($this->breadcrumb, [
            [
                'label' => 'Akses',
                'route' => ''
            ]
        ]);
        $data = Main::data($breadcrumb, $this->menuActive);
        $data['role'] = mUserRole::where('id', $id)->first();
        $data['pageTitle'] = 'Role User - ' . $data['role']->role_name;
        $data['menuList'] = Main::menuAdministrator();
        $data['no_2'] = 1;
        $data['no_3'] = 100;
        $data['role_akses'] = json_decode($data['role']->role_akses, TRUE);

        return view('masterData/userRole/userRoleAkses', $data);
    }

    /**
     * Digunakan untuk menyimpan user role tertentu
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    function akses_update(Request $request, $id)
    {
        $user = Session::get('user');
        $id = Main::decrypt($id);
        $role = $request->input('role');
        $menu = Main::menuAdministrator();
        $role_akses = [];

        /**
         * foreach default menu administrator yang ada
         */
        foreach ($menu as $key => $r_menu) {
            /**
             * Check, apakah box akses semua tercentang atau tidak pada Parent Menu
             */
            $status = FALSE;
            if (isset($role[$key]['akses_menu']) && $role[$key]['akses_menu'] == TRUE) {
                $status = TRUE;
            }

            $role_akses[$key]['akses_menu'] = $status;

            /**
             * Check, apakah Parent Menu langsung memiliki action button atau tidak,
             * jika ada, maka action button tersebut, tercentang atau tidak
             */
            if (isset($r_menu['action'])) {
                foreach ($r_menu['action'] as $r_action) {
                    $status_action = FALSE;
                    if (isset($role[$key][$r_action]) && $role[$key][$r_action] == TRUE) {
                        $status_action = TRUE;
                    }

                    $role_akses[$key]['action'][$r_action] = $status_action;
                }
                /**
                 * Check, jika tidak mempunyai Action Button,
                 * maka menu tersebut memiliki sub menu (itu pasti)
                 * lalu action button pada sub menu tersebut, tercentang atau tidak,
                 * jika tercentang, maka return status menjadi TRUE
                 */
            } else {

                if (isset($r_menu['sub'])) {
                    foreach ($r_menu['sub'] as $key_2 => $r_sub) {
                        $status_sub = FALSE;
                        if (isset($role[$key][$key_2]['akses_menu']) && $role[$key][$key_2]['akses_menu'] == TRUE) {
                            $status_sub = TRUE;
                        }

                        $role_akses[$key][$key_2]['akses_menu'] = $status_sub;
                        foreach ($r_sub['action'] as $r_action) {
                            $status_action = FALSE;
                            if (isset($role[$key][$key_2][$r_action]) && $role[$key][$key_2][$r_action] == TRUE) {
                                $status_action = TRUE;
                            }

                            $role_akses[$key][$key_2][$r_action] = $status_action;

                        }

                    }
                }

            }
        }

        /**
         * Update Role Akses
         */
        $data_update = [
            'role_akses' => json_encode($role_akses)
        ];

        if ($user->id_role_akses == $id) {
            $user->user_role->role_akses = json_encode($role_akses);
            mUserRole::where('id', $id)->update($data_update);
            Session::put('user', $user);
        } else {
            mUserRole::where('id', $id)->update($data_update);
        }


        //return response($role_akses, 422);

    }

    /**
     * untuk menghitung berapa jumlah action button yang ada dari semua action button yang di daftarkan,
     * sebelumnya digunakan untuk colspan kolom
     *
     * @return mixed
     */
    function count_action()
    {
        $menu = Main::menuAdministrator();
        $array = [];
        foreach ($menu as $r) {
            if (isset($r['sub'])) {
                foreach ($r['sub'] as $r2) {
                    $array[] = count($r2['action']);
                }
            }
        }

        $max = max($array);
        return $max;
    }
}
