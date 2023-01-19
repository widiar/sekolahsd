<form action="{{ route('siswaInsertI') }}" method="post" class="m-form form-send" autocomplete="off">
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
                            <label class="form-control-label required">NIS</label>
                            <input type="text" class="form-control m-input" name="swa_nis">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nama Siswa</label>
                            <input type="text" class="form-control m-input" name="swa_nama">
                        </div>
                        <div class="form-group m-form__group">
                            {{-- <label class="form-control-label required">Kelas</label> --}}
                            <input hidden type="text" class="form-control m-input" name="id_kelas" value="1">
                            {{-- <select class="form-control m-select2" name="id_kelas"
                                    data-placeholder="Pilih Kelas" style="width: 100%">
                                @foreach($kelas as $row)
                                    <option value="1">{{ $row->kls_nama }}</option>
                                @endforeach
                            </select> --}}
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Alamat</label>
                            <input type="text" class="form-control m-input" name="swa_alamat">
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
