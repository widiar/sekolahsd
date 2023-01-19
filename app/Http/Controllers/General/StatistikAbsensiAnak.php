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


class StatistikAbsensiAnak extends Controller
{
    private $breadcrumb = [
        [
            'label' => 'statistik_absensi_anak',
            'route' => ''
        ]
    ];

    function index(Request $request)
    {

        $user = Session::get('user');
        if(isset($user->id_karyawan))
            $id_siswa = $user->id_karyawan;
        else if(isset($user->id_siswa))
            $id_siswa = $user->id_siswa;
        
        $id_orang_tua = $user->id_orang_tua;
        
        $izin = mAbsen::where('id_siswa', $id_siswa)->where('abs_keterangan', 'izin')->count();
        $hadir = mAbsen::where('id_siswa', $id_siswa)->where('abs_keterangan', 'hadir')->count();
        $alpha = mAbsen::where('id_siswa', $id_siswa)->where('abs_keterangan', 'alpha')->count();
        $sakit = mAbsen::where('id_siswa', $id_siswa)->where('abs_keterangan', 'sakit')->count();
        
        $data = Main::data($this->breadcrumb);
        // dd($data);
        $DAbsen = mAbsen::where('id_siswa',$id_siswa)->get();
        $data = array_merge($data, array(
            'izin' => $izin,
            'hadir' => $hadir,
            'alpha' => $alpha,
            'sakit' => $sakit,
            'DAbsen' => $DAbsen
        ));
        return view('statistik/statistik_absensi_anak', $data);

    }


}
