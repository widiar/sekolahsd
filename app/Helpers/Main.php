<?php

namespace app\Helpers;

use app\Models\mMataPelajaran;
use app\Models\mJadwal;
use app\Models\mGuru;
use app\Models\mKelas;
use app\Models\mSiswa;
use app\Models\mOrangTua;
use app\Models\mUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Config;

use Illuminate\View\View;


class Main
{
    public static $date_format_view = 'd F Y H:i';
    public static $error = 'error';
    public static $success = 'success';
    public static $get = 'Success getting data';
    public static $store = 'Storing data success';
    public static $update = 'Updating data success';
    public static $delete = 'Removing data success';
    public static $import = 'Importing data success';
    public static $website_official = 'http://intiru.com';


    public static function data($breadcrumb = array(), $menuActive = '')
    {
        $user = Session::get('user');
        $user_role = Session::get('user_role');
        //        $users = mUser::where('id', $user->id)->with('user_role')->first();

        $user_foto = $user->foto;
        $user_nama = $user->nama;
        $user_email = '';

        $data['menu'] = Main::generateTopMenu($menuActive);
        $data['menuAction'] = Main::menuActionData($menuActive);
        $data['footer'] = Main::footer();
        $data['metaTitle'] = Main::metaTitle($breadcrumb);
        $data['pageTitle'] = Main::pageTitle($breadcrumb);
        $data['breadcrumb'] = Main::breadcrumb($breadcrumb);
        $data['user'] = $user;
        $data['user_role_data'] = $user_role['role_akses'];
        $data['user_role_name'] = $user_role['role_name'];
        $data['user_foto'] = $user_foto;
        $data['user_nama'] = $user_nama;
        $data['user_email'] = $user_email;
        $data['pageMethod'] = '';
        $data['no'] = 1;
        $data['imgWidth'] = 100;
        $data['decimalStep'] = '.01';
        $data['roundDecimal'] = 2;
        $data['ppnPersen'] = Config::get('constants.ppnPersen');
        $data['methodProses'] = '';

        $data['cons'] = Config::get('constans');

        return $data;
    }

    public static function companyInfo()
    {
        $data = [
            'bankType' => Config::get('constants.bankType'),
            'bankRekening' => Config::get('constants.bankRekening'),
            'bankAtasNama' => Config::get('constants.bankAtasNama'),
            'companyName' => Config::get('constants.companyName'),
            'companyAddress' => Config::get('constants.companyAddress'),
            'companyPhone' => Config::get('constants.companyPhone'),
            'companyTelp' => Config::get('constants.companyTelp'),
            'companyEmail' => Config::get('constants.companyEmail'),
            'companyBendahara' => Config::get('constants.companyBendahara'),
            'companyTuju' => Config::get('constants.companyTuju'),
        ];

        $data = (object)$data;

        return $data;
    }

