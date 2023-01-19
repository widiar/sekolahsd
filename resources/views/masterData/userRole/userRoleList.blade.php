@extends('../general/index')

@section('css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection

@section('js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
@endsection

@section('body')
    @include('masterData/userRole/userRoleCreate')

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

            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__body">
                    <table class="datatable-new-2 table table-striped table-bordered table-hover table-checkable datatable-general">
                        <thead>
                        <tr>
                            <th width="20">No</th>
                            <th>Role Name</th>
                            <th>Keterangan</th>
                            <th width="150">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $r)
                            <tr>
                                <td align="center">{{ $no++ }}.</td>
                                <td>{{ $r->role_name }}</td>
                                <td>{{ $r->role_keterangan }}</td>
                                <td align="center">
                                    <div class="btn-group m-btn-group m-btn-group--pill btn-group-sm">
                                        <a class="akses-menu_akses m-btn btn btn-primary akses-menu_akses"
                                           href="{{ route('userRoleAkses', ['id'=>Main::encrypt($r->id)]) }}">
                                            <i class="la la-key"></i> Menu Akses
                                        </a>
                                        <button type="button"
                                                class="akses-edit m-btn btn btn-success btn-modal-general akses-edit"
                                                data-route="{{ route('userRoleEditModal', ['id'=>Main::encrypt($r->id)]) }}">
                                            <i class="la la-edit"></i> Edit
                                        </button>
                                        <button type="button"
                                                class="akses-delete m-btn btn btn-danger btn-hapus akses-delete"
                                                data-route='{{ route('userRoleDelete', ['id'=>Main::encrypt($r->id)]) }}'>
                                            <i class="la la-remove"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection