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


class StatistikAbsensiII extends Controller
{
    private $breadcrumb = [
        [
            'label' => 'statistik_absensi',
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

        $izin = mAbsen::where('abs_keterangan', 'izin')->where('id_kelas',2)->count();
        $hadir = mAbsen::where('abs_keterangan', 'hadir')->where('id_kelas',2)->count();
        $alpha = mAbsen::where('abs_keterangan', 'alpha')->where('id_kelas',2)->count();
        $sakit = mAbsen::where('abs_keterangan', 'sakit')->where('id_kelas',2)->count();

        $data = Main::data($this->breadcrumb);
        $DAbsen = mAbsen::where('id_kelas',2)->get();
        $data = array_merge($data, array(
            'izin' => $izin,
            'hadir' => $hadir,
            'alpha' => $alpha,
            'sakit' => $sakit,
            'DAbsen' => $DAbsen
        ));

        return view('statistik/II/statistik_absensi', $data);

    }



}
