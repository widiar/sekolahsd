<form action="{{ route('userRoleUpdate', ['id'=>$id]) }}"
      method="post"
      class="m-form form-send"
      enctype="multipart/form-data"
      data-alert-show="true"
      data-alert-field-message="true">
    {{ csrf_field() }}

    <div class="m-portlet__body">
        <div class="m-form__section m-form__section--first">
            <div class="form-group m-form__group">
                <label class="form-control-label required">Nama Role </label>
                <input type="text" class="form-control m-input" name="role_name"
                       autofocus value="{{$list->role_name}}">
            </div>
            <div class="form-group m-form__group">
                <label class="form-control-label">Keterangan </label>
                <textarea class="form-control m-input" name="role_keterangan">{{$list->role_keterangan}}</textarea>
            </div>
        </div>
    </div>
{{--    <hr style="margin: 30px -20px 20px;">--}}
    <div class="modal-footer" style="margin: 30px -20px 20px;">
        <button type="submit" class="btn btn-success">Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
    </div>
</form>