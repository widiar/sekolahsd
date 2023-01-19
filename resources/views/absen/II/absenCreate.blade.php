<form action="{{ route('absenInsert') }}" method="post" class="m-form form-send" autocomplete="off">
    {{ csrf_field() }}
    <div class="modal" id="modal-create" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="m-portlet__body">
                        {{-- <div class="form-group m-form__group">
                            <label class="form-control-label required">No Absen</label>
                            <input type="text" class="form-control m-input" name="abs_nomber">
                        </div> --}}
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Siswa</label>
                            <select class="form-control m-select2" name="id_siswa"
                                data-placeholder="Pilih Guru" style="width: 100%">
                                @foreach($siswa as $row)
                                    <option value="{{ $row->id_siswa }}">{{ $row->swa_nis }}&nbsp&nbsp&nbsp{{ $row->swa_nama }}&nbsp&nbsp&nbsp{{ $row->kelas->kls_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input hidden type="text" class="form-control m-input" name="id_kelas" value="2">
                        {{-- <div class="form-group m-form__group">
                            <label class="form-control-label required">Kelas</label>
                            <select class="form-control m-select2" name="id_kelas"
                                data-placeholder="Pilih Guru" style="width: 100%">
                                @foreach($kelas as $row)
                                    <option value="{{ $row->id_kelas }}">{{ $row->kls_nama }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Tanggal</label>
                            <input type="text" class="form-control m-input m_datepicker_1_modal" name="abs_tanggal">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Keterangan</label>
                            <select class="form-control m-select2" name="abs_keterangan" style="width: 100%">
                                {{-- <option value="hadir">Hadir</option> --}}
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                                <option value="alpha">Alpha</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-simpan btn-success">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</form>
