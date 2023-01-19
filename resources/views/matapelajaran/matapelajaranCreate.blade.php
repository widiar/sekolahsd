<form action="{{ route('matapelajaranInsert') }}" method="post" class="m-form form-send" autocomplete="off">
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
                            <label class="form-control-label required">Kode Mata Pelajaran</label>
                            <input type="text" class="form-control m-input" name="mpj_kode">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control m-input" name="mpj_nama">
                        </div>
                        {{-- <div class="form-group m-form__group">
                            <label class="form-control-label required">Mata Pelajaran Untuk Kelas</label>
                            <input type="text" class="form-control m-input" name="mpj_kelas">
                        </div> --}}
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Mata Pelajaran Untuk Kelas</label>
                            <select class="form-control m-select2" name="mpj_kelas"
                                    style="width: 100%">
                                    {{-- @for ($i =0; $i <= 10; $i++)
                                    <option value="1">pilihan</option>
                                    @endfor --}}
                                    <option value="" hidden>&nbsp</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                    <option value="VI">VI</option>

                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Batas Nilai Lulus</label>
                            <input type="text" class="form-control m-input" name="mpj_nilai_lulus">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Guru Pengajar</label>
                            <select class="form-control m-select2" name="id_guru"
                                    data-placeholder="Pilih Guru" style="width: 100%">
                                    {{-- @for ($i =0; $i <= 10; $i++)
                                    <option value="1">pilihan</option>
                                    @endfor --}}
                                    <option value="" hidden>&nbsp</option>
                                @foreach($guru as $row)
                                    <option value="{{ $row->id_guru }}">{{ $row->gru_nip }}&nbsp&nbsp&nbsp{{ $row->gru_nama }}</option>
                                @endforeach
                            </select>
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
