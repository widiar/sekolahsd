<form action="{{ route('jadwalUpdate', ['id'=>Main::encrypt($edit->id_jadwal)]) }}" method="post"
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
                            <label class="form-control-label required">Jam Dari</label>
                            <input type="text" class="form-control m-input m_timepicker_1_modal" name="jam_dari"
                                    value="{{ $edit->jam_dari }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Jam ke</label>
                            <input type="text" class="form-control m-input m_timepicker_1_modal" name="jam_ke"
                                   value="{{ $edit->jam_ke }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Mata Pelajaran</label>
                            <select class="form-control m-select2" name="id_mata_pelajaran"
                                    data-placeholder="Pilih Mata Pelajaran" style="width: 100%">
                                @foreach($mata_pelajaran as $row)
                                    <option value="{{ $row->id_mata_pelajaran}}" {{ $row->id_mata_pelajaran == $edit->id_mata_pelajaran ? 'selected' : ''  }}>
                                        {{ $row->mpj_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Hari</label>
                            <select class="form-control m-select2" name="hari" style="width: 100%">
                                <option value="senin">Senin</option>
                                <option value="selasa">Selasa</option>
                                <option value="rabu">Rabu</option>
                                <option value="kamis">Kamis</option>
                                <option value="jumat">Jumat</option>
                                <option value="sabtu">Sabtu</option>
                            </select>
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