<form action="{{ route('guruInsert') }}" method="post" class="m-form form-send" autocomplete="off">
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
                            <label class="form-control-label required">NIP</label>
                            <input type="text" class="form-control m-input" name="gru_nip">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nama Guru</label>
                            <input type="text" class="form-control m-input" name="gru_nama">
                        </div>
                        {{-- <div class="form-group m-form__group">
                            <label class="form-control-label required">Mengajar</label>
                            <select class="form-control m-select2" name="id_mata_pelajaran"
                                    data-placeholder="Pilih Guru" style="width: 100%">
                                @foreach($mata_pelajaran as $row)
                                    <option value="{{ $row->id_mata_pelajaran }}">{{ $row->id_mata_pelajaran }} - {{ $row->mpj_nama }}</option>
                                @endforeach
                                @for ($i =0; $i <= 10; $i++)
                                <option value="1">pilihan</option>
                                @endfor
                            </select>
                        </div> --}}
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Alamat</label>
                            <input type="text" class="form-control m-input" name="gru_alamat">
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
