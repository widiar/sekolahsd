<?php

namespace app\Http\Controllers\General;

use app\Models\mMataPelajaran;
use app\Models\mNilai;
use app\Models\mAbsen;
use app\Models\mJadwal;
use app\Models\mGuru;
use app\Models\mKelas;
use app\Models\mSiswa;
use app\Models\mOrangTua;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;


use DB;
use Illuminate\Support\Facades\Session;
use app\Models\mUser;


class DashboardAdmin extends Controller
{
    private $breadcrumb = [
        [
            'label' => 'dashboard_admin',
            'route' => ''
        ]
    ];

    private $bulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'Nopember',
        '12' => 'Desember',
    ];

    function index(Request $request)
    {
//        return Session::all();
        $data = $this->data_dashboard_admin($request);

//        return $data['cart_patient'];

        return view('dashboard/dashboard_admin', $data);

    }


    function data_dashboard_admin($request)
    {

        $filter_component = Main::date_filter($request);
        $date_from_db = $filter_component['date_from_db'];
        $date_to_db = $filter_component['date_to_db'];
        $date_filter = $filter_component['date_filter'];


        $data = Main::data($this->breadcrumb);
        $where_date = [$date_from_db . " 00:00:00", $date_to_db . " 23:59:59"];

        $total_mata_pelajaran = mMataPelajaran
            ::where('id_mata_pelajaran', '>=', '1')
            ->count();
        $total_jadwal = mJadwal
            ::where('id_jadwal', '>=', '1')
            ->count();
        $total_guru = mGuru
            ::where('id_guru', '>=', '1')
            ->count();
        $total_kelas = mKelas
            ::where('id_kelas', '>=', '1')
            ->count();
        $total_siswa = mSiswa
            ::where('id_siswa', '>=', '1')
            ->count();
        $total_orang_tua = mOrangTua
            ::where('id_orang_tua', '>=', '1')
            ->count();
        $total_nilai = mNilai
            ::where('id_nilai', '>=', '1')
            ->count();
        $total_absen = mAbsen
            ::where('id_absen', '>=', '1')
            ->count();


        $start = new \DateTime($date_from_db);
        $end = new \DateTime($date_to_db);
        $end = $end->modify('+1 day');
        $interval = new \DateInterval('P1D');

        $label = [];
        $period = new \DatePeriod($start, $interval, $end);

        foreach ($period as $key => $value) {
            $label[] = $value->format('Y-m-d');
        }


        $cart_patient = [
            'label' => $label
        ];

        foreach ($period as $key => $value) {
            $date = $value->format('Y-m-d');

            $cart_patient['data']['appointment'][$date] = 0;

            $cart_patient['data']['consult'][$date] = 0;

            $cart_patient['data']['action'][$date] = 0;

            $cart_patient['data']['control'][$date] = 0;

            $cart_patient['data']['patient'][$date] = 0;

            $cart_patient['data']['payment'][$date] = 0;
        }


        $data = array_merge($data, array(
            'total_mata_pelajaran' => Main::format_number($total_mata_pelajaran),
            'total_jadwal' => Main::format_number($total_jadwal),
            'total_guru' => Main::format_number($total_guru),
            'total_kelas' => Main::format_number($total_kelas),
            'total_siswa' => Main::format_number($total_siswa),
            'total_orang_tua' => Main::format_number($total_orang_tua),
            'total_nilai' => Main::format_number($total_nilai),
            'total_absen' => Main::format_number($total_absen),
            'cart_patient' => $cart_patient,
            'date_filter' => $date_filter
        ));
        return $data;
    }

    function whatsapp_test()
    {
        Main::whatsappSend('+6281934364063', 'HELLO,, ini adalah test message ' . date('d-m-Y H:i:s'));
    }


}
