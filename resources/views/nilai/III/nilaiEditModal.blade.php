<form action="{{ route('nilaiUpdate', ['id'=>Main::encrypt($edit->id_nilai)]) }}" method="post"
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
                        {{-- <div class="form-group m-form__group">
                            <label class="form-control-label required">No Absen</label>
                            <select class="form-control m-select2" name="id_absen"
                                    data-placeholder="Pilih No" style="width: 100%">
                                @foreach($absen as $row)
                                    <option value="{{ $row->id_absen}}" {{ $row->id_absen == $edit->id_absen ? 'selected' : ''  }}>
                                        {{ $row->abs_nomber }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Siswa</label>
                            <select class="form-control m-select2" name="id_siswa"
                                    data-placeholder="Pilih Siswa" style="width: 100%">
                                @foreach($siswa as $row)
                                    <option value="{{ $row->id_siswa}}" {{ $row->id_siswa == $edit->id_siswa ? 'selected' : ''  }}>
                                        {{ $row->swa_nis }}&nbsp&nbsp&nbsp{{ $row->swa_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group m-form__group">
                            <label class="form-control-label required">Kelas</label>
                            <select class="form-control m-select2" name="id_kelas"
                                    data-placeholder="Pilih Kelas" style="width: 100%">
                                @foreach($kelas as $row)
                                    <option value="{{ $row->id_kelas}}" {{ $row->id_kelas == $edit->id_kelas ? 'selected' : ''  }}>
                                        {{ $row->kls_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <input hidden type="text" class="form-control m-input" name="id_kelas" value="3">
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Mata Pelajaran</label>
                            <select class="form-control m-select2" name="id_mata_pelajaran"
                                    data-placeholder="Pilih Siswa" style="width: 100%">
                                @foreach($mata_pelajaran as $row)
                                    <option value="{{ $row->id_mata_pelajaran}}" {{ $row->id_mata_pelajaran == $edit->id_mata_pelajaran ? 'selected' : ''  }}>
                                        {{ $row->mpj_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-form__group">
                            <label class="form-control-label required">Nilai</label>
                            <input type="text" class="form-control m-input" name="nilai"
                                   value="{{ $edit->nilai}}">
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
