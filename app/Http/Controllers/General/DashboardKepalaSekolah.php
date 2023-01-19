<?php

namespace app\Http\Controllers\General;


use app\Models\mAbsen;
use app\Models\mLaporanAnak;
use app\Models\mLaporanSiswa;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;


use DB;
use Illuminate\Support\Facades\Session;
use app\Models\mUser;


class DashboardKepalaSekolah extends Controller
{
    private $breadcrumb = [
        [
            'label' => 'dashboard_kepala_sekolah',
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
        $data = $this->data_dashboard_kepala_sekolah($request);

//        return $data['cart_patient'];

        return view('dashboard/dashboard_kepala_sekolah', $data);

    }


    function data_dashboard_kepala_sekolah($request)
    {

        $filter_component = Main::date_filter($request);
        $date_from_db = $filter_component['date_from_db'];
        $date_to_db = $filter_component['date_to_db'];
        $date_filter = $filter_component['date_filter'];


        $data = Main::data($this->breadcrumb);
        $where_date = [$date_from_db . " 00:00:00", $date_to_db . " 23:59:59"];

        $total_hadir = mAbsen
            ::where('abs_keterangan', '=', 'hadir')
            ->count();
        $total_izin = mAbsen
            ::where('abs_keterangan', '=', 'izin')
            ->count();
        $total_alpha = mAbsen
            ::where('abs_keterangan', '=', 'alpha')
            ->count();
        $total_sakit = mAbsen
            ::where('abs_keterangan', '=', 'sakit')
            ->count();
        $total_lulus = mLaporanSiswa
            ::where('id_laporan_siswa', '>=', '1')
            ->count();
        $total_tidak_lulus = mLaporanSiswa
            ::where('id_laporan_siswa', '>=', '1')
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
            'total_hadir' => Main::format_number($total_hadir),
            'total_izin' => Main::format_number($total_izin),
            'total_sakit' => Main::format_number($total_sakit),
            'total_alpha' => Main::format_number($total_alpha),
            'total_lulus' => Main::format_number($total_lulus),
            '$total_tidak_lulus' => Main::format_number($total_tidak_lulus),
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
