$(document).ready(function () {

    var csrf_token = $('#base-value').data('csrf-token');
    var base_url = $('#base-value').data('base-url');
    var select_url = $('#select_url').data('select-url');
    var satuan = $('#json_satuan').length > 0 ? JSON.parse($('#json_satuan').html()) : [];
    var noCount = 1;
    var noChoose = 0;
    var totalItem = 0;
    var editedRow = 0;
    var hargaBeli = 0;

    user_role();
    user_role_menu_action();

    $('.btn-simpan-pemindahan').click(function (e) {
        e.preventDefault();
        console.log('simpan-pemindahan')
        $('.btn-simpan-pemindahan').prop("disabled", true);
        $('.btn-simpan-pemindahan').text('Menyimpan...');
        setTimeout(function () {
            $(".form-kirim").submit();
        }, 10);

    });

    function thousandNumeral(data) {
        new Cleave(data, {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        })
    }


    /**
     *  Begin General Operations
     *
     *  data attribute :
     *  - confirm (true|false)
     *  - action (url controller)
     - method (post|put|dll)
     - redirect (url halaman redirect)
     - alert-show (setelah action, apakah muncul sweet alert)
     - alert-field-message (setelah action, apakah muncul sweet alert yang di texdt nya ada, field error)
     */
    $('.form-kirim').submit(function (e) {
        e.preventDefault();

        var self = $(this);
        var confirm = $(this).data('confirm');
        if (confirm) {
            swal({
                title: "Perhatian ...",
                text: "Yakin Simpan data ini ?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Ya, yakin",
                cancelButtonText: "Batal",
            }).then(function (e) {
                if (e.value) {
                    form_kirim(self);
                }
            });
        } else {
            form_kirim(self);
        }

        return false;
    });

    function form_kirim(self) {

        var action = self.attr('action');
        var method = self.attr('method');

        var redirect = self.data('redirect');
        var alert_show = self.data('alert-show');
        var alert_field_message = self.data('alert-field-message');
        var message = '';
        var message_field = '';

        var form = self;
        var formData = new FormData(form[0]);

        var totalItem = self.find('[name="totalItem"]');
        $.ajax({
            url: action,
            type: method,
            data: formData,
            async: false,
            beforeSend: function () {
                loading_start();
            },
            error: function (request, error) {
                loading_finish();
                $('.form-control-feedback').remove();
                $('.form-group').removeClass('has-danger');
                $.each(request.responseJSON.errors, function (key, val) {
                    var type = $('[name="' + key + '"]').attr('type');
                    var fieldClass = $('[name="' + key + '"]').attr('class');
                    $('[name="' + key + '"]').parents('.form-group').addClass('has-danger');
                    message_field += val[0] + '<br />';
                    /**
                     * check apakah tipe inputan merupakan file atau tidak
                     */
                    if (type == 'file') {
                        $('[name="' + key + '"]').parents('.input-group').after('<div class="form-control-feedback">' + val[0] + '</div>');

                    } else if (type == 'hidden') {

                    } else if (fieldClass == 'form-control m-select2 m_select2_1 select2-hidden-accessible') {
                        // check apakah inputan merupakan select2
                        $('[name="' + key + '"]').siblings('span').after('<div class="form-control-feedback">' + val[0] + '</div>');

                    } else {
                        /**
                         * check apakah inputan merupakan piutangLain atau tidak
                         */
                        if ($('[name="' + key + '"]').parent('div').hasClass('bootstrap-touchspin')) {
                            $('[name="' + key + '"]').parent('div').after('<div class="form-control-feedback">' + val[0] + '</div>');
                        } else {
                            $('[name="' + key + '"]').after('<div class="form-control-feedback">' + val[0] + '</div>');
                        }
                    }
                });

                if (alert_show == true) {
                    if (alert_field_message == true) {
                        if (message_field) {
                            message = message_field;
                        } else {
                            message = request.responseJSON.message;
                        }
                    } else {
                        message = request.responseJSON.message;
                    }

                    swal({
                        title: "Ada yang Salah",
                        html: message,
                        type: "warning"
                    });
                }
            },
            success: function (data) {
                loading_finish();
                if (typeof redirect == 'undefined') {
                    $(".datatable").length > 0 ? table.ajax.reload() : window.location.reload();
                    form_clear();
                } else {
                    window.location.href = redirect;
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }

    function form_clear() {
        $(".modal").modal("hide");
        $("input[type=text]").val('');
        $("input[type=email]").val('');
        $("input[type=password]").val('');
        $("input[type=checkbox]").prop("checked", false);
        $("textarea").val('');
        $('select option:first-child').attr("selected", "selected");
    }

    var actionButton = {
        "add-barang": {
            "class": "btn-add-barang akses-add-barang",
            "icon": "fa fa-check-square",
            "label": "Pilih"
        },
        "edit": {
            "class": "btn-edit akses-edit",
            "icon": "fa fa-pencil-alt",
            "label": "Edit"
        },
        "delete": {
            "class": "btn-hapus akses-delete",
            "icon": "la la-remove",
            "label": "Hapus"
        },
    };
    var action = $("#action_list").length > 0 ? JSON.parse($("#action_list").html()) : [];
    var columns = $("#table_coloumn").length > 0 ? JSON.parse($("#table_coloumn").html()) : [];
    var defAction = {
        targets: -1,
        responsivePriority: 1,
        title: 'Actions',
        orderable: false,
        render: function (data, type, full, meta) {
            var template = '<label class="hidden">' + JSON.stringify(data) + '</label>';
            console.log(data)
            var actionList = '';
            actionList = '<a class="m-btn btn btn-success btn-chose" id="masuk"><i class="fa fa-check-square"></i> Pilih</a>';
            var dropdown = '<div class="btn-group m-btn-group btn-group-sm" role="group" aria-label="First group">' +
                actionList + template +
                '</div>'
            return dropdown;
        },

    }
    columns.push({data: null, mData: null})
    var coloumnDef = [defAction]

    var table = $('.tableBarang').length < 1 ? '' : $('.tableBarang').DataTable({
        responsive: true,
        searchDelay: 500,
        processing: true,
        serverSide: true,
        ordering: false,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        pageLength: 10,
        // dom: `<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
        ajax: $('#select_url').attr("data-select-url"),
        columns: columns,
        columnDefs: coloumnDef
    });

    $('#select_dari').change(function () {
        // var idLokasi = $(this).data('no');
        var idLokasi = $(this).val();
        sess_change_lokasi(idLokasi);
    });

    // function pengubah data barang berdasarkan lokasi dari gudang yang dipilih
    function sess_change_lokasi(key) {
        $.ajax({
            type: "POST",
            url: base_url + '/admin/pemindahan-stok-session',
            data: {
                'lokasi_id': key,
                '_token': $("input[name=_token]").val()
            },
            cache: false,
            success: function (response) {
                // console.log(response + this.data)
                table.ajax.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.responseText);
                console.log(thrownError);
            }
        });
    }

    //================== function untuk menambahkan data barang yang akan dipindahkan =================
    $('.tableBarang').on('click', '.btn-chose', function () {
        console.log($(this))
        var dataText = '';
        dataText = $(this).siblings().html();
        console.log(dataText)
        data = JSON.parse(dataText);

        // check apakah modal yang muncul adalah modal tambah barang atau edit barang
        if ($(this).parents('table').attr('class') == 'tableBarang table table-striped- table-bordered table-hover table-checkable datatable-general table-add dataTable no-footer dtr-inline') {
            add_barang(data);
        } else if ($(this).parents('table').attr('class') == 'tableBarang table table-striped- table-bordered table-hover table-checkable datatable-general table-edit dataTable no-footer dtr-inline') {
            edit_barang(data);
        }

        // check Harga Beli (Assembly) ada
        if ($('input[name="harga_beli_terakhir_barang"]').length) {
            hitungHargaBarang();
        }
    })

    // FIXME : buat itemRow() memiliki parameter yang nantinya langsung memasukkan data" yang diperlukan, pada saat membuat <tr>
    function add_barang(data) {
        $('#listBarangPindah').append(itemRow());
        console.log(data)
        $('#kode-row-' + noCount).val(data.kode_barang);
        $('#id-row-stok-' + noCount).val(data.id);
        $('#id-row-barang-' + noCount).val(data.id_barang);
        $('#id-row-supplier-' + noCount).val(data.id_supplier);
        $('#harga-beli-barang-' + noCount).val(data.harga_beli_terakhir_barang);
        $('#nama-row-' + noCount).html(data.nama_barang);
        $('#qty-row-' + noCount).attr('max', data.jml_barang);
        $('#satuan-row-' + noCount).html(data.satuan);
        $('#lokasi-row-' + noCount).html(data.lokasi);
        $('#jml-barang-row-' + noCount).html(data.jml_barang);
        $('#pemindahan_stok_add').modal('hide');
        $('#row-pemindahan-stok').append(itemInput(data.kode_barang, data.id, data.id_barang, data.id_supplier, data.nama_barang, data.lokasi, data.id_satuan, data.jml_barang));
        noCount++;
        noChoose++;
        totalItem++;
        $('#total-item-pemindahan-stok').attr('value', totalItem);


        input_numeral();
        getTotalQty();
    }

    var itemRow = function () {
        var text = '<tr id="row-' + noCount + '" data-no="' + noCount + '">';
        text += '<td><div class="input-group">' +
            '<input type="text" class="form-control" id="kode-row-' + noCount + '" placeholder="Kode Produk" value="" readonly>' +
            '<input type="hidden" id="id-row-stok-' + noCount + '">' +
            '<input type="hidden" id="id-row-barang-' + noCount + '">' +
            '<input type="hidden" id="id-row-supplier-' + noCount + '">' +
            '<input type="hidden" id="harga-beli-barang-' + noCount + '">' +
            '<div class="input-group-append">' +
            '<a class="btn btn-primary btn-view" data-toggle="modal"  data-no="' + noCount + '" data-target="#pemindahan_stok_edit"><i class="fa flaticon-search"></i></a>' +
            '</div>' +
            '</div>' +
            '</td>'
        text += '<td id="nama-row-' + noCount + '">Produk A</td>'
        text += '<td id="lokasi-row-' + noCount + '"></td>'
        text += '<td id="jml-barang-row-' + noCount + '"></td>'

        text += '<td><input type="number" id="qty-row-' + noCount + '" class="form-control m-input qty-item" data-no="' + noCount + '" placeholder="Qty" value="0" min="0.01" step="0.01"></td>'
        text += '<td id="satuan-row-' + noCount + '"></td>'
        text += '<td><div class="btn-group" role="group" aria-label="First group">' +
            '<a class="btn btn-danger btn-delete" id="barang' + noCount + '" data-no="' + noCount + '"><i class="la la-trash"></i></a>' +
            '</div>' +
            '</td>'
        text += '</tr>'
        return text;
    }

    var itemInput = function(kode, id, id_barang, id_supplier, nama, id_satuan) {
        var text = '<div id="item-pemindahan-'+noCount+'">';
            text += '<input type="hidden" class="item_kode" id="item-' + noCount + '-kode" name="item_kode[]" value="'+(kode != undefined ? kode : '')+'">'
            text += '<input type="hidden" class="item_id_stok" id="item-' + noCount + '-id-stok" name="item_id_stok[]" value="'+(id != undefined ? id : '')+'">'
            text += '<input type="hidden" class="item_id_barang" id="item-' + noCount + '-id-barang" name="item_id_barang[]" value="' + (id_barang != undefined ? id_barang : '') + '">'
            text += '<input type="hidden" class="item_id_supplier" id="item-' + noCount + '-id-supplier" name="item_id_supplier[]" value="' + (id_supplier != undefined ? id_supplier : '') + '">'
            text += '<input type="hidden" class="item_nama" id="item-' + noCount + '-nama" name="item_nama[]" value="'+(nama != undefined ? nama : '')+'">'
            text += '<input type="hidden" class="item_qty" id="item-' + noCount + '-qty" name="item_qty[]" value="0">'
            text += '<input type="hidden" class="item_satuan" id="item-' + noCount + '-satuan" name="item_satuan[]" value="' + (id_satuan != undefined ? id_satuan : '') + '">'
        text += '</div>'
        return text;
    }

    var optionSatuan = function (satuan, i) {
        var text = '<option id="option-satuan-' + noCount + i + '" value="' + satuan.satuan + '">' + satuan.satuan + '</option>'
        return text;
    }
    //================== akhir function untuk menambahkan data barang yang akan dipindahkan =================

    //================== start function untuk menghapus data barang yang akan dipindahkan =================

    $('#listBarangPindah').on('click', '.btn-delete', function () {
        var noRow = $(this).data('no');
        $("#row-" + noRow).remove();
        $("#item-pemindahan-" + noRow).remove();
        totalItem--;

        getTotalQty();
        if ($('input[name="harga_beli_terakhir_barang"]').length) {
            hitungHargaBarang();
        }
    })

    //================== akhir function untuk menghapus data barang yang akan dipindahkan =================

    //================== start function untuk jumlah kuantitas data barang yang akan dipindahkan =================

    $('#listBarangPindah').on('keyup', '.qty-item', function () {
        getTotalQty();
        var noChanged = $(this).data('no');
        $('#item-' + noChanged + '-qty').val($('#qty-row-' + noChanged + '').val());
        if ($('input[name="harga_beli_terakhir_barang"]').length) {
            hitungHargaBarang();
        }
    })

    $('#listBarangPindah').on('change', '.qty-item', function () {
        var noChanged = $(this).data('no');
        if (parseInt($(this).val()) > parseInt($(this).attr('max'))) {
            $(this).val($(this).attr('max'));
        }
        $('#item-' + noChanged + '-qty').val($(this).val());
        getTotalQty();
        if ($('input[name="harga_beli_terakhir_barang"]').length) {
            hitungHargaBarang();
        }
    })

    $('#listBarangPindah').on('change', '.satuan-item', function () {
        var noChanged = $(this).data('no');
        $('#item-' + noChanged + '-satuan').val($('#satuan-row-' + noChanged + '').val());
    })

    // TODO : tambahkan fungsi pembagian ribuan
    function getTotalQty() {
        var totalQty = 0;

        for (let i = 1; i <= noChoose; i++) {
            // console.log('row '+i+' : '+$('#qty-row-' + i).val());
            var value = $('#qty-row-' + i).val();
            if (!value) {
                totalQty += 0;
                continue;
            } else {
                if (value != undefined && value != NaN && totalItem >= 0) {
                    totalQty += parseInt($('#qty-row-' + i).val());
                }
                continue;
            }
        }
        $('#input-total-persediaan').val(totalQty);
    }

    //================== akhir function untuk jumlah kuantitas data barang yang akan dipindahkan =================

    //================== start function untuk mengedit data barang yang akan dipindahkan =================

    $('#listBarangPindah').on('click', '.btn-view', function () {
        editedRow = $(this).data('no');
        // console.log(editedRow);
    })

    function edit_barang(data) {
        // console.log(data.id_satuan);
        $('#kode-row-' + editedRow).val(data.kode_barang);
        $('#id-row-stok-' + editedRow).val(data.id);
        $('#id-row-barang-' + editedRow).val(data.id_barang);
        $('#id-row-supplier-' + editedRow).val(data.id_supplier);
        $('#nama-row-' + editedRow).html(data.nama_barang);
        $('#satuan-row-' + editedRow).html(data.satuan);
        $('#lokasi-row-' + editedRow).html(data.lokasi);
        $('#jml-barang-row-' + editedRow).html(data.jml_barang);
        $('#harga-beli-barang-' + editedRow).val(data.harga_beli_terakhir_barang);

        // hidden input edit
        $('#item-' + editedRow + '-kode').val(data.kode_barang);
        $('#item-' + editedRow + '-id-stok').val(data.id);
        $('#item-' + editedRow + '-id-barang').val(data.id_barang);
        $('#item-' + editedRow + '-id-supplier').val(data.id_supplier);
        $('#item-' + editedRow + '-nama').val(data.nama_barang);
        $('#item-' + editedRow + '-satuan').val(data.id_satuan);
        $('#pemindahan_stok_edit').modal('hide');
        getTotalQty();
        if ($('input[name="harga_beli_terakhir_barang"]').length) {
            hitungHargaBarang();
        }
    }

    //================== akhir function untuk jumlah kuantitas data barang yang akan dipindahkan =================

    // Menentukan jumlah noCount noChoose dan totalItem di awal pembukaan. Paling berguna disaat accept data pemindahan
    $('#listBarangPindah').ready(function () {
        while (!isEmpty($('#row-' + noCount))) {
            noCount++;
            noChoose++;
            totalItem++;
        }
        getTotalQty();
        $('#total-item-pemindahan-stok').attr('value', totalItem);
        if ($('input[name="harga_beli_terakhir_barang"]').length) {
            hitungHargaBarang();
        }
        // console.log('noCount:'+noCount+' noChoose:'+noChoose+' totalItem:'+totalItem);
    })

    function isEmpty(obj) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }


    $('#modal-tambah-stok-opname').on('keyup change mouseup', '#qty-data', function () {
        var valueData = parseFloat($(this).val(), 2);
        var valueFisik = parseFloat($('#qty-fisik').val(), 2);
        var pengurangan = parseFloat(Math.abs(valueData - valueFisik), 2);
        $('#qty-selisih').val(pengurangan);
    })

    $('#modal-tambah-stok-opname').on('keyup change mouseup', '#qty-fisik', function () {
        var valueFisik = parseFloat($(this).val(), 2);
        var valueData = parseFloat($('#qty-data').val(), 2);
        var pengurangan = parseFloat(Math.abs(valueData - valueFisik), 2);
        $('#qty-selisih').val(pengurangan);
    })


    // ============ START CHANGE LOCATION OPTION LIST FOR STOK OPNAME =============
    var selectedIdBarang = 0;

    $('#modal-tambah-stok-opname').on('change', '#id_barang', function () {
        selectedIdBarang = $('#id_barang').val();
        // console.log('Selected ID Barang : ' + selectedIdBarang);
        $.ajax({
            type: 'POST',
            url: base_url + '/admin/stok-opname-lokasi',
            data: {
                'id_barang': selectedIdBarang,
                '_token': $("input[name=_token]").val()
            },
            success: function (data) {
                var selectLocation = $('#filter-lokasi-on-barang');
                selectLocation.empty();
                selectLocation.append('<option value="">Pilih Lokasi</option>')
                for (let index = 0; index < data.length; index++) {
                    selectLocation.append('<option value="' + data[index].id_lokasi + '" data-jumlah="' + parseFloat(data[index].jml_barang, 2) + '" data-stok="' + data[index].id_stok + '">' + data[index].lokasi + '</option>')
                }
            }
        })
    })

    $('#modal-tambah-stok-opname').on('change', '#filter-lokasi-on-barang', function () {
        $('#qty-data').val(parseFloat($(this).find('option:selected').data('jumlah'), 2));
        $('#id_stok').val($(this).find('option:selected').data('stok'));
    })
    // ============ END CHANGE LOCATION OPTION LIST FOR STOK OPNAME =============

    $('#id-barang-komisi').select2({
        tags: true,
        dropdownParent: $("#modal-create-komisi-langganan")
    });

    $('#modal-create-komisi-langganan').on('change', '.id-barang-komisi', function () {
        $('input[name="id_satuan"]').val($(this).find('option:selected').data('id-satuan'));
        $('input[name="satuan"]').val($(this).find('option:selected').data('satuan'));
    })

    $('#modal-edit').on('change', '.id-barang-komisi', function () {
        $('input[name="id_satuan"]').val($(this).find('option:selected').data('id-satuan'));
        $('input[name="satuan"]').val($(this).find('option:selected').data('satuan'));
    })

    function hitungHargaBarang() {
        hargaBeli = 0;
        $('#listBarangPindah').children('tbody').find('tr').each(function (index) {
            var no = $(this).data('no');
            hargaBeli = (hargaBeli + (parseInt($('#harga-beli-barang-' + no).val()) * parseFloat($('#item-' + no + '-qty').val())));
            // console.log(hargaBeli);
        })
        $('input[name="harga_beli_terakhir_barang"]').val(format_number(hargaBeli));
    }

    $(".conv-jumlah").keyup(function () {
        var index = $(this).data("hide");
        var val = $(this).val()
        $("#" + index).val(strtonumber(val))
    })

    function strtonumber(str) {
        var arr = str.split(',');
        var res = '';
        $.each(arr, function (i, val) {
            res += val
        })
        return res
    }

});