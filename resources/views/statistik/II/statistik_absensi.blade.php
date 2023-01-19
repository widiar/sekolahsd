@extends('../general/index')

@section('js')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
    <script src="//www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/radar.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/pie.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.js"
            type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/export/export.min.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>

    <script src="{{ asset('assets/demo/default/custom/components/charts/amcharts/charts.js') }}"
            type="text/javascript"></script>

    <script type="text/javascript">

        //== Class definition
        var amChartsChartsDemo = function () {

            //== Private functions
            var demo1 = function () {
                var chart = AmCharts.makeChart("grafik", {
                    "type": "serial",
                    "theme": "light",
                    "dataProvider": [
                         {
                        "country": "Izin",
                        "visits": {{ $izin }}
                    }, {
                        "country": "Alpha",
                        "visits": {{ $alpha }}
                    }, {
                        "country": "Sakit",
                        "visits": {{ $sakit }}
                    }],
                    "valueAxes": [{
                        "gridColor": "#FFFFFF",
                        "gridAlpha": 0.2,
                        "dashLength": 0
                    }],
                    "gridAboveGraphs": true,
                    "startDuration": 1,
                    "graphs": [{
                        "balloonText": "[[category]]: <b>[[value]]</b>",
                        "fillAlphas": 0.8,
                        "lineAlpha": 0.2,
                        "type": "column",
                        "valueField": "visits"
                    }],
                    "chartCursor": {
                        "categoryBalloonEnabled": false,
                        "cursorAlpha": 0,
                        "zoomable": false
                    },
                    "categoryField": "country",
                    "categoryAxis": {
                        "gridPosition": "start",
                        "gridAlpha": 0,
                        "tickPosition": "start",
                        "tickLength": 20
                    },
                    "export": {
                        "enabled": true
                    }

                });
            }


            return {
                // public functions
                init: function () {
                    demo1();
                }
            };
        }();

        jQuery(document).ready(function () {
            amChartsChartsDemo.init();
        });
    </script>

@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
@endsection

@section('body')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">

            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                            <h3 class="m-portlet__head-text">
                                Statistik Absensi Anak
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div id="grafik" style="height: 500px;"></div>
                </div>
                <div class="m-portlet m-portlet--mobile akses-list">
                    <div class="m-portlet__body">
                        <table id="example" class="display" style="width:100%"
                               {{-- data-url="{{ route('nilaiDataTable') }}"
                               data-column="{{ json_encode($datatable_column) }}"
                               data-data="{{ json_encode($table_data_post) }}" --}}
                               >
                            <thead>
                            <tr>
                                <th width="20">No</th>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                {{-- <th>Kelas</th> --}}
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($DAbsen as $absen )
                                    <tr>
                                        <td>
                                            {{$loop->iteration}}
                                        </td>
                                        <td>
                                            {{$absen->siswa->swa_nis}}
                                        </td>
                                        <td>
                                            {{$absen->siswa->swa_nama}}
                                        </td>
                                        {{-- <td>
                                            {{$absen->siswa->kelas->kls_nama}}
                                        </td> --}}
                                        <td>
                                            {{$absen->abs_keterangan}}
                                        </td>
                                        <td>
                                            {{$absen->abs_tanggal}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
