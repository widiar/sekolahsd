<form action="{{ route('absenUpdate', ['id'=>Main::encrypt($edit->id_absen)]) }}" method="post"
      class="m-form form-send">
    {{ csrf_field() }}
    <div class="modal" id="modal-general" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="m-portlet__body">
                        {{-- <div class="form-group m-form__group">
                            <label class="form-control-label required">No Absen</label>
                            <input type="text" class="form-control m-input" name="abs_nomber"
                                   value="{{ $edit->abs_nomber }}">
                        </div> --}}
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nama Siswa</label>
                            <select class="form-control m-select2" name="id_siswa"
                                    data-placeholder="Pilih Siswa" style="width: 100%">
                                @foreach($siswa as $row)
                                    <option value="{{ $row->id_siswa}}" {{ $row->id_siswa == $edit->id_siswa ? 'selected' : ''  }}>
                                        {{ $row->swa_nis }}&nbsp&nbsp&nbsp{{ $row->swa_nama }}&nbsp&nbsp&nbsp{{ $row->kelas->kls_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input hidden type="text" class="form-control m-input" name="id_kelas" value="2">
                        {{-- <div class="form-group m-form__group">
                            <label class="form-control-label required">Kelas</label>
                            <select class="form-control m-select2" name="id_kelas"
                                    data-placeholder="Pilih Kelas" style="width: 100%">
                                @foreach($kelas as $row)
                                    <option value="{{ $row->id_kelas}}" {{ $row->id_kelas == $edit->id_kelas ? 'selected' : ''  }}>
                                        {{ $row->kls_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Tanggal</label>
                            <input type="text" class="form-control m-input m_datepicker_1_modal" name="abs_tanggal"
                                   value="{{ $edit->abs_tanggal}}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Keterangan</label>
                            <input type="text" class="form-control m-input" name="abs_keterangan"
                                   value="{{ $edit->abs_keterangan}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-update btn-success">Perbarui</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</form>
