@extends('../general/index')
@section('css')
<link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js')
<script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/custom/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/custom/components/forms/widgets/select2.js') }}" type="text/javascript">
</script>
@endsection

@section('body')
@include('matapelajaran.matapelajaranCreate')

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title text-uppercase m-subheader__title--separator">
                    {{ $pageTitle }}
                </h3>
                {!! $breadcrumb !!}
            </div>
            <div>
                <a href="#"
                    class="akses-create btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air akses-create"
                    data-toggle="modal" data-target="#modal-create">
                    <span>
                        <i class="la la-plus"></i>
                        <span>Tambah Data</span>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="m-content">

        {!! $date_filter !!}

        <div class="m-portlet m-portlet--mobile akses-list">
            <div class="m-portlet__body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach ($kelas as $kls)
                    <li class="nav-item">
                        <a class="nav-link kls-tab @if($loop->first) active @endif" id="kls-tab-{{$kls->kls_nama}}"
                            data-toggle="tab" data-kls="{{$kls->kls_nama}}" href="#{{$kls->kls_nama}}" role="tab"
                            aria-controls="home" aria-selected="true">Kelas {{
                            $kls->kls_nama }}</a>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content" id="myTabContent">
                    @foreach ($kelas as $kls)
                    <div class="tab-pane fade @if($loop->first) active @endif show" id="{{$kls->kls_nama}}"
                        role="tabpanel" aria-labelledby="kls-tab-{{$kls->kls_nama}}">

                    </div>
                    @endforeach
                    <table class="table table-bordered datatable-new datatable-kls"
                        data-url="{{ route('matapelajaranDataTable') }}"
                        data-column="{{ json_encode($datatable_column) }}"
                        data-data="{{ json_encode($table_data_post) }}">
                        <thead>
                            <tr>
                                <th width="20">No</th>
                                <th>Kode Mata Pelajaran</th>
                                <th>Nama Mata pelajaran</th>
                                <th>Kelas</th>
                                <th>Batas Nilai lulus</th>
                                <th>Guru Pengajar</th>
                                <th width="50">Menu</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection