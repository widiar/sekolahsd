@extends('../general/index')

@section('css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection

@section('js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/demo/default/custom/crud/forms/widgets/select2.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/demo/default/custom/components/forms/widgets/select2.js') }}"
            type="text/javascript"></script>
@endsection

@section('body')
    @include('laporansiswa.laporansiswaCreate')

    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title text-uppercase m-subheader__title--separator">
                        {{ $pageTitle }}
                    </h3>
                    {!! $breadcrumb !!}
                </div>
            </div>
        </div>

        <div class="m-content">

            <div class="m-portlet m-portlet--mobile akses-list">
                <div class="m-portlet__body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th width="20">No</th>
                            <th>Kelas</th>
                            <th>Jumlah Siswa</th>
                            <th>Naik Kelas</th>
                            <th>Tidak Naik Kelas</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($kelas as $key => $row)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $row->kls_nama }} - {{ $row->sub_kelas }}</td>
                                <td>{{ $row->jumlah_siswa }}</td>
                                <td>{{ $row->lulus }}</td>
                                <td>{{ $row->tidak_lulus }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
