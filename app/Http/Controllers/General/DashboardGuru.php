<?php

namespace app\Http\Controllers\General;

use app\Models\mNilai;
use app\Models\mAbsen;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;


use DB;
use Illuminate\Support\Facades\Session;
use app\Models\mUser;


class DashboardGuru extends Controller
{
    private $breadcrumb = [
        [
            'label' => 'dashboard_guru',
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
        $data = $this->data_dashboard_guru($request);

//        return $data['cart_patient'];
        $user = Session::get('user');
        // dd($data);
        return view('dashboard/dashboard_guru', $data);

    }


    function data_dashboard_guru($request)
    {

        $filter_component = Main::date_filter($request);
        $date_from_db = $filter_component['date_from_db'];
        $date_to_db = $filter_component['date_to_db'];
        $date_filter = $filter_component['date_filter'];


        $data = Main::data($this->breadcrumb);
        $where_date = [$date_from_db . " 00:00:00", $date_to_db . " 23:59:59"];
        $user = Session::get('user');
        $nilai = mNilai
            ::with('kelas')
            ->whereHas('kelas', function ($q) use ($user) {
                return $q->where('id_guru', $user->id_karyawan);
            })
            ->get();
        $absen = mAbsen
            ::with('kelas')
            ->whereHas('kelas', function ($q) use ($user) {
                return $q->where('id_guru', $user->id_karyawan);
            })
            ->get();
        $total_nilai = count($nilai);
        $total_absen = count($absen);

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
            'total_nilai' => Main::format_number($total_nilai),
            'total_absen' => Main::format_number($total_absen),
            'cart_patient' => $cart_patient,
            'date_filter' => $date_filter,
            'nilai' => $nilai,
            'absen' => $absen
        ));
        return $data;
    }

    function whatsapp_test()
    {
        Main::whatsappSend('+6281934364063', 'HELLO,, ini adalah test message ' . date('d-m-Y H:i:s'));
    }


}
