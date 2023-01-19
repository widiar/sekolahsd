<form action="{{ route('userUpdate', ['id'=>Main::encrypt($edit->id)]) }}" method="post" class="m-form form-send">
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
                            <label class="form-control-label required">User Role </label>
                            <select name="id_user_role" class="form-control m-select2 edit-role" style="width: 100%">
                                <option value="">Pilih</option>
                                @foreach($user_role as $r)
                                    @if($r->role_name != 'Orang Tua')
                                    <option value="{{ $r->id }}" {{ $edit->id_user_role == $r->id ? 'selected':'' }}>{{ $r->role_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nama </label>
                            <input type="text" class="form-control m-input" name="nama" value="{{ $edit->nama }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Username </label>
                            <input type="text" class="form-control m-input" name="username" value="{{ $edit->username }}">
                        </div>
                        <div class="form-group m-form__group guru-select" style="display: none">
                            <label class="form-control-label required">Guru</label>
                            <select name="id_karyawan" class="form-control m-select2" style="width: 100%">
                                <option value="">Pilih</option>
                                @foreach($guru as $r)
                                    <option @if($edit->id_karyawan == $r->id_guru) selected @endif value="{{ $r->id_guru }}">{{ $r->gru_nip }} - {{ $r->gru_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group siswa-select" style="display: none">
                            <label class="form-control-label required">Siswa</label>
                            <select name="id_karyawan" class="form-control m-select2" style="width: 100%">
                                <option value="">Pilih</option>
                                @foreach($siswa as $r)
                                    <option @if($edit->id_karyawan == $r->id_siswa) selected @endif value="{{ $r->id_siswa }}">{{ $r->swa_nis }} - {{ $r->swa_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label">Password </label>
                            <input type="password" class="form-control m-input" name="password">
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