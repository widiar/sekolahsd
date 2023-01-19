$(document).ready(function () {

    proses_no_faktur();

    kondisi_tombol_submit();

    penjualan_select();
    bahan_row_add();

    change_biaya_tambahan();
    change_potongan();
    change_jumlah_bayar();


    /**
     * untuk pembayaran yang berisikan akunting
     */
    // add_row_pembayaran();

    ////////// Edit ////////////

    bahan_row_delete();
    bahan_modal();
    bahan_select();

    // barang_stok_modal();
    // barang_stok_select();

    change_harga();
    change_qty();
    change_ppn_nominal();

});

var base_url = $('#base-value').data('base-url');
var _token = $('#base-value').data('csrf-token');

var routePenjualanNoFaktur = $('#base-value').data('route-penjualan-no-faktur');
var routePenjualanStokBarang = $('#base-value').data('route-penjualan-stok-barang');

function penjualan_select() {
    $('#m_table_2').on('click', '.btn-pelanggan-select', function () {
        var id_pelanggan = $(this).parents('tr').data('id-pelanggan');
        var kode_pelanggan = $(this).parents('tr').data('plg-kode');
        var nama_pelanggan = $(this).parents('tr').data('plg-nama');
        var alamat_pelanggan = $(this).parents('tr').data('plg-alamat');
        var telp_pelanggan = $(this).parents('tr').data('plg-phone');

        $('[name="id_pelanggan"]').val(id_pelanggan);
        $('[name="plg_kode"]').val(kode_pelanggan);
        $('.nama_pelanggan').val("(" + kode_pelanggan + ") " + nama_pelanggan);
        $('.alamat_pelanggan').html(alamat_pelanggan);
        $('.telp_pelanggan').html(telp_pelanggan);
        $('#modal-pelanggan').modal('hide');

        proses_no_faktur();
    });
}

function proses_no_faktur() {

    var kode_pelanggan = $('[name="plg_kode"]').val();
    var id_pelanggan = $('[name="id_pelanggan"]').val();

    var data_send = {
        kode_pelanggan: kode_pelanggan,
        id_pelanggan: id_pelanggan,
        _token: _token
    };

    $.ajax({
        beforeSend: function () {
            loading_start();
        },
        url: routePenjualanNoFaktur,
        type: "POST",
        data: data_send,
        success: function (no_faktur) {
            $('[name="no_faktur"]').val(no_faktur);
            $('.no_faktur').html(no_faktur);

            loading_finish();
        }
    });

}

function bahan_row_add() {
    $('.btn-bahan-row-add').click(function () {
        var row_bahan_self = $(this);

        var bahan_row = $('.bahan-row tbody').html();
        $('.table-bahan tbody').append(bahan_row);

        var index = $('.table-bahan tbody tr').length;

        $('.table-bahan tbody tr:nth-child(' + index + ')').data('index', index);

        input_numeral();

        bahan_row_delete();
        bahan_modal();
        bahan_select();

        barang_stok_modal();
        barang_stok_select();

        change_harga();
        change_qty();
        change_ppn_nominal();

        proses_total();
        proses_grand_total();
        proses_sisa_pembayaran();

        row_barang_datepicker();

    });
}

function bahan_row_delete() {
    $('.btn-bahan-row-delete').click(function () {
        $(this).parents('tr').remove();

        proses_total();
        proses_grand_total();
        proses_sisa_pembayaran();
    });
}

function bahan_modal() {
    $('.btn-modal-bahan').click(function () {
        var index = $(this).parents('tr').data('index');
        $('#base-value').data('index', index);
        $('#modal-bahan').modal('show');
    });
}

function bahan_select() {
    $('.table').on('click', '.btn-bahan-select', function () {
        var index = $('#base-value').data('index');
        var id_barang = $(this).parents('tr').data('id-barang');
        var kode_barang = $(this).parents('tr').data('kode-barang');
        var nama_barang = $(this).parents('tr').data('nama-barang');

        $('.table-bahan tr:nth-child(' + index + ') [name="id_barang[]"]').val(id_barang);
        $('.table-bahan tr:nth-child(' + index + ') .nama-barang').html(kode_barang + ' ' + nama_barang);

        $('.table-bahan tr:nth-child(' + index + ') .btn-modal-stok-barang').prop('disabled', false);

        $('#modal-bahan').modal('hide');
    });
}

