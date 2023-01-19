<?php

namespace app\Http\Controllers\OrangTua;

use app\Models\mSiswa;
use app\Models\mOrangTua;
use Illuminate\Http\Request;
use app\Http\Controllers\Controller;
use app\Helpers\Main;
use Illuminate\Support\Facades\Config;

use app\Models\mUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrangTua extends Controller
{
    private $breadcrumb;

    function __construct()
    {
        $cons = Config::get('constants.topMenu');
        $this->breadcrumb = [
            [
                'label' => $cons['orang_tua'],
                'route' => ''
            ]
        ];
    }

    function index(Request $request)
    {
        $filter_component = Main::date_filter($request, ['keywords']);
        $date_from_db = $filter_component['date_from_db'];
        $date_to_db = $filter_component['date_to_db'];
        $date_filter = $filter_component['date_filter'];
        $keywords = $filter_component['keywords'];


        $data = Main::data($this->breadcrumb);
        $data_list = DB::table('orang_tua')
            ->leftJoin('siswa', 'siswa.id_siswa', '=', 'orang_tua.id_siswa')
            ->get();
        $siswa = mSiswa::orderBy('swa_nama', 'ASC')->get();
        $datatable_column = [
            ["data" => "no"],
            ["data" => "ort_nama_ayah"],
            ["data" => "ort_nama_ibu"],
            ["data" => "swa_nama"],
            ["data" => "ort_alamat"],
            ["data" => "options"],
        ];

        $data = array_merge($data, [
            'data' => $data_list,
            'siswa' => $siswa,
            'datatable_column' => $datatable_column,
            'date_filter' => $date_filter,
            'table_data_post' => array(
                'date_from_db' => $date_from_db,
                'date_to_db' => $date_to_db,
                'keywords' => $keywords
            ),
        ]);

        return view('orangtua/orangtuaList', $data);
    }


    function data_table(Request $request)
    {

        $data_post = $request->input('data');
        $keywords = $data_post['keywords'];

        if ($keywords) {
            $total_data = mOrangTua
                ::whereLike('id_orang_tua', $keywords)
                ->orWhereLike('ort_nama_ayah', $keywords)
                ->count();
        } else {
            $total_data = mOrangTua
                ::count();
        }

        $limit = $request->input('length');
        $start = $request->input('start');
        $order_column = 'id_orang_tua'; //$columns[$request->input('order.0.column')];
        $order_type = $request->input('order.0.dir');

        $data_list = mOrangTua
            ::with('siswa');
        if ($keywords) {
            $data_list = $data_list
                ->whereLike('id_orang_tua', $keywords)
                ->orWhereLike('ort_nama_ayah', $keywords);
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
            $id_orang_tua = Main::encrypt($row->id_orang_tua);

            if ($order_type == 'asc') {
                $no = $key + $start;
            } else {
                $no = $total_data - $key - $start;
            }

            $nestedData['no'] = $key;
            $nestedData['ort_nama_ayah'] = $row->ort_nama_ayah;
            $nestedData['ort_nama_ibu'] = $row->ort_nama_ibu;
            $nestedData['swa_nama'] = $row->siswa->swa_nama;
            $nestedData['ort_alamat'] = $row->ort_alamat;
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
                            data-route="' . route('orangtuaEditModal', ['id_orang_tua' => $id_orang_tua]) . '">
                            <i class="la la-pencil" ></i >
                            Edit
                        </a >

                        <div class="dropdown-divider"></div>
                        <a class="akses-action_wait_detail dropdown-item btn-hapus"
                           href="#"
                            data-route="' . route('orangtuaDelete', ['id_orang_tua' => $id_orang_tua]) . '">
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
            'ort_nama_ayah' => 'required',
            'ort_nama_ibu' => 'required',
            'id_siswa' => 'required',
            'ort_alamat' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        $data = $request->except('_token');
        $data['password'] = Hash::make($data['password']);
        mOrangTua::create($data);
    }

    function edit_modal($id_orang_tua)
    {
        $id_orang_tua = Main::decrypt($id_orang_tua);
        $edit = mOrangTua::where('id_orang_tua', $id_orang_tua)->first();
        $siswa = mSiswa::orderBy('swa_nama', 'ASC')->get();
        $data = [
            'edit' => $edit,
            'siswa' => $siswa,
        ];

        return view('orangtua/orangtuaEditModal', $data);
    }

    function delete($id_orang_tua)
    {
        $id_orang_tua = Main::decrypt($id_orang_tua);
        mOrangTua::where('id_orang_tua', $id_orang_tua)->delete();
    }

    function update(Request $request, $id_orang_tua)
    {
        $id_orang_tua = Main::decrypt($id_orang_tua);
        $request->validate([
            'ort_nama_ayah' => 'required',
            'ort_nama_ibu' => 'required',
            'id_siswa' => 'required',
            'ort_alamat' => 'required',
            'username' => 'required',
        ]);
        $data = $request->except("_token");
        if($data['password']) {
            $data['password'] = Hash::make($data['password']);
        }

        mOrangTua::where(['id_orang_tua' => $id_orang_tua])->update($data);
    }
}

