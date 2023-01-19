<?php

namespace app\Http\Controllers\LaporanSiswa;

use app\Models\mLaporanSiswa;
use app\Models\mKelas;
use app\Models\mNilai;
use app\Models\mSiswa;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;

class LaporanSiswa extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->breadcrumb = [
            [
                'label' => $cons['laporan_siswa'],
                'route' => ''
            ]
        ];
    }

    function index()
    {

        $data = Main::data($this->breadcrumb);
        $kelas = mKelas::orderBy('kls_nama', 'asc')->orderBy('sub_kelas', 'asc')->get();
        foreach($kelas as $row) {
            $lulus = 0;
            $tidak_lulus = 0;

            $row->jumlah_siswa = mSiswa::where('id_kelas', $row->id_kelas)->count();
            $siswa_kelas = mSiswa::where('id_kelas', $row->id_kelas)->get();
            foreach($siswa_kelas as $row_2) {
                $nilai = mNilai::with('mata_pelajaran')->where('id_siswa', $row_2->id_siswa)->where('id_kelas', $row->id_kelas)->get();

                // $jumlah_nilai = mNilai::where('id_siswa', $row_2->id_siswa)->where('id_kelas', $row->id_kelas)->count();
                // $rata2 = $total_nilai > 0 ? round($total_nilai/$jumlah_nilai) : 0;
                // if($rata2 >= 60) {
                //     $lulus++;
                // } else {
                //     $tidak_lulus++;
                // }
                $cekGakLulus = 0;
                if(count($nilai) > 3){
                    foreach ($nilai as $val) {
                        if($val->nilai < $val->mata_pelajaran->mpj_nilai_lulus)
                            $cekGakLulus++;
                    }
                    if($cekGakLulus <= 3) $lulus ++;
                    else $tidak_lulus++;
                }
            }

            $row->lulus = $lulus;
            $row->tidak_lulus = $tidak_lulus;



        }
        // dd($kelas);
        $data = array_merge($data, [
            'kelas' => $kelas
        ]);

        return view('laporansiswa/laporansiswaList', $data);
    }


    function data_table(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];

        if ($keywords) {
            $total_data = mLaporanSiswa
                ::whereLike('id_laporan_siswa', $keywords)
                ->orWhereLike('lps_jumlah_siswa', $keywords)
                ->count();
        } else {
            $total_data = mLaporanSiswa
                ::count();
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_laporan_siswa'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mLaporanSiswa
            ::with('kelas');
        if ($keywords) {
            $data_list = $data_list
                ->whereLike('id_laporan_siswa', $keywords)
                ->orWhereLike('lps_jumlah_siswa', $keywords);
        }

        $data_list = $data_list
            ->offset($start)
            ->limit($limit)
            ->orderBy($order_column, $order_type)
            ->get();

        $total_data++;

        $data = array();
        foreach ($data_list as $key => $row) {
            $key++;
            $id_laporan_siswa = Main::encrypt($row->id_laporan_siswa);

            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['no'] = $no;
            $nestedData['kls_nama'] = $row->kelas->kls_nama;
            $nestedData['lps_jumlah_siswa'] = $row->lps_jumlah_siswa;
            $nestedData['lps_lulus'] = $row->lps_lulus;
            $nestedData['lps_tidak_lulus'] = $row->lps_tidak_lulus;
            $nestedData['options'] = '
                <div class="dropdown">
                    <button class="btn btn-sm btn-accent dropdown-toggle m-btn--pill"
                            type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                        Menu
                    </button>
                    <div class="dropdown-menu dropdown-menu-right"
                         aria-labelledby="dropdownMenuButton">
                        <a class="akses-action_wait_cancel dropdown-item btn-modal-general"
                           href="#"
                            data-route="' . route('laporansiswaEditModal', ['$id_laporan_siswa' => $id_laporan_siswa]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('laporansiswaDelete', ['$id_laporan_siswa' => $id_laporan_siswa]) . '">
                            <i class="la la-remove"></i>
                            Hapus
                        </a>
                    </div>
                </div>
            ';


            $data[] = $nestedData;

        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($total_data - 1),
            "recordsFiltered" => intval($total_data - 1),
            "data" => $data,
            'all_request' => $request->all(),
            'keywords' => $keywords
        );

        return $json_data;
    }

    function insert(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required',
            'lps_jumlah_siswa' => 'required',
            'lps_lulus' => 'required',
            'lps_tidak_lulus' => 'required',
        ]);

        $data = $request->except('_token');
        mLaporanSiswa::create($data);
    }

    function edit_modal($id_laporan_siswa)
    {
        $id_laporan_siswa = Main::decrypt($id_laporan_siswa);
        $edit = mLaporanSiswa::where('id_laporan_siswa', $id_laporan_siswa)->first();
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'kelas' => $kelas,
        ];

        return view('laporansiswa/laporansiswaEditModal', $data);
    }

    function delete($id_laporan_siswa)
    {
        $id_laporan_siswa = Main::decrypt($id_laporan_siswa);
        mLaporanSiswa::where('id_laporan_siswa', $id_laporan_siswa)->delete();
    }

    function update(Request $request, $id_laporan_siswa)
    {
        $id_laporan_siswa = Main::decrypt($id_laporan_siswa);
        $request->validate([
            'id_kelas' => 'required',
            'lps_jumlah_siswa' => 'required',
            'lps_lulus' => 'required',
            'lps_tidak_lulus' => 'required',
        ]);
        $data = $request->except("_token");
        mLaporanSiswa::where(['id_laporan_siswa' => $id_laporan_siswa])->update($data);
    }
}