function barang_stok_modal() {

    $('.table').on('click', '.btn-modal-stok-barang', function () {
        var id_barang = $(this).parents('tr').find('[name="id_barang[]"]').val();
        var index = $(this).parents('tr').data('index');
        $('#base-value').data('index', index);

        var data_send = {
            _token: _token,
            id_barang: id_barang
        };

        $.ajax({
            url: routePenjualanStokBarang,
            type: 'post',
            data: data_send,
            success: function (data) {
                $('#modal-barang-stok .modal-body tbody').html(data);
                $('#modal-barang-stok').modal('show');
            }
        });
    });
}

function barang_stok_select() {
    $('.table').on('click', '.btn-stok-barang-select', function () {
        var index = $('#base-value').data('index');
        var id_stok_barang = $(this).parents('tr').data('id-stok-barang');
        var sbr_kode_batch = $(this).parents('tr').data('sbr-kode-batch');
        var sbr_harga_beli = $(this).parents('tr').data('sbr-harga-beli');
        var sbr_harga_jual = $(this).parents('tr').data('sbr-harga-jual');
        var sbr_qty = $(this).parents('tr').data('sbr-qty');

        $('.table-bahan tr:nth-child(' + index + ') [name="id_stok_barang[]"]').val(id_stok_barang);
        $('.table-bahan tr:nth-child(' + index + ') .nama-stok-barang').html(sbr_kode_batch);
        $('.table-bahan tr:nth-child(' + index + ') [name="harga_beli[]"]').val(sbr_harga_beli);
        $('.table-bahan tr:nth-child(' + index + ') .stok-barang').html(sbr_qty);
        $('.table-bahan tr:nth-child(' + index + ') [name="harga_jual[]"]').val(format_number(sbr_harga_jual));

        $('#modal-barang-stok').modal('hide');

        proses_ppn_nominal(index);
        proses_harga_net(index);
        proses_sub_total(index);

        proses_total();
        proses_grand_total();
        proses_sisa_pembayaran();

    });
}

function change_harga() {
    $('[name="harga_jual[]"]').on('change keyup', function () {

        var index = $(this).parents('tr').data('index');

        proses_ppn_nominal(index);
        proses_harga_net(index);
        proses_sub_total(index);

        proses_total();
        proses_grand_total();
        proses_sisa_pembayaran();
    });
}

function change_ppn_nominal() {
    $('[name="ppn_nominal[]"]').on('change keyup', function () {
        var index = $(this).parents('tr').data('index');
        proses_sub_total(index);
        proses_harga_net(index);
        proses_total();
        proses_grand_total();
        proses_sisa_pembayaran();
    });
}

function change_qty() {
    $('[name="qty[]"]').on('change keyup', function () {
        var index = $(this).parents('tr').data('index');

        proses_harga_net(index);
        proses_sub_total(index);

        proses_total();
        proses_grand_total();
        proses_sisa_pembayaran();
    });
}

function change_biaya_tambahan() {
    $('[name="biaya_tambahan"]').on('change keyup', function () {
        proses_grand_total();
        proses_sisa_pembayaran();
    });
}

function change_potongan() {
    $('[name="potongan"]').on('change keyup', function () {
        proses_grand_total();
        proses_sisa_pembayaran();
    });
}

function change_jumlah_bayar() {
    $('[name="jumlah_bayar"]').on('change keyup', function () {
        proses_sisa_pembayaran();
    });
}


function proses_ppn_nominal(index) {
    var ppn_persen = $('#base-value').data('ppn-persen');
    var harga = $('.table-bahan tr:nth-child(' + index + ') [name="harga_jual[]"]').val();
    harga = strtonumber(harga);

    var ppn_nominal = parseFloat(harga) * (parseFloat(ppn_persen) / parseFloat(100));
    ppn_nominal = Math.round(ppn_nominal * 100) / 100;
    ppn_nominal = format_number(ppn_nominal);

    $('.table-bahan tr:nth-child(' + index + ') [name="ppn_nominal[]"]').val(ppn_nominal);
    //$('.table-bahan tr:nth-child('+index+') .ppn-nominal').html(format_number(ppn_nominal));
}

function proses_harga_net(index) {
    var harga = $('.table-bahan tr:nth-child(' + index + ') [name="harga_jual[]"]').val();
    harga = strtonumber(harga);

    var ppn_nominal = $('.table-bahan tr:nth-child(' + index + ') [name="ppn_nominal[]"]').val();
    ppn_nominal = strtonumber(ppn_nominal);

    var harga_net = parseFloat(harga) + parseFloat(ppn_nominal);
    harga_net = Math.ceil(harga_net);

    $('.table-bahan tr:nth-child(' + index + ') [name="harga_net[]"]').val(harga_net);
    $('.table-bahan tr:nth-child(' + index + ') .harga-net').html(format_number(harga_net));

}

function proses_sub_total(index) {
    var harga_net = $('.table-bahan tr:nth-child(' + index + ') [name="harga_jual[]"]').val();
    harga_net = strtonumber(harga_net);

    var qty = $('.table-bahan tr:nth-child(' + index + ') [name="qty[]"]').val();
    qty = strtonumber(qty);

    var sub_total = parseFloat(harga_net) * parseFloat(qty);

    //console.log(harga_net+' - '+qty);

    sub_total = Math.ceil(sub_total);

    $('.table-bahan tr:nth-child(' + index + ') [name="sub_total[]"]').val(sub_total);
    $('.table-bahan tr:nth-child(' + index + ') .sub-total').html(format_number(sub_total));
}

function proses_total() {
    var total = 0;
    $('[name="sub_total[]"]').each(function () {
        var sub_total = $(this).val();
        total = parseFloat(total) + parseFloat(sub_total);
    });

    $('[name="total"]').val(total);
    $('.total').html(format_number(total));
}

function proses_grand_total() {
    var total = $('[name="total"]').val();
    var biaya_tambahan = $('[name="biaya_tambahan"]').val();
    biaya_tambahan = strtonumber(biaya_tambahan);

    var potongan = $('[name="potongan"]').val();
    potongan = strtonumber(potongan);

    var grand_total = parseFloat(total) + parseFloat(biaya_tambahan) - parseFloat(potongan);

    $('[name="grand_total"]').val(grand_total);
    $('.grand-total').html(format_number(grand_total));
}

function proses_sisa_pembayaran() {
    var grand_total = $('[name="grand_total"]').val();

    var jumlah_bayar = $('[name="jumlah_bayar"]').val();
    jumlah_bayar = strtonumber(jumlah_bayar);

    var sisa_pembayaran = parseFloat(grand_total) - parseFloat(jumlah_bayar);
    // console.log('proses_sisa_pembayaran', grand_total, jumlah_bayar, sisa_pembayaran);

    $('[name="sisa_pembayaran"]').val(sisa_pembayaran);
    $('.sisa-pembayaran').text(format_number(sisa_pembayaran));

    if (sisa_pembayaran > 0) {
        $('.div-jatuh-tempo').removeClass('m--hide');
    } else {
        $('.div-jatuh-tempo').addClass('m--hide');
    }

}

function kondisi_tombol_submit() {
    $('.btn-simpan').hide();
    $('.btn-selanjutnya').click(function () {
        $(this).hide();
        $('.btn-simpan').show();
    });
    $('.btn-modal-pembayaran-tutup').click(function () {
        $('.btn-simpan').hide();
        $('.btn-selanjutnya').show();
    });

    $('.btn-kembali').click(function (e) {
        e.preventDefault();
        if ($('#modal-pembayaran').hasClass('show')) {
            $('#modal-pembayaran').modal('hide');
            $('.btn-simpan').hide();
            $('.btn-selanjutnya').show();
        } else {
            var href = $(this).attr('href');
            window.location.href = href;
        }

        return false;
    });
}

function row_barang_datepicker() {
    $('.m_datepicker').datepicker({
        todayHighlight: true,
        // todayBtn: "linked",
        // clearBtn: true,
        format: 'dd-mm-yyyy',
        orientation: "bottom left",
        autoclose: true,
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    }).on('change', function () {
        $('.datepicker').hide();
    });
}

/**
 * Ini digunakan untuk pembayaran yang ada fitur akuntingnya.
 */

////////////////////// Modal Pembayaran //////////////////////


/*
function add_row_pembayaran() {
    $('.btn-add-row-pembayaran').click(function () {
        var row_pembayaran = $('.row-pembayaran tbody').html();
        $('.table-pembayaran tbody').append(row_pembayaran);

        var index = $('.table-pembayaran tbody tr').length;

        $('.table-pembayaran tbody tr:nth-child(' + index + ')').data('index', index);
        $('.table-pembayaran tbody tr:nth-child(' + index + ') .touchspin-pembayaran').TouchSpin(touchspin_number_decimal);
        $('.table-pembayaran tbody tr:nth-child(' + index + ') .datepicker-pembayaran').datepicker({
            rtl: mUtil.isRTL(),
            todayHighlight: !0,
            orientation: "bottom left",
            format: 'dd-mm-yyyy'
        });
        $('.table-pembayaran tbody tr:nth-child(' + index + ') .select2-pembayaran').select2();

        change_pembayaran();
        change_jumlah();
        delete_row_pembayaran();
    });
}

function delete_row_pembayaran() {
    $('.btn-delete-row-pembayaran').click(function () {
        $(this).parents('tr').remove();

        proses_terbayar();
        proses_sisa_pembayaran();
        proses_kembalian();
    });
}

function change_pembayaran() {
    $('[name="master_id[]"]').change(function () {
        proses_jumlah($(this));
        proses_terbayar();
        proses_sisa_pembayaran();
    });
}

function change_jumlah() {
    $('[name="jumlah[]"]').on('change keyup', function () {
        proses_jumlah($(this));
    });
}

function proses_jumlah(self) {
    var grand_total = $('[name="grand_total"]').val();
    var jumlah_all = 0;
    var jumlah = grand_total;
    $('[name="jumlah[]"]').each(function () {
        jumlah_all = parseFloat(jumlah_all) + parseFloat($(this).val());
    });

    //console.log(jumlah_all+' '+grand_total);

    if (jumlah_all <= grand_total) {
        jumlah = grand_total - jumlah_all;
    }

    self.parents('td').siblings('td.td-jumlah').children('div').children('[name="jumlah[]"]').val(jumlah);


    proses_terbayar();
}

function proses_terbayar() {
    var terbayar = 0;
    $('[name="jumlah[]"]').each(function () {
        var jumlah = $(this).val();
        terbayar = parseFloat(terbayar) + parseFloat(jumlah);
    });

    $('.terbayar').html(format_number(terbayar));
    $('[name="terbayar"]').val(terbayar);

    proses_sisa_pembayaran();
    proses_kembalian();
}

function proses_sisa_pembayaran() {
    var grand_total = $('[name="grand_total"]').val();
    var terbayar = $('[name="terbayar"]').val();

    grand_total = parseFloat(grand_total);
    terbayar = parseFloat(terbayar);

    var sisa = grand_total - terbayar;

    if (terbayar > grand_total) {
        sisa = 0;
    }


    $('.sisa-pembayaran').html(format_number(sisa));
    $('[name="sisa_pemabayaran"]').val(sisa);
}

function proses_kembalian() {
    var grand_total = $('[name="grand_total"]').val();
    var terbayar = $('[name="terbayar"]').val();

    grand_total = parseFloat(grand_total);
    terbayar = parseFloat(terbayar);

    var kembalian = terbayar - grand_total;

    if (terbayar <= grand_total) {
        kembalian = 0;
    }


    $('.kembalian').html(format_number(kembalian));
    $('[name="kembalian"]').val(kembalian);
}*/
