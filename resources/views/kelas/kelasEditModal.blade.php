<form action="{{ route('kelasUpdate', ['id'=>Main::encrypt($edit->id_kelas)]) }}" method="post"
    class="m-form form-send">
    {{ csrf_field() }}
    <div class="modal" id="modal-general" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <label class="form-control-label required">Kelas</label>
                            <input type="text" class="form-control m-input" name="kls_nama"
                                value="{{ $edit->kls_nama }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Sub Kelas</label>
                            <input type="text" class="form-control m-input" name="sub_kelas"
                                value="{{ $edit->sub_kelas }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Jumlah Siswa</label>
                            <input type="text" class="form-control m-input" name="kls_jumlah_siswa"
                                value="{{ $edit->kls_jumlah_siswa }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Guru Wali</label>
                            <select class="form-control m-select2" name="id_guru" data-placeholder="Pilih Guru"
                                style="width: 100%">
                                @foreach($guru as $row)
                                <option value="{{ $row->id_guru}}" {{ $row->id_guru == $edit->id_guru ? 'selected' : ''
                                    }}>
                                    {{ $row->gru_nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Ketua Kelas</label>
                            <input type="text" class="form-control m-input" name="swa_id_ketua"
                                value="{{ $edit->swa_id_ketua }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Wakil Ketua Kelas</label>
                            <input type="text" class="form-control m-input" name="swa_id_wakil"
                                value="{{ $edit->swa_id_wakil }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Sekretaris</label>
                            <input type="text" class="form-control m-input" name="swa_id_sekretaris"
                                value="{{ $edit->swa_id_sekretaris }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Bendahara</label>
                            <input type="text" class="form-control m-input" name="swa_id_bendahara"
                                value="{{ $edit->swa_id_bendahara }}">
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