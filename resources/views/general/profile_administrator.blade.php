@extends('../general/index')

@section('css')

@endsection

@section('js')
@endsection

@section('body')

    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <div class="m-content">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="m-portlet">
                        <div class="m-portlet__body">
                            <div class="m-card-profile">
                                <div class="m-card-profile__title m--hide">
                                    Your Profile
                                </div>
                                <div class="m-card-profile__pic">
                                    <div class="m-card-profile__pic-wrapper">
                                        <img src="{{ asset('upload/'.$user->karyawan->foto_karyawan) }}" alt=""/>
                                    </div>
                                </div>
                                <div class="m-card-profile__details">
                                    <span class="m-card-profile__name">{{ $user->karyawan->nama_karyawan }}</span>
                                    <a href="mailto:{{ $user->karyawan->email_karyawan }}"
                                       class="m-card-profile__email m-link">{{ $user->karyawan->email_karyawan }}</a>
                                    <br/>
                                    <a href="telp:{{ $user->karyawan->telp_karyawan }}"
                                       class="m-card-profile__email m-link">{{ $user->karyawan->telp_karyawan }}</a>
                                    <br/>
                                    <span class="m-card-profile__email m-link">{{ $user->karyawan->posisi_karyawan }}</span>
                                    <br/>
                                    <span class="m-card-profile__email m-link">{{ $user->karyawan->alamat_karyawan }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                        <form action="{{ route('profilAdministratorUpdate') }}" method="post"
                              class="m-form m-form--fit m-form--label-align-right form-send">
                            {{ csrf_field() }}
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">1. Informasi Akun</h3>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-3 col-form-label">Username</label>
                                    <div class="col-9">
                                        <input class="form-control m-input" name="username" type="text"
                                               value="{{ $user->username }}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label">Password Baru</label>
                                    <div class="col-9">
                                        <input class="form-control m-input" type="password" name="password">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label">Konfirmasi Password Baru</label>
                                    <div class="col-9">
                                        <input class="form-control m-input" type="password" name="password_confirm">
                                    </div>
                                </div>

                                <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>

                                <div class="form-group m-form__group row">
                                    <div class="col-10 ml-auto">
                                        <h3 class="m-form__section">2. Informasi Karyawan</h3>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label">Foto Karyawan</label>
                                    <div class="col-9">
                                        <div class="input-group">
                                                <span class="input-group-btn">
                                                    <span class="btn btn-success btn-file">
                                                        <i class="fa fa-file-image"></i> Browse Foto <input type="file"
                                                                                                            class="imgInp"
                                                                                                            name="foto_karyawan"
                                                                                                            accept="image/*">
                                                    </span>
                                                </span>
                                            <input type="text" class="form-control" readonly>
                                        </div>
                                        <img class='img-preview'
                                             src="{{ asset('upload/'.$user->karyawan->foto_karyawan) }}"
                                             style="width: 200px !important;"/>
                                    </div>
                                </div>

                                <div class="form-group m-form__group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label">Nama Karyawan</label>
                                    <div class="col-9">
                                        <input class="form-control m-input" type="text" name="nama_karyawan"
                                               value="{{ $user->karyawan->nama_karyawan }}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label">Posisi Karyawan</label>
                                    <div class="col-9">
                                        <input class="form-control m-input" type="text" name="posisi_karyawan"
                                               value="{{ $user->karyawan->posisi_karyawan }}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label">Nomer Telepon Karyawan</label>
                                    <div class="col-9">
                                        <input class="form-control m-input" type="text" name="telp_karyawan"
                                               value="{{ $user->karyawan->telp_karyawan }}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label">Alamat Karyawan</label>
                                    <div class="col-9">
                                        <input class="form-control m-input" type="text" name="alamat_karyawan"
                                               value="{{ $user->karyawan->alamat_karyawan }}">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input"
                                           class="col-3 col-form-label">Email Karyawan</label>
                                    <div class="col-9">
                                        <input class="form-control m-input" type="text" name="email_karyawan"
                                               value="{{ $user->karyawan->email_karyawan }}">
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-3">
                                        </div>
                                        <div class="col-9">
                                            <button type="submit"
                                                    class="btn btn-update btn-accent m-btn m-btn--air m-btn--custom">
                                                <i class="fa fa-check"></i> Perbarui
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection