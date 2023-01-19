$(document).ready(function () {

    change_status_bahan();

    kondisi_tombol_submit();

    supplier_select();
    bahan_row_add();

    change_total_ppn();
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
    change_harga();
    change_qty();
    change_ppn_nominal();

});

var base_url = $('#base-value').data('base-url');
var _token = $('#base-value').data('csrf-token');

var routePembelianNoFaktur = $('#base-value').data('route-pembelian-no-faktur');

var routePoBahanSupplierBahanStok = $('#base-value').data('route-po-bahan-supplier-bahan-stok');
var routePoBahanSupplierBahanNoFaktur = $('#base-value').data('route-po-bahan-supplier-no-faktur');
var routePoBahanSupplierBahanDatang = $('#base-value').data('route-po-bahan-supplier-bahan-datang');

function change_status_bahan() {
    $('.datatable-general').on('click', '.btn-bahan-datang', function () {
        var id_po_bahan = $(this).data('id-po-bahan');
        var status_pembelian = $(this).data('status-pembelian');
        var data_send = {
            id_po_bahan: id_po_bahan,
            _token: _token
        };

        if (status_pembelian == 'not_yet') {
            swal({
                title: "Perhatian ...",
                html: 'Lakukan <strong>Pembelian</strong> terlebih dahulu',
                type: "warning",
                showCancelButton: false,
                confirmButtonText: "Baik",
                cancelButtonText: "Batal",
            })
        } else {

            swal({
                title: "Perhatian ...",
                html: '<strong>Yakin</strong> Bahan sudah Semuanya sampai ?<br />Bahan akan masuk ke dalam <strong>Stok Bahan</strong>.',
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Ya, yakin",
                cancelButtonText: "Batal",
            }).then(function (e) {
                if (e.value) {
                    $.ajax({
                        url: routePoBahanSupplierBahanDatang,
                        type: "post",
                        data: data_send,
                        success: function () {
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });
}

function supplier_select() {
    $('#m_table_2').on('click', '.btn-supplier-select', function () {
        var id_supplier = $(this).parents('tr').data('id-supplier');
        var kode_supplier = $(this).parents('tr').data('spl-kode');
        var nama_supplier = $(this).parents('tr').data('spl-nama');
        var alamat_supplier = $(this).parents('tr').data('spl-alamat');
        var telp_supplier = $(this).parents('tr').data('spl-phone');

        $('[name="id_supplier"]').val(id_supplier);
        $('[name="kode_supplier"]').val(kode_supplier);
        $('.nama_supplier').val("(" + kode_supplier + ") " + nama_supplier);
        $('.alamat_supplier').html(alamat_supplier);
        $('.telp_supplier').html(telp_supplier);
        $('#modal-supplier').modal('hide');

        proses_no_faktur();
    });
}

function proses_no_faktur() {

    var kode_supplier = $('[name="kode_supplier"]').val();
    var id_supplier = $('[name="id_supplier"]').val();

    var data_send = {
        kode_supplier: kode_supplier,
        id_supplier: id_supplier,
        _token: _token
    };

    $.ajax({
        beforeSend: function () {
            loading_start();
        },
        url: routePembelianNoFaktur,
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
        var bahan_row = $('.bahan-row tbody').html();
        $('.table-bahan tbody').append(bahan_row);

        var index = $('.table-bahan tbody tr').length;

        console.log(index);

        $('.table-bahan tbody tr:nth-child(' + index + ')').data('index', index);

        input_numeral();

        bahan_row_delete();
        bahan_modal();
        bahan_select();
        change_harga();
        change_qty();
        // change_ppn_nominal();

        proses_total();
        proses_total_ppn();
        proses_grand_total();
        proses_sisa_pembayaran();

        row_barang_datepicker();

    });
}

function bahan_row_delete() {
    $('.btn-bahan-row-delete').click(function () {
        $(this).parents('tr').remove();

        proses_total();
        proses_total_ppn();
        proses_grand_total();
        proses_sisa_pembayaran();
    });
}

function bahan_modal() {
    $('.btn-modal-bahan').click(function () {
        var index = $(this).parents('tr').data('index');
        $('#base-value').data('index', index);
        $('#modal-bahan').modal('show');

        bahan_stok();
    });
}

function bahan_stok() {
    $('.table').on('click', '.btn-bahan-stok', function () {
        var id_bahan = $(this).parents('tr').data('id');

        $.ajax({
            beforeSend: function () {
                $('#modal-bahan-stok .modal-body').html('');
                loading_start();
            },
            url: routePoBahanSupplierBahanStok,
            type: "POST",
            data: {
                _token: _token,
                id_bahan: id_bahan
            },
            success: function (view) {

                $('#modal-bahan-stok .modal-body').html(view);
                $('#modal-bahan-stok').modal('show');
                loading_finish();
            }
        });
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

        // proses_ppn_nominal(index);
        // proses_harga_net(index);
        proses_sub_total(index);

        proses_total();
        proses_total_ppn();
        proses_grand_total();
        proses_sisa_pembayaran();

        $('#modal-bahan').modal('hide');
    });
}

function change_harga() {
    $('[name="harga_beli[]"]').on('change keyup', function () {

        var index = $(this).parents('tr').data('index');

        // proses_ppn_nominal(index);
        // proses_harga_net(index);
        proses_sub_total(index);

        proses_total();
        proses_total_ppn();
        proses_grand_total();
        proses_sisa_pembayaran();
    });
}

function change_ppn_nominal() {
    $('[name="ppn_nominal[]"]').on('change keyup', function () {
        var index = $(this).parents('tr').data('index');
        proses_sub_total(index);
        // proses_harga_net(index);
        proses_total();
        proses_total_ppn();
        proses_grand_total();
        proses_sisa_pembayaran();
    });
}

function change_qty() {
    $('[name="qty[]"]').on('change keyup', function () {
        var index = $(this).parents('tr').data('index');

        // proses_harga_net(index);
        proses_sub_total(index);

        proses_total();
        proses_total_ppn();
        proses_grand_total();
        proses_sisa_pembayaran();
    });
}

function change_total_ppn() {
    $('[name="total_ppn"]').on('change keyup', function () {
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
    var harga = $('.table-bahan tr:nth-child(' + index + ') [name="harga_beli[]"]').val();
    harga = strtonumber(harga);

    var ppn_nominal = parseFloat(harga) * (parseFloat(ppn_persen) / parseFloat(100));
    ppn_nominal = Math.round(ppn_nominal * 100) / 100;
    ppn_nominal = format_number(ppn_nominal);

    $('.table-bahan tr:nth-child(' + index + ') [name="ppn_nominal[]"]').val(ppn_nominal);
    $('.table-bahan tr:nth-child(' + index + ') .ppn-nominal').html(format_number(ppn_nominal));
}

function proses_harga_net(index) {
    var harga = $('.table-bahan tr:nth-child(' + index + ') [name="harga_beli[]"]').val();
    harga = strtonumber(harga);

    var ppn_nominal = $('.table-bahan tr:nth-child(' + index + ') [name="ppn_nominal[]"]').val();
    ppn_nominal = strtonumber(ppn_nominal);

    var harga_net = parseFloat(harga) + parseFloat(ppn_nominal);
    harga_net = Math.ceil(harga_net);

    $('.table-bahan tr:nth-child(' + index + ') [name="harga_net[]"]').val(harga_net);
    $('.table-bahan tr:nth-child(' + index + ') .harga-net').html(format_number(harga_net));

}

function proses_sub_total(index) {
    var harga_net = $('.table-bahan tr:nth-child(' + index + ') [name="harga_net[]"]').val();
    harga_net = strtonumber(harga_net);

    var harga_beli = $('.table-bahan tr:nth-child(' + index + ') [name="harga_beli[]"]').val();
    harga_beli = strtonumber(harga_beli);

    var qty = $('.table-bahan tr:nth-child(' + index + ') [name="qty[]"]').val();
    qty = strtonumber(qty);

    var sub_total = parseFloat(harga_beli) * parseFloat(qty);

    // console.log(harga_net, qty, sub_total);

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

function proses_total_ppn() {
    var total = $('[name="total"]').val();
    var ppn_persen = $('#base-value').data('ppn-persen');

    var total_ppn = parseFloat(total) * (parseFloat(ppn_persen) / parseFloat(100));
    console.log('total_ppn', total, ppn_persen );

    $('[name="total_ppn"]').val(format_number(total_ppn));
}

function proses_grand_total() {
    var total = $('[name="total"]').val();
    var total_ppn = $('[name="total_ppn"]').val();
    total_ppn = strtonumber(total_ppn);
    var biaya_tambahan = $('[name="biaya_tambahan"]').val();
    biaya_tambahan = strtonumber(biaya_tambahan);

    var potongan = $('[name="potongan"]').val();
    potongan = strtonumber(potongan);

    var grand_total = parseFloat(total) + parseFloat(total_ppn) + parseFloat(biaya_tambahan) - parseFloat(potongan);

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
