@extends('../general/index')

@section('css')
<link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
{{--
<link href="{{'assets/demo/default/base/style.bundle.css'}}" rel="stylesheet" type="text/css" /> --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('js')
<script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/custom/crud/forms/widgets/select2.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/custom/components/forms/widgets/select2.js') }}" type="text/javascript">
</script>
<script src="{{asset('assets/demo/default/custom/components/forms/widgets/bootstrap-timepicker.js')}}"
    type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        function initialTbl(){
            $('.time-picker').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                timePickerIncrement: 1,
                timePickerSeconds: false,
                locale: {
                    format: 'HH:mm'
                }
            }).on('show.daterangepicker', function (ev, picker) {
                picker.container.find(".calendar-table").hide();
            });
            $(".m-select2").select2({
                placeholder: 'Pilih'
            });
        }
        let mapel = @json($mata_pelajaran);
        let jadwal = @json($jadwal);
        let jadwalPilih = @json($jadwalPilih);
        // console.log(jadwal)
        function getTextMapel(jadwalNih, japil){
            let dt = `
            ${jadwalNih.map((j, key) => 
            `<tr>
                <td>
                    <div class="form-group m-form__group">
                        <input type="text" class="form-control m-input time-picker" value="${j.jam}" name="jam[]">
                        ${key > 0 ? `<button type="button" class="btn btn-sm btn-del btn-danger">hapus</button>` : ``}
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_senin[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option ${japil[key][0].id_mata_pelajaran == map.id_mata_pelajaran ? `selected`:``} value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_selasa[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option ${japil[key][1].id_mata_pelajaran == map.id_mata_pelajaran ? `selected`:``} value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_rabu[]" placeholder="Pilih Mapel"
                            style="width: 100%">
                            ${mapel.map(map => 
                                `<option ${japil[key][2].id_mata_pelajaran == map.id_mata_pelajaran ? `selected`:``} value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_kamis[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option ${japil[key][3].id_mata_pelajaran == map.id_mata_pelajaran ? `selected`:``} value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_jumat[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option ${japil[key][4].id_mata_pelajaran == map.id_mata_pelajaran ? `selected`:``} value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_sabtu[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option ${japil[key][5].id_mata_pelajaran == map.id_mata_pelajaran ? `selected`:``} value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
            </tr>`
            )}`
            return dt;
        }
        let text = `
            <tr>
                <td>
                    <div class="form-group m-form__group">
                        <input type="text" class="form-control m-input time-picker" name="jam[]">
                    </div>
                    <button type="button" class="btn btn-sm btn-del btn-danger">hapus</button>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_senin[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_selasa[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_rabu[]" placeholder="Pilih Mapel"
                            style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_kamis[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_jumat[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_sabtu[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
            </tr>`
        let first = `
            <tr>
                <td>
                    <div class="form-group m-form__group">
                        <input type="text" class="form-control m-input time-picker" name="jam[]">
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_senin[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_selasa[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_rabu[]" placeholder="Pilih Mapel"
                            style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_kamis[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_jumat[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
                <td>
                    <div class="form-group m-form__group">
                        <select class="form-control m-select2" name="mapel_sabtu[]"
                            placeholder="Pilih Mapel" style="width: 100%">
                            ${mapel.map(map => 
                                `<option value="${map.id_mata_pelajaran}">${map.mpj_nama}</option>`
                            )}
                        </select>
                    </div>
                </td>
            </tr>`
        if(jadwal.length > 0){
            let dt = getTextMapel(jadwal, jadwalPilih)
            $('.tbl-mapel').append(dt);
        }else{
            $('.tbl-mapel').append(first);
        }
        initialTbl()
        $('.btn-jam').click(function(){
            
            $('.tbl-mapel').append(text)
            initialTbl()
        })

        $('body').on('click', '.btn-del', function(){
            $(this).parents('tr').remove()
        })

        $('.jadwal-tab').click(function(){
            let id_kelas = $(this).data('kls')
            $('.val_kelas').val(id_kelas)
            $.ajax({
                url: `{{ route('ambilJadwal') }}`,
                type: 'POST',
                data:{
                    _token: `{{ csrf_token() }}`,
                    id_kelas: id_kelas,
                },
                success: function(res){
                    // console.log(res)
                    if(res.jadwal.length > 0){
                        let txt = getTextMapel(res.jadwal, res.jadwalPilih)
                        $('.tbl-mapel').html('');
                        $('.tbl-mapel').append(txt);
                    }else{
                        $('.tbl-mapel').html('');
                        $('.tbl-mapel').append(first);
                    }
                    initialTbl()
                }
            });
        })

    })
</script>
@endsection
{{-- @dd($data) --}}
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

        <div class="m-portlet m-portlet--mobile akses-list">
            <div class="m-portlet__body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @foreach ($kelaspilih as $kls)
                    <li class="nav-item">
                        <a class="nav-link jadwal-tab @if($loop->first) active @endif" id="kls-tab-{{$kls->sub_kelas}}"
                            data-toggle="tab" data-kls="{{$kls->id_kelas}}" href="#{{$kls->sub_kelas}}" role="tab"
                            aria-controls="home" aria-selected="true">Kelas {{
                            $kls->sub_kelas }}</a>
                    </li>
                    @endforeach
                </ul>
                <div class="tab-content" id="myTabContent">
                    @foreach ($kelaspilih as $kls)
                    <div class="tab-pane fade @if($loop->first) active @endif show" id="{{$kls->sub_kelas}}"
                        role="tabpanel" aria-labelledby="kls-tab-{{$kls->sub_kelas}}">

                        <form action="{{ route('jadwalUpdate') }}" method="POST" class="frm">
                            @csrf
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Jam</th>
                                        <th>Senin</th>
                                        <th>Selasa</th>
                                        <th>Rabu</th>
                                        <th>Kamis</th>
                                        <th>Jumat</th>
                                        <th>Sabtu</th>
                                    </tr>
                                </thead>
                                <tbody class="tbl-mapel">
                                </tbody>
                            </table>
                            <input type="hidden" name="kelas" class="val_kelas" value="{{ $kelaspilih[0]->id_kelas }}">
                            <button type="button" class="btn btn-sm btn-primary btn-jam">Tambah Jam</button>
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</div>
@endsection