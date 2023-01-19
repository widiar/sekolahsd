<form action="{{ route('matapelajaranUpdate', ['id'=>Main::encrypt($edit->id_mata_pelajaran)]) }}" method="post"
      class="m-form form-send">
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
                            <label class="form-control-label required">Kode</label>
                            <input type="text" class="form-control m-input" name="mpj_kode"
                                   value="{{ $edit->mpj_kode }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nama Mata Pelajaran</label>
                            <input type="text" class="form-control m-input" name="mpj_nama"
                                   value="{{ $edit->mpj_nama }}">
                        </div>
                        {{-- <div class="form-group m-form__group">
                            <label class="form-control-label required">Mata Pelajaran Untuk Kelas</label>
                            <input type="text" class="form-control m-input" name="mpj_kelas">
                        </div> --}}
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Mata Pelajaran Untuk Kelas</label>
                            <select class="form-control m-select2" name="mpj_kelas"
                                     style="width: 100%">
                                     <option value="I" {{ $edit->mpj_kelas == 'I' ? 'selected' : ''  }}>I</option>
                                     <option value="II" {{ $edit->mpj_kelas == 'II' ? 'selected' : ''  }}>II</option>
                                     <option value="III" {{ $edit->mpj_kelas == 'III' ? 'selected' : ''  }}>III</option>
                                     <option value="IV" {{ $edit->mpj_kelas == 'IV' ? 'selected' : ''  }}>IV</option>
                                     <option value="V" {{ $edit->mpj_kelas == 'V' ? 'selected' : ''  }}>V</option>
                                     <option value="VI" {{ $edit->mpj_kelas == 'VI' ? 'selected' : ''  }}>VI</option>
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Batas Nilai Lulus</label>
                            <input type="text" class="form-control m-input" name="mpj_nilai_lulus"
                                   value="{{ $edit->mpj_nilai_lulus }}">
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Pengajar</label>
                            <select class="form-control m-select2" name="id_guru"
                                    data-placeholder="Pilih Guru" style="width: 100%">
                                @foreach($guru as $row)
                                    <option value="{{ $row->id_guru}}" {{ $row->id_guru == $edit->id_guru ? 'selected' : ''  }}>
                                        {{ $row->gru_nip }}&nbsp&nbsp&nbsp{{ $row->gru_nama }}
                                    </option>
                                @endforeach
                            </select>
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
