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


class StatistikNilai extends Controller
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
        // $kelaspilih = mKelas::where('kls_nama', $kls)->orderBy('sub_kelas', 'asc')->pluck('id_kelas');
        // dd($kelaspilih);

        $data = Main::data($this->breadcrumb);
        // $DAbsen = mAbsen::get();
        $mapel = mMataPelajaran::where('mpj_kelas', $kls)->get();
        // $nilaiGroup = mNilai::whereIn('id_mata_pelajaran', $kelaspilih)->groupBy('nilai')->get();
        $nilaiGroup = mNilai::where('id_mata_pelajaran', $mapel[0]->id_mata_pelajaran)->groupBy('nilai')->get();
        // dd($nilaiGroup);
        $nilai = [];
        foreach ($nilaiGroup as $val) {
            $nilai[] = [
                'title' => $val->nilai,
                'value' => mNilai::where('id_mata_pelajaran', $mapel[0]->id_mata_pelajaran)->where('nilai', $val->nilai)->count(),
            ];
        }
        // dd($nilai);
        $data = array_merge($data, array(
            // 'DAbsen' => $DAbsen,
            // 'kelaspilih' => $kelaspilih,
            'mapel' => $mapel,
            'nilai' => $nilai
        ));
        
        if($request->ajax()){
            $nilai = mNilai::with('siswa', 'kelas')->where('id_mata_pelajaran', $request->mapel)
                    ->offset($request->start)
                    ->limit($request->length)
                    ->get()->toArray();
            $total = mNilai::where('id_mata_pelajaran', $request->mapel)->count();
            return response()->json([
                'data' => $nilai,
                "recordsTotal" => intval($total),
                "recordsFiltered" => intval($total),
                'draw' => intval($request->draw),
            ]);
        }

        return view('statistik/statistik_nilai', $data);

    }

    function ambilStatistik(Request $request)
    {
        $nilaiGroup = mNilai::with('siswa', 'kelas')->where('id_mata_pelajaran', $request->id_mapel)->groupBy('nilai')->get();
        $nilai = [];
        foreach ($nilaiGroup as $val) {
            $nilai[] = [
                'title' => $val->nilai,
                'value' => mNilai::where('id_mata_pelajaran', $request->id_mapel)->where('nilai', $val->nilai)->count(),
            ];
        }
        return response()->json([
            'nilai' => $nilai
        ]);
    }



}
