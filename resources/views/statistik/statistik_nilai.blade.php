@extends('../general/index')

@section('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

<script src="//www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/radar.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/pie.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/plugins/export/export.min.js" type="text/javascript"></script>
<script src="//www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>

<script src="{{ asset('assets/demo/default/custom/components/charts/amcharts/charts.js') }}" type="text/javascript">
</script>

<script type="text/javascript">
    //== Class definition
        var amChartsChartsDemo = function () {

            //== Private functions
            var demo1 = function (nilai) {
                var chart = AmCharts.makeChart("grafik", {
                    "type": "serial",
                    "theme": "light",
                    "dataProvider": nilai,
                    "valueAxes": [{
                        "gridColor": "#FFFFFF",
                        "gridAlpha": 0.2,
                        "dashLength": 0
                    }],
                    "gridAboveGraphs": true,
                    "startDuration": 1,
                    "graphs": [{
                        "balloonText": "nilai [[category]]: <b>[[value]] orang</b>",
                        "fillAlphas": 0.8,
                        "lineAlpha": 0.2,
                        "type": "column",
                        "valueField": "value"
                    }],
                    "chartCursor": {
                        "categoryBalloonEnabled": false,
                        "cursorAlpha": 0,
                        "zoomable": false
                    },
                    "categoryField": "title",
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
                init: function (izin, alpha, sakit) {
                    demo1(izin, alpha, sakit);
                }
            };
        }();

        jQuery(document).ready(function () {
            let nilai = @json($nilai);
            // console.log(nilai)
            amChartsChartsDemo.init(nilai);
            $('.statistik-tab').click(function(e){
                let id_mapel = $(this).data('kls')
                $.ajax({
                    url: `{{ route('ambilStatistikNilai') }}`,
                    type: 'POST',
                    data:{
                        _token: `{{ csrf_token() }}`,
                        id_mapel: id_mapel,
                    },
                    success: function(res){
                        // console.log(res)
                        amChartsChartsDemo.init(res.nilai);
                        initTable(id_mapel)
                    }
                });
            })
            let mapel = `{{ $mapel[0]->id_mata_pelajaran }}`
            initTable(mapel)
            function initTable(mapel){
                let table = $(".dt-absen").DataTable({
                    responsive: true,
                    lengthChange: true,
                    processing: true,
                    serverSide: true,
                    searching: false,
                    destroy: true,
                    ajax: {
                        url: "{{ route('statistiknilaiPage', Request::route('kls')) }}",
                        data: function (d) {
                            // Param Advance Filter Modalbox
                            d.mapel = mapel
                        }
                    },
                    columns: [
                        {data: 'siswa.swa_nis', name: 'nis', width: '50%'},
                        {data: 'siswa.swa_nama', name: 'nama'},
                        {data: 'kelas.sub_kelas', name: 'kelas'},
                        {data: 'nilai', name: 'nilai'},
                    ],
                    order: [[0, 'asc']]
                });
            }
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
                            Statistik Nilai Siswa
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach ($mapel as $kls)
                    <li class="nav-item">
                        <a class="nav-link statistik-tab @if($loop->first) active @endif"
                            id="kls-tab-{{$kls->id_mata_pelajaran}}" data-toggle="tab"
                            data-kls="{{$kls->id_mata_pelajaran}}" href="#{{$kls->id_mata_pelajaran}}" role="tab"
                            aria-controls="home" aria-selected="true">{{
                            $kls->mpj_nama }}</a>
                    </li>
                    @endforeach
                </ul>
                <div id="grafik" style="height: 500px;"></div>
                <div class="tab-content" id="myTabContent">
                    @foreach ($mapel as $kls)
                    <div class="tab-pane fade @if($loop->first) active @endif show" id="{{$kls->id_mata_pelajaran}}"
                        role="tabpanel" aria-labelledby="kls-tab-{{$kls->id_mata_pelajaran}}">

                        <div class="m-portlet m-portlet--mobile akses-list">
                            <div class="m-portlet__body">
                                <table class="display dt-absen table table-bordered" style="width:100%" {{--
                                    data-url="{{ route('nilaiDataTable') }}"
                                    data-column="{{ json_encode($datatable_column) }}"
                                    data-data="{{ json_encode($table_data_post) }}" --}}>
                                    <thead>
                                        <tr>
                                            <th>NIS</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection