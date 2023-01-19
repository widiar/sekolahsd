<?php

namespace app\Helpers;

use app\Models\mDetailProduksi;
use app\Models\mKomposisiProduk;
use app\Models\mPengemasProduk;
use app\Models\mProduksi;
use app\Models\mStokBahan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Config;

use app\Models\mBahan;
use app\Models\mProduk;
use app\Models\mLokasi;
//use app\Models\mKategoriProduk;
use app\Models\mStokProduk;
use app\Models\mPoBahanDetail;
use app\Models\mPoBahan;


class hProduk
{

    /**
     *
     * Diurut berdasarkan tahun, bulan, kode produk dan agencies gudang
     *
     * @param $month
     * @param $year
     * @param $id_produk
     * @param $id_lokasi
     * @param $urutan
     * @return string
     */
    public static function no_seri_produk($month, $year, $id_produk, $id_lokasi, $id_produksi)
    {
        $id_kategori_produk = mProduk::where('id', $id_produk)->value('id_kategori_produk');
        $id_lokasi_produksi = mProduksi::where('id', $id_produksi)->value('id_lokasi');
        $kode_kategori_produk = mKategoriProduk::where('id', $id_kategori_produk)->value('kode_kategori_produk');
        $kode_lokasi = mLokasi::where('id', $id_lokasi)->value('kode_lokasi');
        $kode_pabrik = mLokasi::where('id', $id_lokasi_produksi)->value('kode_lokasi');
        $urutan = hProduk::urutan_produk($month, $year, $id_produk, $id_lokasi);

        return $month . $year . $kode_pabrik . $kode_kategori_produk . $urutan;
    }

    /**
     * @param $id_produk
     * @param $id_lokasi
     * @param $month
     * @param $year
     * @return int
     */
    public static function urutan_produk($month, $year, $id_produk, $id_lokasi)
    {
        $urutan = 1;
        $where = [
            'id_produk' => $id_produk,
            'id_lokasi' => $id_lokasi,
            'month' => $month,
            'year' => $year
        ];

        $stok_urutan = mStokProduk::where($where);

        if ($stok_urutan->count() > 0) {
            $urutan_now = $stok_urutan->orderBy('urutan', 'DESC')->value('urutan');
            $urutan = $urutan_now + 1;
        }

        return $urutan;
    }

    /**
     * Digunakan untuk menghitung HPP bahan.
     * Dilakukan saat sudah melakukan pembayaran PO Bahan
     */
    public static function hpp_bahan()
    {
        $bahan = mBahan::get(['id']);
        $maxCountHppBahan = 3;
        foreach ($bahan as $r) {
            $id_bahan = $r->id;

            $po_bahan = mPoBahanDetail
                ::join('tb_po_bahan', 'tb_po_bahan.id', '=', 'tb_po_bahan_detail.id_po_bahan')
                ->where([
                    'tb_po_bahan_detail.id_bahan' => $id_bahan,
                    'tb_po_bahan.status_pembelian' => 'done'
                ]);
            if ($po_bahan->count() > 0) {
                $bahan_harga_total = $po_bahan
                    ->offset(0)
                    ->limit($maxCountHppBahan)
                    ->orderBy('id', 'DESC')
                    ->sum('harga_net');
                $bahan_hpp = round(($bahan_harga_total / $po_bahan->count()), 2);
                $data_update = [
                    'harga' => $bahan_hpp
                ];
                mBahan
                    ::where('id', $id_bahan)
                    ->update($data_update);
            }
        }
    }

