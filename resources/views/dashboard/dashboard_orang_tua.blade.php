@extends('../general/index')

@section('js')
    <script src="{{ asset('assets/app/js/dashboard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/demo/default/custom/components/forms/widgets/bootstrap-datepicker.js') }}"
            type="text/javascript"></script>

    <script src="{{ asset('plugin/chart/chart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('plugin/chart/utils.js') }}" type="text/javascript"></script>

    <script>
        var MONTHS = [
            @foreach($cart_patient['label'] as $row)
            {!! "'".date('d M', strtotime($row))."', " !!}
            @endforeach
        ];
        var config_patient = {
            type: 'line',
            data: {
                labels: [
                    @foreach($cart_patient['label'] as $row)
                    {!! "'".date('d M', strtotime($row))."', " !!}
                    @endforeach
                ],
                datasets: [{
                    label: 'Appointment',
                    backgroundColor: window.chartColors.red,
                    borderColor: window.chartColors.red,
                    data: [
                        @foreach($cart_patient['label'] as $row)
                        {{ $cart_patient['data']['appointment'][$row].", " }}
                        @endforeach
                    ],
                    fill: false,
                }, {
                    label: 'Konsultasi',
                    fill: false,
                    backgroundColor: window.chartColors.blue,
                    borderColor: window.chartColors.blue,
                    data: [
                        @foreach($cart_patient['label'] as $row)
                        {{ $cart_patient['data']['consult'][$row].", " }}
                        @endforeach
                    ],
                }, {
                    label: 'Tindakan',
                    fill: false,
                    backgroundColor: window.chartColors.green,
                    borderColor: window.chartColors.green,
                    data: [
                        @foreach($cart_patient['label'] as $row)
                        {{ $cart_patient['data']['action'][$row].", " }}
                        @endforeach
                    ],
                }, {
                    label: 'Kontrol',
                    fill: false,
                    backgroundColor: window.chartColors.orange,
                    borderColor: window.chartColors.orange,
                    data: [
                        @foreach($cart_patient['label'] as $row)
                        {{ $cart_patient['data']['control'][$row].", " }}
                        @endforeach
                    ],
                }, {
                    label: 'Pasien',
                    fill: false,
                    backgroundColor: window.chartColors.purple,
                    borderColor: window.chartColors.purple,
                    data: [
                        @foreach($cart_patient['label'] as $row)
                        {{ $cart_patient['data']['patient'][$row].", " }}
                        @endforeach
                    ],
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Chart.js Line Chart'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };

        var config_payment = {
            type: 'line',
            data: {
                labels: [
                    @foreach($cart_patient['label'] as $row)
                    {!! "'".date('d M', strtotime($row))."', " !!}
                    @endforeach
                ],
                datasets: [{
                    label: 'Pembayaran',
                    backgroundColor: window.chartColors.green,
                    borderColor: window.chartColors.green,
                    data: [
                        @foreach($cart_patient['label'] as $row)
                        {{ $cart_patient['data']['payment'][$row].", " }}
                        @endforeach
                    ],
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                title: {
                    display: false,
                    text: 'Chart.js Line Chart'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var val = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return 'Pembayaran : Rp. ' + numberWithCommas(val);
                        }
                    }
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Bulan Oktober'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };


        window.onload = function () {
            var ctx_patient = document.getElementById('chart-patient').getContext('2d');
            window.myLine = new Chart(ctx_patient, config_patient);

            var ctx_payment = document.getElementById('chart-payment').getContext('2d');
            window.myLine = new Chart(ctx_payment, config_payment);
        };

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    </script>

@endsection

@section('css')
    <link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css"/>
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
@endsection

@section('body')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">

            {!! $date_filter !!}

            <div class="row">
              {{--  <a href="{{ route('absenList') }}" class="col-xl-3">
                    <div class="m-portlet m-portlet--head-overlay m-portlet--full-height m-portlet--rounded-force"
                         style=" margin: 0px">
                        <div class="m-portlet__head m-portlet__head--fit-">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text m--font-light" style=" margin: 0px">
                                        Total Hadir
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget27 m-portlet-fit--sides">
                                <div class="m-widget27__pic">
                                    <img src="{{ asset('images/background-card.jpg') }}" alt="">
                                    <h3 class="m-widget27__title m--font-light" >
                                        <span>{{ $total_hadir }}</span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </a> --}}
                <a href="#" class="col-xl-3">
                    <div class="m-portlet m-portlet--head-overlay m-portlet--full-height m-portlet--rounded-force"
                         style=" margin: 0px">
                        <div class="m-portlet__head m-portlet__head--fit-">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text m--font-light" style=" margin: 0px">
                                        Total Izin
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget27 m-portlet-fit--sides">
                                <div class="m-widget27__pic">
                                    <img src="{{ asset('images/background-card.jpg') }}" alt="">
                                    <h3 class="m-widget27__title m--font-light">
                                        <span>{{ $total_izin }}</span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="col-xl-3">
                    <div class="m-portlet m-portlet--head-overlay m-portlet--full-height m-portlet--rounded-force"
                         style=" margin: 0px">
                        <div class="m-portlet__head m-portlet__head--fit-">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text m--font-light" style=" margin: 0px">
                                        Total Sakit
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget27 m-portlet-fit--sides">
                                <div class="m-widget27__pic">
                                    <img src="{{ asset('images/background-card.jpg') }}" alt="">
                                    <h3 class="m-widget27__title m--font-light">
                                        <span>{{ $total_sakit }}</span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a href="#" class="col-xl-3">
                    <div class="m-portlet m-portlet--head-overlay m-portlet--full-height m-portlet--rounded-force"
                         style=" margin: 0px">
                        <div class="m-portlet__head m-portlet__head--fit-">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text m--font-light" style=" margin: 0px">
                                        Total Alpha
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget27 m-portlet-fit--sides">
                                <div class="m-widget27__pic">
                                    <img src="{{ asset('images/background-card.jpg') }}" alt="">
                                    <h3 class="m-widget27__title m--font-light">
                                        <span>{{ $total_alpha }}</span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>


            </div>

            {{--            <ul class="nav nav-tabs" role="tablist" style="margin: 0">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#" data-target="#m_tabs_1_2">
                                    <h4><i class="la la-line-chart"></i> Grafik Pembayaran Tahun 2020 </h4>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#" data-target="#m_tabs_1_1">
                                    <h4><i class="la la-line-chart"></i> Grafik Proses Pasien Tahun 2020</h4>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="m_tabs_1_2" role="tabpanel">
                                <div class="m-portlet  m-portlet--tab">
                                    <div class="m-portlet__body">
                                        <canvas id="chart-payment" style="height: 200px !important;"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="m_tabs_1_1" role="tabpanel">
                                <div class="m-portlet  m-portlet--tab">
                                    <div class="m-portlet__body">
                                        <canvas id="chart-patient" style="height: 200px !important;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>--}}


        </div>
    </div>
@endsection
