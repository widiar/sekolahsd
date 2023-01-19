<form action="{{ route('laporananakUpdate', ['id'=>Main::encrypt($edit->id_laporan_anak)]) }}" method="post"
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
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nama Siswa</label>
                            <select class="form-control m-select2" name="id_siswa"
                                    data-placeholder="Pilih Kelas" style="width: 100%">
                                @foreach($siswa as $row)
                                <option value="{{ $row->id_siswa}}" {{ $row->id_siswa == $edit->id_siswa ? 'selected' : ''  }}>
                                    {{ $row->swa_nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Mata Pelajaran</label>
                            <select class="form-control m-select2" name="id_mata_pelajaran"
                                    data-placeholder="Pilih Kelas" style="width: 100%">
                                @foreach($mata_pelajaran as $row)
                                    <option value="{{ $row->id_mata_pelajaran}}" {{ $row->id_mata_pelajaran == $edit->id_mata_pelajaran ? 'selected' : ''  }}>
                                        {{ $row->mpj_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nilai</label>
                            <input type="text" class="form-control m-input" name="lpa_nilai"
                                   value="{{ $edit->lpa_nilai }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Keterangan Guru</label>
                            <input type="text" class="form-control m-input" name="lpa_keterangan_guru"
                                   value="{{ $edit->lpa_keterangan_guru }}">
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