<?php

namespace app\Helpers;

use Illuminate\Support\Facades\Config;


class hAkunting
{


    public static function perkiraan_space($subKe)
    {
        switch ($subKe) {
            case 1:
                $space = '&nbsp;&nbsp;&nbsp;&nbsp;';
                break;
            case 2:
                $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                break;
            case 3:
                $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                break;
            case 4:
                $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                break;
            default:
                $space = '';
        }
        return $space;
    }

    /**
     *
     * Digunakan untuk membuat nomer transaksi yang biasanya ada di Pembayaran Hutang Packages
     *
     * @param $kode
     * @return string
     */
    public static function getNoTransaksiPayment($kode)
    {
        //buat no faktur pembelian
        $tahun = date('Y');
        $thn = substr($tahun, 2, 2);
        $bulan = date('m');
        $tgl = date('d');
        //$kode_user = auth()->user()->kode;
        $no_po_last = mAcJurnalUmum::where('no_invoice', 'like', $thn . $bulan . $tgl . '-' . $kode . '%')->max('no_invoice');
        $lastNoUrut = substr($no_po_last, 11, 4);//mengambil string dari $lastNoFaktur dari index ke-8, yg diambil hanya 3 index saja
        if ($lastNoUrut == 0) {
            $nextNoUrut = 0 + 1;
        } else {
            $nextNoUrut = $lastNoUrut + 1;
        }
        // $nextNoTransaksi              = sprintf('%04s',$nextNoUrut).'/'.$kode.'/'.$bulan.$thn;
        $nextNoTransaksi = $thn . $bulan . $tgl . '-' . $kode . '-' . sprintf('%04s', $nextNoUrut);// . '.' . $kode_user;
        // $data['next_no_trs']    = $nextNoTransaksi;
        $next_no_tr = $nextNoTransaksi;

        return $next_no_tr;
    }


    /**
     * @param $year
     * @param $month
     * @param $day
     * @return int
     */
    public static function jmu_no($year, $month, $day)
    {
        $where = [
            'jmu_year' => $year,
            'jmu_month' => $month,
            'jmu_day' => $day
        ];
        $count = mAcJurnalUmum::where($where)->count();
        if ($count == 0) {
            return 1;
        } else {
            $jmu_no = mAcJurnalUmum::where($where)->orderBy('jmu_no', 'DESC')->first(['jmu_no']);
            return $jmu_no->jmu_no + 1;
        }
    }

    /**
     *
     * Untuk generate kode_asset selanjutnya saat digunakan menyimpan data asset
     *
     * @return string
     */
    public static function kode_asset()
    {
        $kode_asset = Config::get('constants.kodeAsset');
        $tahun = date('Y');
        $thn = substr($tahun, 2, 2);
        $bulan = date('m');
        $no_po_last = mAsset::where('kode_asset', 'like', '%/' . $kode_asset . '/' . $bulan . $thn)->max('kode_asset');
        $lastNoUrut = substr($no_po_last, 0, 4);//mengambil string dari $lastNoFaktur dari index ke-8, yg diambil hanya 3 index saja
        if ($lastNoUrut == 0) {
            $nextNoUrut = 0 + 1;
        } else {
            $nextNoUrut = $lastNoUrut + 1;
        }
        $nextNoTransaksi = sprintf('%04s', $nextNoUrut) . '/' . $kode_asset . '/' . $bulan . $thn;

        return $nextNoTransaksi;
    }

    public static function kode_perkiraan_select_list()
    {
        $master_parent = mAcMaster
            ::with('childs.childs')
            ->where('mst_master_id', 0)
            ->orderBy('mst_kode_rekening', 'ASC')
            ->get();
        $space_1 = hAkunting::perkiraan_space(1);

        $data = [
            'master_parent' => $master_parent,
            'space_1' => $space_1
        ];

        return view('component/kodePerkiraanOptionList', $data);
    }

