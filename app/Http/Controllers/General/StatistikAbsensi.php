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


class StatistikAbsensi extends Controller
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

    function index($kls, Request $request)
    {
        $kelaspilih = mKelas::where('kls_nama', $kls)->orderBy('sub_kelas', 'asc')->get();

        $izin = mAbsen::where('abs_keterangan', 'izin')->where('id_kelas', $kelaspilih[0]->id_kelas)->count();
        $hadir = mAbsen::where('abs_keterangan', 'hadir')->where('id_kelas', $kelaspilih[0]->id_kelas)->count();
        $alpha = mAbsen::where('abs_keterangan', 'alpha')->where('id_kelas', $kelaspilih[0]->id_kelas)->count();
        $sakit = mAbsen::where('abs_keterangan', 'sakit')->where('id_kelas', $kelaspilih[0]->id_kelas)->count();

        $data = Main::data($this->breadcrumb);
        $DAbsen = mAbsen::get();
        $data = array_merge($data, array(
            'izin' => $izin,
            'hadir' => $hadir,
            'alpha' => $alpha,
            'sakit' => $sakit,
            'DAbsen' => $DAbsen,
            'kelaspilih' => $kelaspilih
        ));
        $absen = mAbsen::with('siswa')->where('id_kelas', $kelaspilih[0]->id_kelas)->get()->toArray();
        
        if($request->ajax()){
            $absen = mAbsen::with('siswa')->where('id_kelas', $request->id_kelas)
                    ->offset($request->start)
                    ->limit($request->length)
                    ->get()->toArray();
            $total = mAbsen::where('id_kelas', $request->id_kelas)->count();
            return response()->json([
                'data' => $absen,
                "recordsTotal" => intval($total),
                "recordsFiltered" => intval($total),
                'draw' => intval($request->draw),
            ]);
        }

        return view('statistik/statistik_absensi', $data);

    }

    function ambilStatistik(Request $request)
    {
        $izin = mAbsen::where('abs_keterangan', 'izin')->where('id_kelas', $request->id_kelas)->count();
        $hadir = mAbsen::where('abs_keterangan', 'hadir')->where('id_kelas', $request->id_kelas)->count();
        $alpha = mAbsen::where('abs_keterangan', 'alpha')->where('id_kelas', $request->id_kelas)->count();
        $sakit = mAbsen::where('abs_keterangan', 'sakit')->where('id_kelas', $request->id_kelas)->count();

        return response()->json([
            'izin' => $izin,
            'hadir' => $hadir,
            'alpha' => $alpha,
            'sakit' => $sakit,
        ]);
    }



}
