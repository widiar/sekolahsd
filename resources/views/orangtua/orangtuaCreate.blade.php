<form action="{{ route('orangtuaInsert') }}" method="post" class="m-form form-send" autocomplete="off">
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
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nama Ayah</label>
                            <input type="text" class="form-control m-input" name="ort_nama_ayah">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nama Ibu</label>
                            <input type="text" class="form-control m-input" name="ort_nama_ibu">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Orang Tua Dari</label>
                            <select class="form-control m-select2" name="id_siswa"
                                    data-placeholder="Pilih Siswa" style="width: 100%">
                                    <option value="" hidden>&nbsp</option>
                                @foreach($siswa as $row)

                                    <option value="{{ $row->id_siswa }}">
                                        {{ $row->swa_nis }}&nbsp&nbsp&nbsp{{ $row->swa_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Alamat</label>
                            <input type="text" class="form-control m-input" name="ort_alamat">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Username</label>
                            <input type="text" class="form-control m-input" name="username">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Password</label>
                            <input type="password" class="form-control m-input" name="password">
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
