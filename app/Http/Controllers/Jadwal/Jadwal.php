<?php

namespace app\Http\Controllers\Jadwal;

use app\Models\mMataPelajaran;
use app\Models\mJadwal;
use app\Models\mKelas;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;

class Jadwal extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->breadcrumb = [
            [
                'label' => $cons['jadwal'],
                'route' => ''
            ]
        ];
    }

    function index($kls, Request $request)
    {
        $filter_component = Main::date_filter($request, ['keywords']);
        $date_from_db = $filter_component['date_from_db'];
        $date_to_db = $filter_component['date_to_db'];
        $date_filter = $filter_component['date_filter'];
        $keywords = $filter_component['keywords'];

        $id_kelas = $request->input('id_kelas');


        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('jadwal')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id_mata_pelajaran', '=', 'jadwal.id_mata_pelajaran')
            ->leftJoin('kelas', 'kelas.id_kelas', '=', 'jadwal.id_kelas')
            ->get();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->where('mpj_kelas', $kls)->get();
        $kelas = mKelas::orderBy('kls_nama', 'ASC')->get();
        $kelas_select = mKelas::where('id_kelas', $id_kelas)->first();
        $datatable_column = [
            ["data" => "kls_nama"],
            ["data" => "jam_dari"],
            ["data" => "mpj_nama"],
            ["data" => "mpj_nama"],
            ["data" => "mpj_nama"],
            ["data" => "mpj_nama"],
            ["data" => "mpj_nama"],
            ["data" => "mpj_nama"],
            ["data" => "options"],

        ];

        $hari = [
            'senin',
            'selasa',
            'rabu',
            'kamis',
            'jumat',
            'sabtu'
        ];

        $jam = [1 => '07.30 - 09.00', 2 => '09.00 - 10.30', 3 => '11.00 - 12.30'];
        // dd($mata_pelajaran);
        $kelaspilih = mKelas::where('kls_nama', $kls)->orderBy('sub_kelas', 'asc')->get();
        $jadwal = mJadwal::with('mata_pelajaran')->where('id_kelas', $kelaspilih[0]->id_kelas)->groupBy('jam')->get();
        $jadwalPilih = [];
        foreach ($jadwal as $val) {
            // $jadwalPilih[$val->jam] = mJadwal::where('id_kelas', $kelaspilih[0]->id_kelas)->where('jam', $val->jam)->get();
            array_push($jadwalPilih, mJadwal::where('id_kelas', $kelaspilih[0]->id_kelas)->where('jam', $val->jam)->get());
        }
        // dd($jadwalPilih);
        $data = array_merge($data, [
            'data' => $data_list,
            'mata_pelajaran' => $mata_pelajaran,
            'kelas' => $kelas,
            'kelaspilih' => $kelaspilih,
            'datatable_column' => $datatable_column,
            'date_filter' => $date_filter,
            'id_kelas' => $id_kelas,
            'kelas_select' => $kelas_select,
            'hari' => $hari,
            'jam' => $jam,
            'jadwal' => $jadwal,
            'jadwalPilih' => $jadwalPilih,
            'id_mata_pelajaran' => [],
            'table_data_post' => array(
                'date_from_db' => $date_from_db,
                'date_to_db' => $date_to_db,
                'keywords' => $keywords,
                'id_kelas' => $id_kelas
            ),
        ]);

        return view('jadwal/jadwalList', $data);
    }

    function ambil(Request $request)
    {
        $jadwal = mJadwal::with('mata_pelajaran')->where('id_kelas', $request->id_kelas)->groupBy('jam')->get();
        $jadwalPilih = [];
        foreach ($jadwal as $val) {
            // $jadwalPilih[$val->jam] = mJadwal::where('id_kelas', $request->id_kelas)->where('jam', $val->jam)->get();
            array_push($jadwalPilih, mJadwal::where('id_kelas', $request->id_kelas)->where('jam', $val->jam)->get());
        }
        return response()->json([
            'jadwal' => $jadwal,
            'jadwalPilih' => $jadwalPilih
        ]);
    }


    function data_table(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];
        $id_kelas = $data_post['id_kelas'];
        $total_data = mJadwal
            ::whereLike('id_jadwal', $keywords)
            ->whereLike('hari', $keywords)
            ->whereLike('id_kelas', $id_kelas)
            ->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_jadwal'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mJadwal
            ::with(['mata_pelajaran', 'kelas'])
            ->whereLike('id_jadwal', $keywords)
            ->whereLike('id_kelas', $id_kelas)
            ->whereLike('hari', $keywords)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order_column, $order_type)
            ->get();

        $total_data++;

        $data = array();

        foreach ($data_list as $key => $row) {
            $key++;
            $id_jadwal = Main::encrypt($row->id_jadwal);

            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['kls_nama'] = $row->kelas->kls_nama;
            $nestedData['jam_dari'] = $row->jam_dari . '-' . $row->jam_ke;
            $nestedData['mpj_nama'] = $row->mata_pelajaran->mpj_nama;
            $nestedData['hari'] = $row->hari;
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
                            data-route="' . route('jadwalEditModal', ['id_jadwal' => $id_jadwal]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('jadwalDelete', ['id_jadwal' => $id_jadwal]) . '">
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
            'jam_dari' => 'required',
            'jam_ke' => 'required',
            'id_mata_pelajaran' => 'required',
            'hari' => 'required',


        ]);

        $data = $request->except('_token');
        mJadwal::create($data);
    }

    function edit_modal($id_jadwal)
    {
        $id_jadwal = Main::decrypt($id_jadwal);
        $edit = mJadwal::where('id_jadwal', $id_jadwal)->first();
        $mata_pelajaran = mMataPelajaran::orderBy('mpj_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'mata_pelajaran' => $mata_pelajaran
        ];

        return view('jadwal/jadwalEditModal', $data);
    }


    function delete($id_jadwal)
    {
        $id_jadwal = Main::decrypt($id_jadwal);
        mJadwal::where('id_jadwal', $id_jadwal)->delete();
    }

    function update(Request $request)
    {
        $id_kelas = $request->input('kelas');
        $jam = $request->input('jam');
        // dd($request->all());
        mJadwal::where('id_kelas', $request->kelas)->delete();
        foreach ($request->jam as $key => $value) {
            //senin
            mJadwal::create([
                'id_mata_pelajaran' => $request->mapel_senin[$key],
                'hari' => 'senin',
                'id_kelas' => $request->kelas,
                'jam' => $value
            ]);
            //selasa
            mJadwal::create([
                'id_mata_pelajaran' => $request->mapel_selasa[$key],
                'hari' => 'selasa',
                'id_kelas' => $request->kelas,
                'jam' => $value
            ]);
            //rabu
            mJadwal::create([
                'id_mata_pelajaran' => $request->mapel_rabu[$key],
                'hari' => 'rabu',
                'id_kelas' => $request->kelas,
                'jam' => $value
            ]);
            //kamis
            mJadwal::create([
                'id_mata_pelajaran' => $request->mapel_kamis[$key],
                'hari' => 'kamis',
                'id_kelas' => $request->kelas,
                'jam' => $value
            ]);
            //jumat
            mJadwal::create([
                'id_mata_pelajaran' => $request->mapel_jumat[$key],
                'hari' => 'jumat',
                'id_kelas' => $request->kelas,
                'jam' => $value
            ]);
            //sabtu
            mJadwal::create([
                'id_mata_pelajaran' => $request->mapel_sabtu[$key],
                'hari' => 'sabtu',
                'id_kelas' => $request->kelas,
                'jam' => $value
            ]);
        }
        $kls = mKelas::find($request->kelas);
        return redirect()->route('jadwalList', $kls->kls_nama);
    }
}
