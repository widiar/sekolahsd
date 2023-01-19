<form action="{{ route('karyawanInsert') }}" method="post" class="m-form form-send" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nama Karyawan </label>
                            <input type="text" class="form-control m-input" name="nama_karyawan">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Posisi Karyawan </label>
                            <input type="text" class="form-control m-input" name="posisi_karyawan">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Telepon Karyawan </label>
                            <input type="text" class="form-control m-input" name="telp_karyawan">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Email Karyawan </label>
                            <input type="text" class="form-control m-input" name="email_karyawan">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Alamat Karyawan </label>
                            <textarea class="form-control m-input" name="alamat_karyawan"></textarea>
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
