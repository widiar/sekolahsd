@extends('../general/index')

@section('css')
<link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js')
<script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/custom/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function(){
        $('.role-select',).change(function(){
            let val = $(this).val()
            let cek = $(this).select2('data')
            // console.log(cek[0].text)
            if(cek[0].text.toLowerCase() == 'wali kelas'){
                $('.guru-select').show()
            }else{
                $('.guru-select').hide()
            }
            if(cek[0].text.toLowerCase() == 'siswa'){
                $('.siswa-select').show()
            }else{
                $('.siswa-select').hide()
            }
        })
        $('body').on('change', '.edit-role', function(){
            let val = $(this).val()
            let cek = $(this).select2('data')
            // console.log(cek[0].text)
            if(cek[0].text.toLowerCase() == 'wali kelas'){
                $('.guru-select').show()
            }else{
                $('.guru-select').hide()
            }
            if(cek[0].text.toLowerCase() == 'siswa'){
                $('.siswa-select').show()
            }else{
                $('.siswa-select').hide()
            }
        })
    })

</script>
@endsection

@section('body')
@include('masterData/user/userCreate')

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

        <div class="m-portlet m-portlet--mobile akses-list">
            <div class="m-portlet__body">
                <table
                    class="akses-list datatable-new-2 datatable table table-striped table-bordered table-hover table-checkable datatable-general">
                    <thead>
                        <tr>
                            <th width="20">No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>User Role</th>
                            <th width="100">Menu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $row)
                        <tr>
                            <td align="center">{{ $key + 1 }}.</td>
                            <td>{{ $row->username }}</td>
                            <td>{{ $row->nama }}</td>
                            <td>{{ $row->user_role->role_name }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-accent dropdown-toggle m-btn--pill" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Menu
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <a class="akses-edit dropdown-item btn-modal-general"
                                            data-route="{{ route('userEditModal', ['id'=> Main::encrypt($row->id)]) }}"
                                            href="#">
                                            <i class="la la-pencil"></i>
                                            Edit
                                        </a>
                                        <a class="akses-delete dropdown-item btn-hapus" href="#"
                                            data-route="{{ route('userDelete', ['id' => Main::encrypt($row->id)]) }}">
                                            <i class="la la-remove"></i>
                                            Hapus
                                        </a>
                                    </div>
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