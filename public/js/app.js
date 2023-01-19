WebFont.load({
    google: { "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"] },
    active: function () {
        sessionStorage.fonts = true;
    }
});

var decimalStep = $('#base-value').data('decimal-step');

var touchspin_number = {
    buttondown_class: "btn btn-success",
    buttonup_class: "btn btn-warning",
    verticalbuttons: !0,
    verticalupclass: "la la-plus",
    verticaldownclass: "la la-minus",
    min: 0,
    max: 10000000000000000000000,
};

var touchspin_number_decimal = {
    buttondown_class: "btn btn-success",
    buttonup_class: "btn btn-warning",
    verticalbuttons: !0,
    verticalupclass: "la la-plus",
    verticaldownclass: "la la-minus",
    step: decimalStep,
    decimals: 2,
    min: 0,
    max: 10000000000000000000000,
};

$(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function () {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});

$(document).ready(function () {

    var csrf_token = $('#base-value').data('csrf-token');
    var base_url = $('#base-value').data('base-url');
    var list_url = $('#list_url').data('list-url');
    // console.log('app.js : list url log ' + list_url)

    $('.m-select2').select2();

    user_role();
    user_role_menu_action();
    input_numeral();
    input_decimal();
    roles_login();

    province_select();
    city_select();

    btn_payment_add();
    payment_plus();
    payment_cut();

    // edit payment

    btn_payment_row_remove();
    payment_qty();
    payment_price();
    btn_payment_row_remove();

    datatable();
    datatable_2();

    cetak_pdf();

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

    form_send_wrapper();



    $('.datatable-new, .datatable-new-2').on('click', '.btn-hapus', function (e) {
        e.preventDefault();
        var self = $(this);
        var remove_by_index = $(this).data('remove-by-index');
        var remove_index = $(this).data('remove-index');
        var reload = $(this).data('reload');
        var message = $(this).data('message');
        if (typeof message === "undefined") {
            message = "Yakin hapus data ini ?";
        }
        swal({
            title: "Perhatian ...",
            html: message,
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Ya, yakin",
            cancelButtonText: "Batal",
        }).then(function (e) {
            if (e.value) {
                $.ajax({
                    url: self.data('route'),
                    type: "delete",
                    data: {
                        _token: csrf_token
                    },
                    success: function () {
                        window.location.reload();
                    },
                    error: function (request) {
                        var title = request.responseJSON.title ? request.responseJSON.title : 'Ada yang salah';
                        swal({
                            title: title,
                            html: request.responseJSON.message,
                            type: "warning"
                        });
                    }
                });
            }
        });
        return false;
    });

    $('.datatable-new, .datatable-new-2').on('click', '.btn-modal-general', function (e) {
        e.preventDefault();

        var self = $(this);
        var route = $(this).data('route');

        $.ajax({
            url: route,
            type: 'get',
            data: {},
            beforeSend: loading_start(),
            success: function (json) {
                loading_finish();

                $('.wrapper-modal').html(json);
                $('#modal-general').modal('show');
                $('.m-select2').select2();
                let ed = $('.edit-role').select2('data')
                if(ed !== undefined){
                    if(ed[0].text.toLowerCase() == 'wali kelas'){
                        $('.guru-select').show()
                    }else{
                        $('.guru-select').hide()
                    }
                    if(ed[0].text.toLowerCase() == 'siswa'){
                        $('.siswa-select').show()
                    }else{
                        $('.siswa-select').hide()
                    }
                }
                $('.m-touchspin').TouchSpin(touchspin_number);
                $('.m_date_1_modal').datetimepicker({
                    todayHighlight: true,
                    autoclose: true,
                    format: 'dd-mm-yyyy hh:ii'
                });
                $('.m_datepicker_1_modal').datepicker({
                    todayHighlight: true,
                    autoclose: true,
                    todayBtn: "linked",
                    // clearBtn: true,
                    format: 'dd-mm-yyyy',
                    orientation: "bottom left",
                    templates: {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>'
                    }
                });
                $('.m_timepicker_1_modal').timepicker();

                province_select();
                city_select();
                form_send_wrapper();
                input_numeral();

                hutang_lain_pembayaran();
                hutang_supplier_pembayaran();
                piutang_lain_pembayaran();
                piutang_pelanggan_pembayaran();
            }
        });


        return false;
    });

    $('.modal').on('hidden.bs.modal', function () {
        $(':input', this).val('');
        $('.form-group').removeClass('has-danger');
        $('.form-control-feedback').remove();
    });

    $(document).on('change', '.btn-file :file', function () {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
    });

    $('.btn-file :file').on('fileselect', function (event, label) {

        var input = $(this).parents('.input-group').find(':text'),
            log = label;

        if (input.length) {
            input.val(log);
        } else {
            if (log) alert(log);
        }

    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.img-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function form_send_wrapper() {

        $('.form-send').submit(function (e) {
            e.preventDefault();

            var self = $(this);
            var val = false;
            var label_button = $(this).find('[type="submit"]').text();
            $(this).find('[type="submit"]').text('Loading ...').prop('disabled', true);


            var confirm_status = $(this).data('confirm-status');
            var confirm_message = $(this).data('confirm-message');

            if (confirm_status) {
                swal({
                    title: "Perhatian ...",
                    html: confirm_message,
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Ya, yakin",
                    cancelButtonText: "Batal",
                }).then(function (e) {
                    if (e.value) {
                        form_send(self, label_button);
                    } else {
                        self.find('[type="submit"]').text(label_button).prop('disabled', false);
                    }
                });
            } else {
                form_send(self, label_button);
            }
            return false;
        });
    }

    function form_send(self, label_button = '') {
        loading_start();
        var action = self.attr('action');
        var method = self.attr('method');

        var redirect = self.data('redirect');
        var pdf = self.data('pdf');
        var alert_show = self.data('alert-show');
        var alert_field_message = self.data('alert-field-message');

        var alert_show_success_status = self.data('alert-show-success-status');
        var alert_show_success_title = self.data('alert-show-success-title');
        var alert_show_success_message = self.data('alert-show-success-message');

        var message = '';
        var message_field = '';

        var form = self;
        var formData = new FormData(form[0]);

        $.ajax({
            url: action,
            type: method,
            data: formData,
            // async: false,
            beforeSend: function () {
                loading_start();
            },
            error: function (request, error) {
                loading_finish();
                $('.form-control-feedback').remove();
                $('.form-group').removeClass('has-danger');
                $.each(request.responseJSON.errors, function (key, val) {
                    var type = $('[name="' + key + '"]').attr('type');
                    $('[name="' + key + '"]').parents('.form-group').addClass('has-danger');
                    message_field += val[0] + '<br />';
                    /**
                     * check apakah tipe inputan merupakan file atau tidak
                     */
                    if (type == 'file') {
                        $('[name="' + key + '"]').parents('.input-group').after('<div class="form-control-feedback">' + val[0] + '</div>');
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


                $('.form-send [type="submit"]').text(label_button).prop('disabled', false);
            },
            success: function (data) {
                loading_finish();
                $('.form-send [type="submit"]').text(label_button).prop('disabled', false);
                if (alert_show_success_status) {
                    swal({
                        title: alert_show_success_title,
                        html: alert_show_success_message,
                        type: 'success',
                        showDenyButton: true,
                        confirmButtonText: 'Baik',
                    }).then(function (result) {
                        window.location.reload();
                    });

                } else {
                    if (typeof redirect == 'undefined') {
                        window.location.reload();
                        form_clear();
                    } else {
                        if (pdf) {
                            window.open(pdf, "_blank");
                            window.location.href = redirect;
                        } else {
                            window.location.href = redirect;

                        }
                    }
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
        if ($('select').hasClass('m-select2')) {
            $('.m-select2').val(null).trigger('change');
        }
        $('select option:first-child').attr("selected", "selected");
    }

    function cetak_pdf() {
        $('.cetak-pdf').click(function (e) {

            e.preventDefault();

            var url = $(this).data('url');
            var data = $(this).data('data');
            var data_send = {
                data: data,
                _token: csrf_token
            };

            loading_start();

            $.ajax({
                url: url,
                type: 'post',
                data: data_send,
                success: function (response) {

                    $('.form-cetak-pdf [name="view"]').val(response.view);
                    $('.form-cetak-pdf').submit();

                    loading_finish();
                }

            });

            return false;
        });
    }
});

/**
 * Proses ini untuk meremove menu pada sidebar jika user role pada menu tersebut adalah FALSE
 * jika TRUE, maka tetap ditampilkan menunya
 */
function user_role() {
    var check_user_role = $('#user-role-value').length;

    if (check_user_role > 0) {
        var user_role = $('#user-role-value').val();
        var obj = JSON.parse(user_role);
        // console.log(obj)
        $.each(obj, function (key, val) {
            // console.log(key + ' akses menu ' + val.akses_menu)
            console.log(key, val);
            if (!val.akses_menu) {
                $('.akses-' + key).remove();
            }

            $.each(val, function (key_2, val_2) {
                // console.log(key_2, val_2);
                if (!val_2.akses_menu) {
                    $('.akses-' + key_2).remove();
                    //console.log('delete');
                }

                //console.log(val_2);

                if (typeof val_2 === 'object') {
                    $.each(val_2, function (key_3, val_3) {
                        //console.log(key_3, val_3);
                    });
                }

                /**/

            });
        });
    }
}

function roles_login() {

    var id_user_role = localStorage.getItem("id_user_role");
    var role_name = localStorage.getItem("role_name");
    $('[name="id_user_role"]').val(id_user_role);
    $('[name="id_user_role_list"]').val(id_user_role);
    $('.role-name').html(role_name);

    $('.roles-login-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: function (json) {
                $('#modal-roles-login').modal('hide');
                $('#modal-roles-list').modal('show');
            },
            error: function (request, error) {

                swal({
                    title: "Ada yang Salah",
                    html: "Saat memasukkan username atau password",
                    type: "warning"
                });

                $.each(request.responseJSON.errors, function (key, val) {
                    var type = $('[name="' + key + '"]').attr('type');
                    $('[name="' + key + '"]').parents('.form-group').addClass('has-danger');
                    message_field += val[0] + '<br />';
                    /**
                     * check apakah tipe inputan merupakan file atau tidak
                     */
                    if (type == 'file') {
                        $('[name="' + key + '"]').parents('.input-group').after('<div class="form-control-feedback">' + val[0] + '</div>');
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
            }
        });

        return false;
    });

    $('.btn-user-role-change').click(function () {
        var id_user_role = $('[name="id_user_role_list"]').val();
        var role_name = $('[name="id_user_role_list"] option:selected').html();


        $('[name="id_user_role"]').val(id_user_role);
        $('.role-name').html(role_name);
        localStorage.setItem('id_user_role', id_user_role);
        localStorage.setItem('role_name', role_name);

        $('#modal-roles-list').modal('hide')
    })

}


/**
 * Proses ini untuk meremove menu action yang ada di halaman active, jika menu action tersebut adalah FALSE
 */
function user_role_menu_action() {
    var check_user_role_menu_action = $('#user-role-menu-action').length;

    if (check_user_role_menu_action > 0) {
        var user_role_menu_action = $('#user-role-menu-action').val();
        var obj = JSON.parse(user_role_menu_action);
        $.each(obj, function (key, val) {
            if (key === 'action') {
                $.each(val, function (key_2, val_2) {
                    if (!val_2) {
                        $('.akses-' + key_2).remove();
                    }
                });
            } else {
                if (!val) {
                    $('.akses-' + key).remove();
                }
            }
        });
    }
}

function input_numeral() {
    $('.input-numeral').toArray().forEach(function (field) {
        new Cleave(field, {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand'
        })
    });
}

function input_decimal() {
    $('.input-decimal').toArray().forEach(function (field) {
        new Cleave(field, {
            numeral: true,
            numeralDecimalScale: 4
        })
    });
}

function strtonumber(str) {
    var arr = str.split(',');
    var res = '';
    $.each(arr, function (i, val) {
        res += val
    });
    return res
}

function loading_start() {
    $('.container-loading').hide().removeClass('hidden').fadeIn('fast');
}

function loading_finish() {
    $('.container-loading').fadeOut('fast').addClass('hidden');
}

function format_number(nStr) {
    nStr += '';
    x = nStr.split(',');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function province_select() {

    $('[name="id_province"]').change(function () {
        var route_city_list = $('#base-value').data('route-city-list');
        var id_province = $(this).val();
        var csrf_token = $('#base-value').data('csrf-token');

        var data_send = {
            id_province: id_province,
            _token: csrf_token
        };
        // $('#modal-edit [name="id_city"]').select2('data', {id: null, text: null});


        $.ajax({
            beforeSend: loading_start(),
            url: route_city_list,
            type: 'post',
            data: data_send,
            success: function (json) {
                loading_finish();

                $('[name="id_city"]').html('').select2({
                    data: json.data
                });

                $('[name="id_subdistrict"]').html('');

            }

        });
    });
}

function city_select() {

    $('[name="id_city"]').change(function () {
        var route_subdistrict_list = $('#base-value').data('route-subdistrict-list');
        var id_city = $(this).val();
        var csrf_token = $('#base-value').data('csrf-token');

        var data_send = {
            id_city: id_city,
            _token: csrf_token
        };

        $.ajax({
            beforeSend: loading_start(),
            url: route_subdistrict_list,
            type: 'post',
            data: data_send,
            success: function (json) {
                loading_finish();

                $('[name="id_subdistrict"]').html('').select2({
                    data: json.data
                });

            }

        });
    });
}

function btn_payment_add() {
    $('.btn-payment-add').click(function () {
        var tr = $('.table-payment-row tbody').html();

        $('.table-payment-list tbody').append(tr);

        input_numeral();
        btn_payment_row_remove();
        payment_qty();
        payment_price();
    });
}

function btn_payment_row_remove() {
    $('.btn-payment-row-remove').click(function () {
        $(this).parents('tr').remove();

        payment_total();
        grand_total();
    });
}

function payment_qty() {
    $('.payment-qty').keyup(function () {
        var qty = $(this).val();
        qty = strtonumber(qty);
        var price = $(this).parents('td').siblings('td.td-payment-price').children('input').val();
        price = strtonumber(price);

        var total = parseFloat(qty) * parseFloat(price);
        total = format_number(total);

        $(this).parents('td').siblings('td.payment-td-sub-total').html(total);

        payment_total();
        grand_total();
    });
}

function payment_price() {
    $('.payment-price').keyup(function () {
        var price = $(this).val();
        price = strtonumber(price);
        var qty = $(this).parents('td').siblings('td.td-payment-qty').children('input').val();
        qty = strtonumber(qty);

        // console.log(price, qty);

        var total = parseFloat(price) * parseFloat(qty);
        total = format_number(total);

        $(this).parents('td').siblings('td.payment-td-sub-total').html(total);

        payment_total();
        grand_total();
    });
}


function payment_total() {
    var payment_total = 0
    $('.table-payment-list .payment-td-sub-total').each(function () {
        var sub_total = $(this).html();
        sub_total = strtonumber(sub_total);

        payment_total = parseFloat(payment_total) + parseFloat(sub_total);
    });

    var payment_total_view = format_number(payment_total);
    $('.payment-total').html(payment_total_view);

    $('[name="total"]').val(payment_total);
}


function payment_plus() {
    $('.payment-plus').keyup(function () {
        grand_total();
    });
}

function payment_cut() {
    $('.payment-cut').keyup(function () {
        grand_total();
    });
}

function grand_total() {
    var payment_total = $('.payment-total').html();
    payment_total = strtonumber(payment_total);
    var payment_plus = $('.payment-plus').val();
    payment_plus = strtonumber(payment_plus);
    var payment_cut = $('.payment-cut').val();
    payment_cut = strtonumber(payment_cut);

    var payment_grand_total = parseFloat(payment_total) + parseFloat(payment_plus) - parseFloat(payment_cut);
    var payment_grand_total_view = format_number(payment_grand_total);

    $('.payment-grand-total').html(payment_grand_total_view);

    $('[name="grand_total"]').val(payment_grand_total);
}

function datatable() {
    $('.kls-tab').click(function (e) {
        // e.preventDefault()
        let kls = $(this).data('kls')
        var _token = $('#base-value').data('csrf-token');
        var url = $('.datatable-kls').data('url');
        var data = $('.datatable-kls').data('data');
        var column = $('.datatable-kls').data('column');
        data.kelas = kls;
        data.subkelas = kls;

        var data_send = {
            _token: _token,
            data: data,
        };

        $('.datatable-kls').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "destroy": true,
            "order": [[0, "desc"]],
            "columnDefs": [{
                "orderable": false,
                "targets": "no-sort"
            }],
            "ajax": {
                "url": url,
                "dataType": "json",
                "type": "POST",
                "data": data_send
            },
            "columns": column,
            "drawCallback": function () {
                user_role_menu_action();
            }
        });
    })
    $('.datatable-new').each(function () {
        var _token = $('#base-value').data('csrf-token');
        var url = $(this).data('url');
        var data = $(this).data('data');
        var column = $(this).data('column');

        var data_send = {
            _token: _token,
            data: data
        };

        $(this).DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "ordering": true,
            "order": [[0, "desc"]],
            "columnDefs": [{
                "orderable": false,
                "targets": "no-sort"
            }],
            "ajax": {
                "url": url,
                "dataType": "json",
                "type": "POST",
                "data": data_send
            },
            "columns": column,
            "drawCallback": function () {
                user_role_menu_action();
            }
        });
    });

}

function datatable_2() {

    if ($(".datatable-new-2")[0]) {
        $('.datatable-new-2').DataTable();
    }
}

function select2() {
    $(".m-select2").select2({
        placeholder: 'Pilih',
        allowClear: true
    });
}

function hutang_lain_pembayaran() {
    $('[name="hlp_jumlah_bayar"]').on('change keyup', function () {
        var jumlah_bayar = $(this).val();
        jumlah_bayar = strtonumber(jumlah_bayar);
        var hlp_total_hutang = $('[name="hlp_total_hutang"]').val();

        var sisa_pembayaran = 0;
        var kembalian = 0;

        if (parseFloat(hlp_total_hutang) < parseFloat(jumlah_bayar)) {
            kembalian = parseFloat(jumlah_bayar) - parseFloat(hlp_total_hutang);
        }

        if (parseFloat(hlp_total_hutang) > parseFloat(jumlah_bayar)) {
            sisa_pembayaran = parseFloat(hlp_total_hutang) - parseFloat(jumlah_bayar);
        }

        $('[name="hlp_sisa_pembayaran"]').val(sisa_pembayaran);
        $('.sisa-pembayaran').html(format_number(sisa_pembayaran));
        $('.kembalian').html(format_number(kembalian));

    });
}

function hutang_supplier_pembayaran() {
    $('[name="hsp_jumlah_bayar"]').on('change keyup', function () {
        var jumlah_bayar = $(this).val();
        jumlah_bayar = strtonumber(jumlah_bayar);
        var hsp_total_hutang = $('[name="hsp_total_hutang"]').val();

        var sisa_pembayaran = 0;
        var kembalian = 0;

        if (parseFloat(hsp_total_hutang) < parseFloat(jumlah_bayar)) {
            kembalian = parseFloat(jumlah_bayar) - parseFloat(hsp_total_hutang);
        }

        if (parseFloat(hsp_total_hutang) > parseFloat(jumlah_bayar)) {
            sisa_pembayaran = parseFloat(hsp_total_hutang) - parseFloat(jumlah_bayar);
        }

        $('[name="hsp_sisa_pembayaran"]').val(sisa_pembayaran);
        $('.sisa-pembayaran').html(format_number(sisa_pembayaran));
        $('.kembalian').html(format_number(kembalian));

    });
}

function piutang_lain_pembayaran() {
    $('[name="plp_jumlah_bayar"]').on('change keyup', function () {
        var jumlah_bayar = $(this).val();
        jumlah_bayar = strtonumber(jumlah_bayar);
        var plp_total_hutang = $('[name="plp_total_piutang"]').val();

        var sisa_pembayaran = 0;
        var kembalian = 0;

        if (parseFloat(plp_total_hutang) < parseFloat(jumlah_bayar)) {
            kembalian = parseFloat(jumlah_bayar) - parseFloat(plp_total_hutang);
        }

        if (parseFloat(plp_total_hutang) > parseFloat(jumlah_bayar)) {
            sisa_pembayaran = parseFloat(plp_total_hutang) - parseFloat(jumlah_bayar);
        }
        console.log(jumlah_bayar, plp_total_hutang, kembalian, sisa_pembayaran);

        $('[name="plp_sisa_pembayaran"]').val(sisa_pembayaran);
        $('.sisa-pembayaran').html(format_number(sisa_pembayaran));
        $('.kembalian').html(format_number(kembalian));

    });
}

function piutang_pelanggan_pembayaran() {
    $('[name="ppp_jumlah_bayar"]').on('change keyup', function () {
        var jumlah_bayar = $(this).val();
        jumlah_bayar = strtonumber(jumlah_bayar);
        var ppp_total_piutang = $('[name="ppp_total_piutang"]').val();

        var sisa_pembayaran = 0;
        var kembalian = 0;

        if (parseFloat(ppp_total_piutang) < parseFloat(jumlah_bayar)) {
            kembalian = parseFloat(jumlah_bayar) - parseFloat(ppp_total_piutang);
        }

        if (parseFloat(ppp_total_piutang) > parseFloat(jumlah_bayar)) {
            sisa_pembayaran = parseFloat(ppp_total_piutang) - parseFloat(jumlah_bayar);
        }

        $('[name="ppp_sisa_pembayaran"]').val(sisa_pembayaran);
        $('.sisa-pembayaran').html(format_number(sisa_pembayaran));
        $('.kembalian').html(format_number(kembalian));

    });
}

