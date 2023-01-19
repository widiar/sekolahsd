<form action="{{ route('guruUpdate', ['id'=>Main::encrypt($edit->id_guru)]) }}" method="post"
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
                            <label class="form-control-label required">NIP</label>
                            <input type="text" class="form-control m-input" name="gru_nip"
                                   value="{{ $edit->gru_nip }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nama Guru</label>
                            <input type="text" class="form-control m-input" name="gru_nama"
                                   value="{{ $edit->gru_nama }}">
                        </div>
                        {{-- <div class="form-group m-form__group">
                            <label class="form-control-label required">Mengajar</label>
                            <select class="form-control m-select2" name="id_mata_pelajaran"
                                    data-placeholder="Pilih Guru" style="width: 100%">
                                @foreach($mata_pelajaran as $row)
                                    <option value="{{ $row->id_mata_pelajaran}}" {{ $row->id_mata_pelajaran == $edit->id_mata_pelajaran ? 'selected' : ''  }}>
                                        {{ $row->mpj_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Alamat</label>
                            <input type="text" class="form-control m-input" name="gru_alamat"
                                   value="{{ $edit->gru_alamat}}">
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