    public static function kode_perkiraan_select_edit($master_id_edit)
    {
        $master_parent = mAcMaster
            ::with('childs.childs')
            ->where('mst_master_id', 0)
            ->orderBy('mst_kode_rekening', 'ASC')
            ->get();
        $space_1 = hAkunting::perkiraan_space(1);

        $data = [
            'master_parent' => $master_parent,
            'space_1' => $space_1,
            'master_id_edit' => $master_id_edit
        ];

        return view('component/kodePerkiraanOptionEdit', $data);
    }

    public static function kode_perkiraan_pembayaran()
    {
        $kode_perkiraan = [];
        $kode_perkiraan_2 = [];
        $no = 0;
        $master_parent = mAcMaster
            ::where('mst_master_id', 0)
            ->orderBy('mst_kode_rekening', 'ASC')
            ->get();
        $master_parent_2 = mAcMaster
            ::with('childs.childs')
            ->where('mst_master_id', 0)
            ->orderBy('mst_kode_rekening', 'ASC')
            ->get();


        $master_parent_in = [];

        foreach ($master_parent_2 as $key_1 => $r_1) {
            $check_parent_in = FALSE;
            foreach ($r_1->childs as $key_2 => $r_2) {
                if (count($r_2->childs) > 0) {
                    foreach ($r_2->childs as $key_3 => $r_3) {
                        if ($r_3->mst_pembayaran == 'yes') {
                            $check_parent_in = TRUE;
                            break;
                        } else {
                            $check_parent_in = FALSE;
                        }
                    }
                } else {
                    if ($r_2->mst_pembayaran == 'yes') {
                        $check_parent_in = TRUE;
                        break;
                    } else {
                        $check_parent_in = FALSE;
                    }
                }
            }

            if ($check_parent_in) {
                $master_parent_in[] = $r_1->master_id;
            }
        }

        $master_childs_1 = [];

        foreach ($master_parent_in as $key_0 => $master_id) {
            $check_child_in = FALSE;
            $childs_1 = mAcMaster
                ::with('childs')
                ->where([
                    'mst_master_id' => $master_id
                ])
                ->get();

            foreach ($childs_1 as $key_1 => $r_1) {

                if (count($r_1->childs) > 0) {

                    foreach ($r_1->childs as $key_2 => $r_2) {
                        if ($r_2->mst_pembayaran == 'yes') {
                            $check_child_in = TRUE;
                            break;
                        } else {
                            $check_child_in = FALSE;
                        }
                    }

                } else {
                    if ($r_1->mst_pembayaran == 'yes') {
                        $check_child_in = TRUE;
                    } else {
                        $check_child_in =  FALSE;
                    }
                }

                if ($check_child_in) {
                    $master_childs_1[$master_id][$key_1] = $r_1->master_id;
                }

            }

        }

        $master_childs_2 = [];

        $no_0 = 0;
        foreach ($master_childs_1 as $master_id => $r_0) {
            $master_childs_2[$no_0]['master_id'] = $master_id;
            $no_1 = 0;
            foreach ($r_0 as $master_id_childs_2 => $master_id) {
                $master_childs_2[$no_0]['childs'][$no_1]['master_id'] = $master_id;

                $check_has_child = mAcMaster
                    ::where([
                        'mst_master_id' => $master_id
                    ])
                    ->count();

                if ($check_has_child > 0) {
                    $master_childs_3 = mAcMaster
                        ::where([
                            'mst_master_id' => $master_id,
                            'mst_pembayaran' => 'yes'
                        ])
                        ->get(['master_id']);
                    foreach ($master_childs_3 as $no_2 => $r_3) {
                        $master_childs_2[$no_0]['childs'][$no_1]['childs'][$no_2] = $r_3->master_id;
                    }
                }


                $no_1++;
            }

            $no_0++;
        }

        //return $master_final;
        return $master_childs_2;
    }

}