    public static function response($status = 'error', $message = 'Empty', $data = NULL, $errors = NULL)
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'errors' => $errors
        ];
    }

    public static function access_menu_first()
    {
        $user_role = Session::get('user_role')->role_akses;
        $user_role = json_decode($user_role, TRUE);
        $first_menu_active_route = '';
        $cons = Config::get('constants.topMenu');
        $main_menu = Main::menuAdministrator();

        foreach ($user_role as $key => $row) {
            if ($row['akses_menu']) {
                $first_menu_active_route = $main_menu[$cons[$key]]['route'];
                break;
            }
        }

        return $first_menu_active_route;
    }

    public static function totalNotification($notifications)
    {
        return count($notifications);
    }

    public static function badgeNotification($totalNotification)
    {
        if ($totalNotification > 0) {
            return '<span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot m-badge--danger"></span>';
        }
        return '';
    }

    public static function terbilang($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = Main::penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = Main::penyebut($nilai / 10) . " puluh" . Main::penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . Main::penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = Main::penyebut($nilai / 100) . " ratus" . Main::penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = Main::penyebut($nilai / 1000) . " ribu" . Main::penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = Main::penyebut($nilai / 1000000) . " juta" . Main::penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = Main::penyebut($nilai / 1000000000) . " milyar" . Main::penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = Main::penyebut($nilai / 1000000000000) . " trilyun" . Main::penyebut(fmod($nilai, 1000000000000));
        }
        return ucwords($temp);
    }

    public static function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }



    public static function generateTopMenu($menuActive)
    {
        //

        $data['routeName'] = Route::currentRouteName();
        $data['menu'] = Main::menuList();
        $data['menuActive'] = $menuActive;
        $data['consMenu'] = Config::get('constants.topMenu');

        $user  = Session::get('user');
        $user2 = mUser::with('user_role')->where('id', $user->id)->first();
        $guru = NULL;
        if($user2)
            if(\strtolower($user2->user_role->role_name) == 'wali kelas')
                $guru = mGuru::where('id_guru', $user->id_karyawan)->first();
        $data['user'] = Session::get('user');
        if($guru){
            $kelas = mKelas::where('id_guru', $guru->id_guru)->get();
            $kelasGuru = [];
            foreach ($kelas as $kls) {
                array_push($kelasGuru, $kls->kls_nama);
            }
            $data['role_guru'] = $kelasGuru;
            $data['is_guru'] = 1;
        }else{
            $data['role_guru'] = [];
            $data['is_guru'] = 0;
        }

        return view('component/menu', $data);
    }

    public static function footer()
    {
        $data = [];
        return view('component/footer', $data);
    }

    public static function format_money($number)
    {
        if (Main::check_decimal($number)) {
            return 'Rp. ' . number_format($number, 2, ',', '.');
        } else {
            return 'Rp. ' . number_format($number, 2, ',', '.');
        }
    }

    public static function unformat_money($number)
    {
        $number = str_replace(['Rp', ''], ['.', ''], [',', '.'], $number);
        $number = self::format_decimal($number);
        return self::format_number($number);
    }

    public static function format_number($number)
    {
        if (Main::check_decimal($number)) {
            return number_format($number, 2, '.', ',');
        } else {
            return number_format($number, 0, '', ',');
        }
    }

    public static function format_number_system($number)
    {
        return number_format($number, 2, ',', '.');
    }

    public static function format_number_db($number)
    {
        $number = str_replace(['.', ','], ['.', ''], $number);
        return number_format($number, 2, '.', '');
    }

    public static function format_decimal($number)
    {
        $number = str_replace(['.', ','], ['.', ''], $number);
        return number_format($number, 0, ',', '.');
    }

    public static function format_discount($number)
    {
        return $number . ' %';
    }

    public static function format_date($date)
    {
        return date('d-m-Y', strtotime($date));
    }

    public static function format_datetime_input($date)
    {
        return date('d-m-Y H:i', strtotime($date));
    }

    public static function date()
    {
        return date('Y-m-d');
    }

    public static function datetime()
    {
        return date('Y-m-d H:i:s');
    }

    public static function format_date_label($date)
    {
        return date('d F Y', strtotime($date));
    }

    public static function format_date_db($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    public static function format_datetime_db($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public static function format_datetime($date)
    {
        return date('d F Y H:i:s', strtotime($date));
    }

    public static function format_datetime_2($date)
    {
        return date('d-m-Y H:i:s', strtotime($date));
    }

    public static function format_time_db($time)
    {
        return date('H:i:s', strtotime($time));
    }

    public static function format_time_label($time)
    {
        return date('h:i A', strtotime($time));
    }

    public static function format_age($date)
    {
        $year = date_diff(date_create($date), date_create('today'))->y;
        $month = date_diff(date_create($date), date_create('today'))->m;
        $label = $year . ' Tahun ' . $month . ' Bulan';

        return $label;
    }

    public static function age($date)
    {
        $year = date_diff(date_create($date), date_create('today'))->y;
        $month = date_diff(date_create($date), date_create('today'))->m;
        $label = $year;

        return $label;
    }

    public static function need_type_label($label, $control_step = '')
    {
        switch ($label) {
            case "consult":
                return 'Konsultasi';
                break;
            case "action":
                return 'Tindakan';
                break;
            case "control":
                return 'Kontrol ke ' . $control_step;
                break;
            case "done":
                return 'Selesai';
                break;
            case "cancel":
                return 'Batal';
                break;
            default:
                return $label;
        }
    }

    public static function need_type_class($label)
    {
        switch ($label) {
            case "consult":
                return 'm-fc-event--light m-fc-event--solid-warning';
                break;
            case "action":
                return 'm-fc-event--solid-info m-fc-event--light';
                break;
            case "control":
                return 'm-fc-event--light m-fc-event--solid-success';
                break;
            case "done":
                return 'm-fc-event--light m-fc-event--solid-primary';
                break;
            case "cancel":
                return '';
                break;
            default:
                return $label;
        }
    }

    public static function need_type_style($label, $control_step = '')
    {
        switch ($label) {
            case "consult":
                return '<span style="background-color: #FFB822; padding: 4px 8px; border-radius: 4px">Konsultasi</span>';
                break;
            case "action":
                return '<span style="background-color: #36A3F6; padding: 4px 8px; border-radius: 4px; color: white">Tindakan</span>';
                break;
            case "control":
                return '<span style="background-color: #34BFA3; padding: 4px 8px; border-radius: 4px; color: white">Kontrol ke ' . $control_step . '</span>';
                break;
            case "done":
                return '<span style="background-color: #5c2fba; padding: 4px 8px; border-radius: 4px; color: white">Selesai</span>';
                break;
            case "cancel":
                return '<span style="background-color: #5c2fba; padding: 4px 8px; border-radius: 4px">Batal</span>';
                break;
            default:
                return $label;
        }
    }

    public static function need_type_class_reguler($label)
    {
        switch ($label) {
            case "consult":
                return 'm-badge m-badge--warning m-badge--wide';
                break;
            case "action":
                return 'm-badge m-badge--info m-badge--wide';
                break;
            case "control":
                return 'm-badge m-badge--success m-badge--wide';
                break;
            case "done":
                return 'm-badge m-badge--primary m-badge--wide';
                break;
            case "cancel":
                return '';
                break;
            default:
                return $label;
        }
    }

    public static function need_type_span($label_raw, $addt = '')
    {

        if ($addt && $label_raw == 'control') {
            $addt = ' ke ' . $addt;
        } else {
            $addt = '';
        }

        $label = Main::need_type_label($label_raw);
        $class = Main::need_type_class_reguler($label_raw);
        $span = '<span class="' . $class . '">' . $label . $addt . '</span>';

        return $span;
    }

    public static function convert_money($str)
    {
        $find = array('Rp', '.', '_', ' ');
        $replace = array('');
        return str_replace($find, $replace, $str);
    }

    public static function encrypt($id)
    {
        return Crypt::encrypt($id);
    }

    public static function decrypt($id)
    {
        return Crypt::decrypt($id);
    }

    public static function convert_number($str)
    {
        $find = array('.', '_', ' ');
        $replace = array('');
        return str_replace($find, $replace, $str);
    }

    public static function convert_discount($str)
    {
        $find = array('%', ' ', '_');
        $replace = array('');
        return str_replace($find, $replace, $str);
    }

    public static function check_decimal($number)
    {
        if ($number - floor($number) >= 0.1) {
            return true;
        } else {
            return false;
        }
    }

    public static function metaTitle($breadcrumb)
    {
        krsort($breadcrumb);
        $title = '';
        foreach ($breadcrumb as $label => $value) {
            $title .= Main::menuAction($value['label']) . ' < ';
        }

        $title .= env("APP_NAME", "Sistem Akademik SD");

        return $title;
    }

    public static function pageTitle($breadcrumb = array())
    {
        krsort($breadcrumb);
        $title = isset($breadcrumb[1]) ? Main::menuAction($breadcrumb[1]['label']) : Main::menuAction($breadcrumb[0]['label']);

        return $title;
    }

    public static function menuAction($string)
    {
        $string = \str_replace('anak', 'siswa', $string);
        $string = str_replace('_', ' ', $string);
        $string = ucwords($string);

        return $string;
    }

    public static function menuStrip($string)
    {
        return str_replace([' ', '/'], '_', strtolower($string));
    }

    public static function menuActionData($menuActive)
    {
        $menuList = Main::menuAdministrator();
        $routeName = Route::currentRouteName();
        $userRole = json_decode(Session::get('user.user_role.role_akses'), TRUE);
        //$menuActive = '';
        $action = [];

        if ($menuActive == '') {
            foreach ($menuList as $menu => $val) {
                if ($val['route'] == $routeName) {
                    $menuActive = $menu;
                    break;
                } else {
                    if (isset($val['sub'])) {
                        foreach ($val['sub'] as $menu_sub => $val_sub) {
                            if ($val_sub['route'] == $routeName) {
                                $menuActive = $menu_sub;
                            }
                        }
                    }
                }
            }
        }
        if ($userRole) {
            foreach ($userRole as $menuName => $menuVal) {
                if ($menuName == $menuActive) {
                    $action = $menuVal;
                } else {
                    foreach ($menuVal as $menuSubName => $menuSubVal) {
                        if ($menuSubName == $menuActive) {
                            $action = $menuSubVal;
                        }
                    }
                }
            }
        }

        return $action;
    }

    public static function string_to_number($text)
    {
        return str_replace(',', '', $text);
    }

    public static function breadcrumb($breadcrumb_extend = array())
    {
        $cons = Config::get('constants.topMenu');

        $breadcrumb[] = [
            'label' => $cons['dashboard_admin'],
            'route' => route('dashboardadminPage')
        ];


        $data['breadcrumb'] = array_merge($breadcrumb, $breadcrumb_extend);
        return view('component.breadcrumb', $data);
    }


    public static function urutan_produk($id_produk, $id_lokasi, $month, $year)
    {
        $urutan = 1;
        $where = [
            'id_produk' => $id_produk,
            'id_lokasi' => $id_lokasi,
            'month' => $month,
            'year' => $year
        ];

        $stok_urutan = mStokProduk::where($where);

        if ($stok_urutan->count() > 0) {
            $urutan_now = $stok_urutan->select('urutan')->orderBy('urutan', 'DESC')->first()->urutan;
            $urutan = $urutan_now + 1;
        }

        return $urutan;
    }

    public static function patient_status($status)
    {
        switch ($status) {
            case "appointment":
                return '<span class="m-badge m-badge--brand m-badge--wide">Appointment</span>';
                break;
            case "consult":
                return '<span class="m-badge m-badge--warning m-badge--wide">Konsultasi</span>';
                break;
            case "action":
                return '<span class="m-badge m-badge--info m-badge--wide">Finalize</span>';
                break;
            case "control":
                return '<span class="m-badge m-badge--success m-badge--wide">Follow Up</span>';
                break;
            case "done":
                return '<span class="m-badge m-badge--brand m-badge--wide">Selesai</span>';
                break;
            case "cancel":
                return '<span class="m-badge m-badge--danger m-badge--wide">Batal</span>';
                break;
            default:
                return '<span class="m-badge m-badge--metal m-badge--wide">-</span>';
        }
    }

    public static function patient_status_raw($status)
    {
        switch ($status) {
            case "appointment":
                return 'Appointment';
                break;
            case "consult":
                return 'Konsultasi';
                break;
            case "action":
                return 'Finalize';
                break;
            case "control":
                return 'Follow Up';
                break;
            case "done":
                return 'Selesai';
                break;
            case "cancel":
                return 'Batal';
                break;
            default:
                return '-';
        }
    }

    public static function status($status)
    {
        switch ($status) {
            case "yes":
                return '<span class="m-badge m-badge--info m-badge--wide">Ya</span>';
                break;
            case "no":
                return '<span class="m-badge m-badge--warning m-badge--wide">Tidak</span>';
                break;
            default:
                return '<span class="m-badge m-badge--metal m-badge--wide">-</span>';
        }
    }

    /**
     * @return array
     *
     * Menu variable
     */
    public static function menuList()
    {

        return Main::menuAdministrator();
    }

    public static function menuAdministrator()
    {
        $cons = Config::get('constants.topMenu');

        return [
            $cons['dashboard_admin'] => [
                'icon' => 'flaticon-dashboard',
                'route' => 'dashboardadminPage',
                'action' => ['list']
            ],

            $cons['dashboard_guru'] => [
                'icon' => 'flaticon-dashboard',
                'route' => 'dashboardguruPage',
                'action' => ['list']
            ],

            $cons['dashboard_kepala_sekolah'] => [
                'icon' => 'flaticon-dashboard',
                'route' => 'dashboardkepsekPage',
                'action' => ['list']
            ],

            $cons['dashboard_orang_tua'] => [
                'icon' => 'flaticon-dashboard',
                'route' => 'dashboardortuPage',
                'action' => ['list']
            ],

            $cons['mata_pelajaran'] => [
                'icon' => 'flaticon-file-2',
                'route' => 'matapelajaranList',
                'action' => [
                    'list',
                    'create',
                    'edit',
                    'delete'
                ]
            ],

            $cons['jadwal'] => [
                'icon' => 'flaticon-file-2',
                'route' => 'jadwalList',
                'action' => [
                    'list',
                    'create',
                    'edit',
                    'delete'
                ],
                'sub' => [
                    'kelas I' => [
                        'route' => 'jadwalListI',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas II' => [
                        'route' => 'jadwalListII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas III' => [
                        'route' => 'jadwalListIII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas IV' => [
                        'route' => 'jadwalListIV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas V' => [
                        'route' => 'jadwalListV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas VI' => [
                        'route' => 'jadwalListVI',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                ]
            ],

            $cons['guru'] => [
                'icon' => 'flaticon-file-2',
                'route' => 'guruList',
                'action' => [
                    'list',
                    'create',
                    'edit',
                    'delete'
                ]
            ],

            $cons['kelas'] => [
                'icon' => 'flaticon-file-2',
                'route' => 'kelasList',
                'action' => [
                    'list',
                    'create',
                    'edit',
                    'delete'
                ],
            ],

            $cons['siswa'] => [
                'icon' => 'flaticon-file-2',
                'route' => 'siswaList',
                'action' => [
                    'list',
                    'create',
                    'edit',
                    'delete'
                ],
                'sub' => [
                    'kelas I' => [
                        'route' => 'siswaList1',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                        'name' => 'I'
                    ],
                    'kelas II' => [
                        'route' => 'siswaListII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                        'name' => 'II'
                    ],
                    'kelas III' => [
                        'route' => 'siswaListIII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                        'name' => 'III'
                    ],
                    'kelas IV' => [
                        'route' => 'siswaListIV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                        'name' => 'IV'
                    ],
                    'kelas V' => [
                        'route' => 'siswaListV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                        'name' => 'V'
                    ],
                    'kelas VI' => [
                        'route' => 'siswaListVI',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                        'name' => 'VI'
                    ],
                ],
            ],

            $cons['orang_tua'] => [
                'icon' => 'flaticon-file-2',
                'route' => 'orangtuaList',
                'action' => [
                    'list',
                    'create',
                    'edit',
                    'delete'
                ]
            ],

            $cons['nilai'] => [
                'icon' => 'flaticon-file-2',
                'route' => 'nilaiList',
                'action' => [
                    'list',
                    'create',
                    'edit',
                    'delete'
                ],
                'sub' => [
                    'kelas I' => [
                        'route' => 'nilaiListI',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas II' => [
                        'route' => 'nilaiListII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas III' => [
                        'route' => 'nilaiListIII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas IV' => [
                        'route' => 'nilaiListIV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas V' => [
                        'route' => 'nilaiListV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas VI' => [
                        'route' => 'nilaiListVI',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                ],
            ],

            $cons['absen'] => [
                'icon' => 'flaticon-file-2',
                'route' => 'absenList',
                'action' => [
                    'list',
                    'create',
                    'edit',
                    'delete'
                ],
                'sub' => [
                    'kelas I' => [
                        'route' => 'absenListI',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas II' => [
                        'route' => 'absenListII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas III' => [
                        'route' => 'absenListIII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas IV' => [
                        'route' => 'absenListIV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas V' => [
                        'route' => 'absenListV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas VI' => [
                        'route' => 'absenListVI',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                ],

            ],

            $cons['laporan_siswa'] => [
                'icon' => 'flaticon-file-2',
                'route' => 'laporansiswaList',
                'action' => [
                    'list',
                    'create',
                    'edit',
                    'delete'
                ]
            ],

            $cons['laporan_anak'] => [
                'icon' => 'flaticon-file-2',
                'route' => 'laporananakList',
                'action' => [
                    'list',
                    'create',
                    'edit',
                    'delete'
                ]
            ],

            $cons['statistik_absensi'] => [
                'icon' => 'flaticon-dashboard',
                'route' => 'statistikabsensiPage',
                'action' => ['list'],
                'sub' => [
                    'kelas I' => [
                        'route' => 'statistikabsensiPageI',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas II' => [
                        'route' => 'statistikabsensiPageII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas III' => [
                        'route' => 'statistikabsensiPageIII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas IV' => [
                        'route' => 'statistikabsensiPageIV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas V' => [
                        'route' => 'statistikabsensiPageV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas VI' => [
                        'route' => 'statistikabsensiPageVI',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                ],
            ],
            $cons['statistik_nilai'] => [
                'icon' => 'flaticon-dashboard',
                'route' => 'statistiknilaiPage',
                'action' => ['list'],
                'sub' => [
                    'kelas I' => [
                        'route' => 'statistiknilaiPageI',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas II' => [
                        'route' => 'statistiknilaiPageII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas III' => [
                        'route' => 'statistiknilaiPageIII',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas IV' => [
                        'route' => 'statistiknilaiPageIV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas V' => [
                        'route' => 'statistiknilaiPageV',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                    'kelas VI' => [
                        'route' => 'statistiknilaiPageVI',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ],
                    ],
                ],
            ],

            $cons['statistik_absensi_anak'] => [
                'icon' => 'flaticon-dashboard',
                'route' => 'statistikabsensianakPage',
                'action' => ['list']
            ],



            /*            $cons['retur'] => [
                            'icon' => 'flaticon-file-2',
                            'route' => 'appointmentList',
                            'action' => [
                                'list',
                                'create_admin',
                                'create_member',
                                'detail',
                                'edit',
                                'delete'
                            ]
                        ],*/


            $cons['masterData'] => [
                'icon' => 'flaticon-cogwheel-2',
                'route' => '#',
                'sub' => [

                    //                    $cons['master_staf'] => [
                    //                        'route' => 'karyawanPage',
                    //                        'action' => [
                    //                            'list',
                    //                            'create',
                    //                            'edit',
                    //                            'delete'
                    //                        ]
                    //                    ],
                    //                    $cons['master_role_user'] => [
                    //                        'route' => 'userRolePage',
                    //                        'action' => [
                    //                            'list',
                    //                            'create',
                    //                            'edit',
                    //                            'delete'
                    //                        ]
                    //                    ],
                    $cons['master_user'] => [
                        'route' => 'userPage',
                        'action' => [
                            'list',
                            'create',
                            'edit',
                            'delete'
                        ]
                    ],
                ],
            ],


        ];
    }


    public static function menuDistributor()
    {
        $cons = Config::get('constants.topMenu');
        return [
            $cons['dashboard'] => [
                'icon' => 'flaticon-dashboard',
                'route' => 'dashboardPage',
            ],
            $cons['transaksi_3'] => [
                'icon' => 'flaticon-arrows',
                'route' => 'orderOnlinePage'
            ]
        ];
    }

    public static function scheduleCalendarModal()
    {
        $appointment = mAppointment::with('patient')->get();
        $data = [
            'appointment' => $appointment
        ];

        $css = '
        <link href="' . asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') . '" rel="stylesheet"
          type="text/css"/>
          ';

        $js = '
    <script src="' . asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') . '"
            type="text/javascript"></script>
            ';

        $js .= view('scheduleCalendar/scheduleCalendar/scheduleCalendarJs', $data);

        $data = [
            'css' => $css,
            'js' => $js,
            'view' => view('scheduleCalendar/scheduleCalendar/scheduleCalendarModal')
        ];

        return $data;
    }

    public static function invoiceNumber()
    {
        $count = mPayment
            ::whereYear('invoice_date', '=', date('Y'))
            ->whereMonth('invoice_date', '=', date('m'))
            ->count();
        if ($count == 0) {
            $invoice_number = 1;
        } else {
            $invoice_number = mPayment
                ::whereYear('invoice_date', '=', date('Y'))
                ->whereMonth('invoice_date', '=', date('m'))
                ->orderBy('invoice_number', 'DESC')
                ->value('invoice_number') + 1;
        }

        return $invoice_number;
    }

    public static function invoiceLabel($invoice_number)
    {
        return 'INV-' . date('Ym-') . str_pad($invoice_number, 3, '0', STR_PAD_LEFT);
    }

    public static function invoice()
    {
        $count = mPembelian
            ::whereYear('pbl_tanggal_order', date('Y'))
            ->whereMonth('pbl_tanggal_order', date('m'))
            ->count();
        if ($count == 0) {
            $number = 1;
        } else {
            $pbl_no_faktur = mPembelian
                ::whereYear('pbl_tanggal_order', '=', date('Y'))
                ->whereMonth('pbl_tanggal_order', '=', date('m'))
                ->orderBy('id_pembelian', 'DESC')
                ->value('pbl_no_faktur');
            $number = substr($pbl_no_faktur, -3, 3);
        }

        $number = intval($number);

        return 'PBL-' . date('Ym-') . str_pad($number, 3, 0, STR_PAD_LEFT);
    }

    public static function fakturPembelian($kode_supplier)
    {
        $count = mPembelian
            ::whereYear('pbl_tanggal_order', date('Y'))
            ->whereMonth('pbl_tanggal_order', date('m'))
            ->count();
        if ($count == 0) {
            $number = 1;
        } else {
            $pbl_no_faktur = mPembelian
                ::whereYear('pbl_tanggal_order', '=', date('Y'))
                ->whereMonth('pbl_tanggal_order', '=', date('m'))
                ->orderBy('id_pembelian', 'DESC')
                ->value('pbl_no_faktur');

            $number = substr($pbl_no_faktur, -3, 3);
            $number = intval($number) + 1;
        }

        return 'PBL/' . $kode_supplier . '/' . date('Y') . '/' . date('m') . '/' . str_pad($number, 3, 0, STR_PAD_LEFT);
    }

    public static function fakturPenjualan($kode_pelanggan)
    {
        $count = mPenjualan
            ::whereYear('pjl_tanggal_penjualan', date('Y'))
            ->whereMonth('pjl_tanggal_penjualan', date('m'))
            ->count();
        if ($count == 0) {
            $number = 1;
        } else {
            $pjl_no_faktur = mPenjualan
                ::whereYear('pjl_tanggal_penjualan', '=', date('Y'))
                ->whereMonth('pjl_tanggal_penjualan', '=', date('m'))
                ->orderBy('id_penjualan', 'DESC')
                ->value('pjl_no_faktur');

            $number = substr($pjl_no_faktur, -3, 3);
            $number = intval($number) + 1;
        }

        return 'PJL/' . $kode_pelanggan . '/' . date('Y') . '/' . date('m') . '/' . str_pad($number, 3, 0, STR_PAD_LEFT);
    }

    public static function fakturHutangLain($kode_supplier)
    {
        $count = mHutangLain
            ::whereYear('hul_tanggal', date('Y'))
            ->whereMonth('hul_tanggal', date('m'))
            ->count();
        if ($count == 0) {
            $number = 1;
        } else {
            $hsp_no_faktur = mHutangLain
                ::whereYear('hul_tanggal', '=', date('Y'))
                ->whereMonth('hul_tanggal', '=', date('m'))
                ->orderBy('id_hutang_lain', 'DESC')
                ->value('hul_no_faktur');

            $number = substr($hsp_no_faktur, -3, 3);
            $number = intval($number) + 1;
        }

        return 'HUL/' . $kode_supplier . '/' . date('Y') . '/' . date('m') . '/' . str_pad($number, 3, 0, STR_PAD_LEFT);
    }

    public static function fakturHutangSupplier($kode_supplier)
    {
        $count = mHutangSupplier
            ::whereYear('hsp_tanggal', date('Y'))
            ->whereMonth('hsp_tanggal', date('m'))
            ->count();
        if ($count == 0) {
            $number = 1;
        } else {
            $hsp_no_faktur = mHutangSupplier
                ::whereYear('hsp_tanggal', '=', date('Y'))
                ->whereMonth('hsp_tanggal', '=', date('m'))
                ->orderBy('id_hutang_supplier', 'DESC')
                ->value('hsp_no_faktur');

            $number = substr($hsp_no_faktur, -3, 3);
            $number = intval($number) + 1;
        }

        return 'HSP/' . $kode_supplier . '/' . date('Y') . '/' . date('m') . '/' . str_pad($number, 3, 0, STR_PAD_LEFT);
    }

    public static function fakturPiutangPelanggan($kode_pelanggan)
    {
        $count = mPiutangPelanggan
            ::whereYear('ppl_tanggal', date('Y'))
            ->whereMonth('ppl_tanggal', date('m'))
            ->count();
        if ($count == 0) {
            $number = 1;
        } else {
            $ppl_no_faktur = mPiutangPelanggan
                ::whereYear('ppl_tanggal', '=', date('Y'))
                ->whereMonth('ppl_tanggal', '=', date('m'))
                ->orderBy('id_piutang_pelanggan', 'DESC')
                ->value('ppl_no_faktur');

            $number = substr($ppl_no_faktur, -3, 3);
            $number = intval($number) + 1;
        }

        return 'PPL/' . $kode_pelanggan . '/' . date('Y') . '/' . date('m') . '/' . str_pad($number, 3, 0, STR_PAD_LEFT);
    }

    public static function fakturPiutangLain($kode_pelanggan)
    {
        $count = mPiutangLain
            ::whereYear('ptl_tanggal', date('Y'))
            ->whereMonth('ptl_tanggal', date('m'))
            ->count();
        if ($count == 0) {
            $number = 1;
        } else {
            $ppl_no_faktur = mPiutangLain
                ::whereYear('ptl_tanggal', '=', date('Y'))
                ->whereMonth('ptl_tanggal', '=', date('m'))
                ->orderBy('id_piutang_lain', 'DESC')
                ->value('ptl_no_faktur');

            $number = substr($ppl_no_faktur, -3, 3);
            $number = intval($number) + 1;
        }

        return 'PTL/' . $kode_pelanggan . '/' . date('Y') . '/' . date('m') . '/' . str_pad($number, 3, 0, STR_PAD_LEFT);
    }

    public static function date_filter($request, $type = ['date', 'keywords'])
    {

        $date_first = mMataPelajaran::orderBy('id_mata_pelajaran')->value('created_at');

        $date_from = $request->date_from ? $request->date_from : date('d-m-Y');
        $date_to = $request->date_to ? $request->date_to : date("d-m-Y", strtotime($date_from));
        $date_from_db = date('Y-m-d', strtotime($date_from));
        $date_to_db = date('Y-m-d', strtotime($date_to));
        $date_where = [$date_from_db . " 00:00:00", $date_to_db . " 23:59:59"];
        $keywords = $request->keywords ? $request->keywords : '';

        $data = [
            'date_first' => $date_first,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'keywords' => $keywords,
            'type' => $type
        ];

        $date_filter = (string)\view('component/filterDate', $data);

        return [
            'date_from' => $date_from,
            'date_to' => $date_to,
            'date_from_db' => $date_from_db,
            'date_to_db' => $date_to_db,
            'date_first' => $date_first,
            'date_filter' => $date_filter,
            'date_where' => $date_where,
            'keywords' => $keywords
        ];
    }

    public static function checkVarExist($var)
    {
        return isset($var) ? $var : '';
    }

    public static function day_format_id($day)
    {
        switch ($day) {
            case "Sunday":
                return 'Minggu';
                break;
            case "Monday":
                return 'Senin';
                break;
            case "Tuesday":
                return 'Selasa';
                break;
            case "Wednesday":
                return 'Rabu';
                break;
            case "Thursday":
                return 'Kamis';
                break;
            case "Friday":
                return 'Jumat';
                break;
            case "Saturday":
                return 'Sabtu';
                break;
        }
    }

    public static function whatsappSend($number, $message)
    {
        //        $apikey = 604507;
        //        $message = urlencode($message);
        //        $client = new \GuzzleHttp\Client();
        //        $request = $client->get('https://api.callmebot.com/whatsapp.php?phone='.$nomer.'&text='.$message.'&apikey='.$apikey);
        //        $response = $request->getBody()->getContents();
        //        echo '<pre>';
        //        print_r($response);
        //        exit;


        //        $chatApiToken = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE2MDk4MTM2NTcsInVzZXIiOiI2MjgxOTM0MzY0MDYzIn0.YEq5LzdGO1vpbGw6Xle9SJo_qFVs5WfM7AZmOTaO4rs"; // Get it from https://www.phphive.info/255/get-whatsapp-password/
        //
        ////        $number = "+6281934364063"; // Number
        ////        $message = "Hello :)"; // Message
        //
        //        $curl = curl_init();
        //        curl_setopt_array($curl, array(
        //            CURLOPT_URL => 'http://chat-api.phphive.info/message/send/text',
        //            CURLOPT_RETURNTRANSFER => true,
        //            CURLOPT_ENCODING => '',
        //            CURLOPT_MAXREDIRS => 10,
        //            CURLOPT_TIMEOUT => 0,
        //            CURLOPT_FOLLOWLOCATION => true,
        //            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //            CURLOPT_CUSTOMREQUEST => 'POST',
        //            CURLOPT_POSTFIELDS =>json_encode(array("jid"=> $number."@s.whatsapp.net", "message" => $message)),
        //            CURLOPT_HTTPHEADER => array(
        //                'Authorization: Bearer '.$chatApiToken,
        //                'Content-Type: application/json'
        //            ),
        //        ));
        //
        //        $response = curl_exec($curl);
        //        curl_close($curl);
        //        echo $response;
        //
        //        echo $number.'<br  />';
        //        echo $message;


        $apikey = 'ZIAWMPS5ZTVJLMGALBW3'; // api key nomer, rumah sunat bali
        $message = urlencode($message);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://panel.rapiwha.com/send_message.php?apikey=" . $apikey . "&number=" . $number . "&text=" . $message,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public static function appointment_status($appointment_status)
    {
        switch ($appointment_status) {
            case "prepare":
                return '<span class="m-badge m-badge--warning m-badge--wide">Dalam Proses</span>';
                break;
            case "send":
                return '<span class="m-badge m-badge--success m-badge--wide">Sudah Terkirim</span>';
                break;
            default:
                $appointment_status;
        }
    }

    public static function barang_golongan_label($brg_golongan)
    {
        switch ($brg_golongan) {
            case "luar":
                return 'Obat Luar';
                break;
            case "dalam":
                return 'Obat Dalam';
                break;
            default:
                return $brg_golongan;
        }
    }

    public static function greating()
    {
        $time = date("H");
        /* Set the $timezone variable to become the current timezone */
        $timezone = date("e");
        /* If the time is less than 1200 hours, show good morning */
        if ($time < "10") {
            return "Selamat Pagi";
        } else
            /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
            if ($time >= "10" && $time < "14") {
                return "Selamat Siang";
            } else
                /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
                if ($time >= "14" && $time < "19") {
                    return "Selamat Sore";
                } else
                    /* Finally, show good night if the time is greater than or equal to 1900 hours */
                    if ($time >= "19") {
                        return "Selamat Malam";
                    }
    }
}
