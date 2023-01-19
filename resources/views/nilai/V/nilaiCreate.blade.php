<form action="{{ route('nilaiInsert') }}" method="post" class="m-form form-send" autocomplete="off">
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
                            <select class="form-control m-select2" name="id_absen"
                                    data-placeholder="Pilih Guru" style="width: 100%">
                                @foreach($siswa as $row)
                                    <option value="{{ $row->id_siswa }}">{{ $row->swa_nis }}&nbsp&nbsp&nbsp{{ $row->swa_nama }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Siswa</label>
                            <select class="form-control m-select2" name="id_siswa"
                                    data-placeholder="Pilih Siswa" style="width: 100%">
                                @foreach($siswa as $row)
                                    <option value="{{ $row->id_siswa }}">{{ $row->swa_nis }}&nbsp&nbsp&nbsp{{ $row->swa_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input hidden type="text" class="form-control m-input" name="id_kelas" value="5">
                        {{-- <div class="form-group m-form__group">
                            <label class="form-control-label required">Kelas</label>
                            <select class="form-control m-select2" name="id_kelas"
                                    data-placeholder="Pilih Siswa" style="width: 100%">
                                @foreach($kelas as $row)
                                    <option value="{{ $row->id_kelas }}">{{ $row->kls_nama }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Mata Pelajaran</label>
                            <select class="form-control m-select2" name="id_mata_pelajaran"
                                    data-placeholder="Pilih Mata Pelajaran" style="width: 100%">
                                @foreach($mata_pelajaran as $row)
                                    <option value="{{ $row->id_mata_pelajaran }}">{{ $row->mpj_kode }}&nbsp&nbsp&nbsp{{ $row->mpj_nama }}&nbsp&nbsp&nbsp{{ $row->mpj_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nilai</label>
                            <input type="text" class="form-control m-input" name="nilai">
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
