<form action="{{ route('userRoleUpdate', ['id'=>Main::encrypt($edit->id)]) }}" method="post" class="m-form form-send">
    {{ csrf_field() }}
    <div class="modal" id="modal-general" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                            <label class="form-control-label required">Role Nama </label>
                            <input type="text" class="form-control m-input" name="role_name" value="{{ $edit->role_name }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label">Keterangan </label>
                            <textarea class="form-control m-input" name="role_keterangan">{{ $edit->role_keterangan }}</textarea>
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