<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/>
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin"
         id="m_login">
        <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside"
             style=" box-shadow: 0 0 150px rgba(0,0,0,0.9);">
            <div class="m-stack m-stack--hor m-stack--desktop">
                <div class="m-stack__item m-stack__item--fluid">
                    <div class="m-login__wrapper">
                        <div class="m-login__logo">
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('images/logo-raport.png') }}" width="200">
                                <br />
                                <br />
                                <h2>Sistem Akademik SD</h2>
                            </a>
                            <br/>
                            <br/>
                            <br/>
                            <br/>

                        </div>
                        <div class="m-login__signin">
                            <div class="m-login__head">
                                <h3 class="m-login__title">LOGIN ADMINISTRATOR</h3>
                            </div>
                            <form class="m-login__form m-form form-send" action="{{ route('loginDo') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input" type="text" placeholder="Username"
                                           name="username" autocomplete="off">
                                </div>
                                <div class="form-group m-form__group">
                                    <input class="form-control m-input m-login__form-input--last" type="password"
                                           placeholder="Password" name="password">
                                </div>
                                <div class="m-login__form-action">
                                    <button type="submit"
                                            class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air btn-login">
                                        LOGIN
                                    </button>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <br/>
                                    <br/>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content"
             style="background-image: url({{ asset('images/login-wallpaper.jpg') }})">

        </div>
    </div>
</div>


<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

</body>

</html>
