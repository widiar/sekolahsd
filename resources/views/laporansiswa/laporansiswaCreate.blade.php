<form action="{{ route('laporansiswaInsert') }}" method="post" class="m-form form-send" autocomplete="off">
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
                            <label class="form-control-label required">Kelas</label>
                            <select class="form-control m-select2" name="id_kelas"
                                    data-placeholder="Pilih Kelas" style="width: 100%">
                                @foreach($kelas as $row)
                                    <option value="{{ $row->id_kelas }}">{{ $row->kls_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Jumlah Siswa</label>
                            <input type="text" class="form-control m-input" name="lps_jumlah_siswa">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Lulus</label>
                            <input type="text" class="form-control m-input" name="lps_lulus">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Tidak Lulus</label>
                            <input type="text" class="form-control m-input" name="lps_tidak_lulus">
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