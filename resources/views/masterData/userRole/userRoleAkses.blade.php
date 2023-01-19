@extends('../general/index')

@section('css')
    <link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection

@section('js')
    <script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/demo/default/custom/crud/datatables/basic/paginations.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('js/role_user.js') }}" type="text/javascript"></script>
@endsection

@section('body')

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

            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__body">


                    <form action="{{ route('userRoleAksesUpdate', ['id'=>Main::encrypt($role->id)]) }}"
                          class="form-send"
                          method="post"
                          data-redirect{{ route('userRoleAkses', ['id'=>Main::encrypt($role->id)]) }}
                          style="width: 100% !important">

                        {{ csrf_field() }}

                        <table class="table table-striped table-bordered table-hover datatable-no-pagination">
                            <thead>
                            <tr>
                                <th width="20">No</th>
                                <th>Nama Menu</th>
                                <th>Hak Akses</th>
                                <th>Akses Tombol Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($menuList as $label => $item)
                                @php
                                    $parent_super = !empty($role_akses[$label]['akses_menu']) ? 'checked' : '';
                                @endphp
                                <tr>
                                    <td align="center">{{ $no++ }}.</td>
                                    <td><strong>{{ Main::menuAction($label) }}</strong></td>
                                    <td>
                                        <label class="m-checkbox m-checkbox--success">
                                            <input type="checkbox"
                                                   class="check-akses parent-super"
                                                   data-no="{{ $no_2 }}"
                                                   name="role[{{ $label }}][akses_menu]"
                                                   value="true"
                                                    {{ $parent_super }}>
                                            Akses Menu
                                            <span></span>
                                        </label>
                                    </td>
                                    <td>
                                        @if(array_key_exists('action', $item))
                                            @foreach($item['action'] as $action)

                                                @php
                                                    $child_super = !empty($role_akses[$label]['action'][$action]) ? 'checked' : '';
                                                @endphp

                                                <label class="m-checkbox m-checkbox--success">
                                                    <input type="checkbox"
                                                           class="check-akses child-super"
                                                           name="role[{{ $label }}][{{ $action }}]"
                                                           value="true"
                                                           data-no="{{ $no_2 }}"
                                                            {{ $child_super }}>
                                                    {{ Main::menuAction($action) }}
                                                    <span></span>
                                                </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                @if(isset($item['sub']))
                                    @foreach($item['sub'] as $label_2 => $item_2)

                                        @php
                                            $parent = !empty($role_akses[$label][$label_2]['akses_menu']) ? 'checked' : '';
                                        @endphp

                                        <tr>
                                            <td></td>
                                            <td>
                                                <i class="la la-arrow-circle-o-right"></i> {{ Main::menuAction($label_2) }}
                                            </td>
                                            <td>
                                                <label class="m-checkbox m-checkbox--success">
                                                    <input type="checkbox"
                                                           class="check-akses parent"
                                                           name="role[{{ $label }}][{{ $label_2 }}][akses_menu]"
                                                           value="true"
                                                           data-no="{{ $no_3 }}"
                                                           data-no-parent="{{ $no_2 }}"
                                                            {{ $parent }}>
                                                    Akses Menu
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                                @if(isset($item_2['action']))
                                                    @foreach($item_2['action'] as $action)

                                                        @php
                                                            $child = !empty($role_akses[$label][$label_2][$action]) ? 'checked':'';
                                                        @endphp

                                                        <label class="m-checkbox m-checkbox--success">
                                                            <input type="checkbox"
                                                                   class="check-akses child"
                                                                   name="role[{{ $label }}][{{ $label_2 }}][{{ $action }}]"
                                                                   value="true"
                                                                   data-no="{{ $no_3 }}"
                                                                   data-no-parent="{{ $no_2 }}"
                                                                    {{ $child }}>
                                                            {{ Main::menuAction($action) }}
                                                            <span></span>
                                                        </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        @php($no_3++)
                                    @endforeach
                                @endif

                                @php($no_2++)

                            @endforeach
                            </tbody>
                        </table>

                        <div class="produksi-buttons">
                            <button type="submit"
                                    class="btn btn-primary btn-lg m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                            <span>Perbarui Role User</span>
                        </span>
                            </button>

                            <a href="{{ route("userRolePage") }}"
                               class="btn-produk-add btn btn-warning btn-lg m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                            <i class="la la-angle-double-left"></i>
                            <span>Kembali ke Daftar</span>
                        </span>
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection