var DatatablesBasicPaginations = {
        init: function () {
            $("#m_table_1").DataTable({
                    responsive: !0, pagingType: "full_numbers"
                }
            ),
                $(".datatable-no-order").DataTable({
                    responsive: !0,
                    pagingType: "full_numbers",
                    ordering: false,
                    aLengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
                    iDisplayLength: 25

                }),
                $(".datatable-no-pagination").DataTable({
                    responsive: !0,
                    pagingType: "full_numbers",
                    ordering: false,
                    aLengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
                    iDisplayLength: -1

                }),
                $(".datatable-jurnal-umum").DataTable({
                    responsive: !0,
                    pagingType: "full_numbers",
                    ordering: false,
                    aLengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
                    iDisplayLength: -1,


                }),
                $(".datatable-anggaran").DataTable({
                    responsive: true,
                    ordering: false,
                    iDisplayLength: -1,
                    "bPaginate": false,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bInfo": false,
                }),
                $(".datatable-buku-besar").DataTable({
                    responsive: !0,
                    pagingType: "full_numbers",
                    ordering: false,
                    aLengthMenu: [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
                    iDisplayLength: -1,
                    "scrollY":        "400px",
                    "scrollCollapse": true

                }),
                $(".datatable-neraca").DataTable({
                    ordering: false,
                    responsive: !0,
                    pagingType: "full_numbers",
                    aLengthMenu: [[-1, 10, 25, 50, 75], ["All", 10, 25, 50, 75 ]],
                    "bInfo" : false,
                    "scrollY":        "400px",
                    "scrollCollapse": true,

                }),
                $("#m_table_2").DataTable({
                        responsive: !0, pagingType: "full_numbers"
                    }
                ),
                $("#m_table_3").DataTable({
                        responsive: !0, pagingType: "full_numbers"
                    }
                ),
                $("#m_table_4").DataTable({
                        responsive: !0, pagingType: "full_numbers"
                    }
                ),
                $("#m_table_5").DataTable({
                        responsive: !0, pagingType: "full_numbers"
                    }
                )
        }
    }

;
jQuery(document).ready(function () {
        DatatablesBasicPaginations.init()
    }
);

jQuery.fn.dataTable.Api.register('page.jumpToData()', function (data, column) {
    var pos = this.column(column, {order: 'current'}).data().indexOf(data);

    if (pos >= 0) {
        var page = Math.floor(pos / this.page.info().length);
        this.page(page).draw(false);
    }

    return this;
});


var table_index = $('#base-value').data('table-index');
var table_value = $('#base-value').data('table-value');
var table = $(".datatable-general").DataTable({
        responsive: !0,
        pagingType: "full_numbers"
    }
);
table.page.jumpToData(table_value, table_index);