    /**
     * Menghitung total hpp bahan Produksi yang digunakan di publish produksi
     *
     * @param $id_produksi
     * @return int
     */
    public static function total_nominal_hpp_bahan($id_produksi)
    {
        $total_hpp_bahan_produksi = 0;
        $detail_produksi = mDetailProduksi::where('id_produksi', $id_produksi)->get();
        foreach ($detail_produksi as $r_detail_produksi) {
            $id_produk = $r_detail_produksi->id_produk;
            $qty = $r_detail_produksi->qty;
            $komposisi_produk = mKomposisiProduk::where('id_produk', $id_produk)->get();
            $total_hpp_bahan_produk = 0;
            foreach ($komposisi_produk as $r_komposisi_produk) {
                $harga = mBahan::where('id', $r_komposisi_produk->id_bahan)->value('harga');
                $qty_komposisi = $r_komposisi_produk->qty;
                $hpp_harga = $harga * $qty_komposisi;
                $total_hpp_bahan_produk += $hpp_harga;
            }
            $total_hpp_bahan_produk = $total_hpp_bahan_produk * $qty;
            $total_hpp_bahan_produksi += $total_hpp_bahan_produk;
        }

        return $total_hpp_bahan_produksi;
    }

    /**
     *
     * Digunakan untuk mencari total harga bahan baku pengemas produk tergantung berapa progress produk yang dihasilkan dari
     * Produksi Produk
     *
     * @param $id_produksi
     * @param $qty_progress_arr
     * @return float|int
     */
    public static function persediaan_bahan_baku_pengemas_nominal($qty_bahan_pengemas_arr)
    {
        $persediaan_bahan_baku_pengemas_nominal = 0;
        foreach($qty_bahan_pengemas_arr as $qty_bahan_pengemas) {
            $qty = $qty_bahan_pengemas['qty'];
            $id_stok_bahan = $qty_bahan_pengemas['id_stok_bahan'];
            $id_bahan = mStokBahan::where('id', $id_stok_bahan)->value('id_bahan');
            $id_detail_produksi = $qty_bahan_pengemas['id_detail_produksi'];
            $hpp_bahan = mBahan::where('id', $id_bahan)->value('harga');

            $persediaan_bahan_baku_pengemas_nominal += $hpp_bahan * $qty;
        }

        return $persediaan_bahan_baku_pengemas_nominal;


        $detail_produksi = mDetailProduksi::where('id_produksi', $id_produksi)->get();
        $persediaan_bahan_baku_pengemas_nominal = 0;
        foreach ($detail_produksi as $r_detail_produksi) {
            $qty_progress = $qty_progress_arr[$r_detail_produksi->id];
            $komposisi_produk = mPengemasProduk::where('id_produk', $r_detail_produksi->id_produk)->get();
            $total_biaya_bahan_produk = 0;
            foreach ($komposisi_produk as $r_komposisi_produk) {
                $harga = mBahan::where('id', $r_komposisi_produk->id_bahan)->value('harga');
                $total_biaya_bahan_produk += $harga * $r_komposisi_produk->qty;
            }
            $persediaan_bahan_baku_pengemas_nominal += ($total_biaya_bahan_produk * $qty_progress);
        }

        return $persediaan_bahan_baku_pengemas_nominal;
    }

    /**
     *
     * Digunakan untuk mencaro total harga bahan balu produk tergantung dari berapa kali diproduksi
     *
     * @param $id_produksi
     * @return float|int
     */
    public static function persediaan_bahan_baku_produksi_nominal($id_produksi)
    {
        $detail_produksi = mDetailProduksi::where('id_produksi', $id_produksi)->get();
        $persediaan_bahan_baku_produksi_nominal = 0;
        foreach ($detail_produksi as $r_detail_produksi) {
            $komposisi_produk = mKomposisiProduk::where('id_produk', $r_detail_produksi->id_produk)->get();
            $qty_produksi = $r_detail_produksi->qty;
            $total_biaya_bahan_produk = 0;
            foreach ($komposisi_produk as $r_komposisi_produk) {
                $harga = mBahan::where('id', $r_komposisi_produk->id_bahan)->value('harga');
                $total_biaya_bahan_produk += $harga * $r_komposisi_produk->qty;
            }
            $persediaan_bahan_baku_produksi_nominal += ($total_biaya_bahan_produk * $qty_produksi);
        }

        return $persediaan_bahan_baku_produksi_nominal;
    }

}
