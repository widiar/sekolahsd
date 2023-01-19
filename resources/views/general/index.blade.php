<!DOCTYPE html>
<html lang="en" data-time="{{ date('Y-m-d H:i:s') }}">

<head>
    <meta charset="utf-8" />
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="State colors">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/loading.css') }}" rel="stylesheet" type="text/css"/>
    @yield('css')
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
</head>

<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<div class="m-grid m-grid--hor m-grid--root m-page">
    <header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
        <div class="m-container m-container--fluid m-container--full-height">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <div class="m-stack__item m-brand  m-brand--skin-dark ">
                    <div class="m-stack m-stack--ver m-stack--general">
                        <div class="m-stack__item m-stack__item--middle m-brand__logo">
                            <a href="{{ route('dashboardadminPage') }}" class="">
                                <img src="{{ asset('images/logo-raport.png') }}" width="60">
                            </a>
                        </div>
                        <div class="m-stack__item m-stack__item--middle m-brand__tools">
                            <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                            <span></span>
                            </a>
                            <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                                <span></span>
                            </a>
                            <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                <i class="flaticon-more"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

                    <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
                        <div class="m-stack__item m-topbar__nav-wrapper">
                            <ul class="m-topbar__nav m-nav m-nav--inline">

                                <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                    m-dropdown-toggle="click">
                                    <a href="#" class="m-nav__link m-dropdown__toggle">

                                        <div style="padding-top: 12px; padding-right: 12px">
                                        <strong>{{ $user_nama }}</strong>
                                            <br />
                                        - {{ $user_role_name }}
                                        </div>
                                        <span class="m-topbar__userpic">
														<img src="{{ asset('upload/'.$user_foto) }}"
                                                             class="m--img-rounded m--marginless m--img-centered"
                                                             alt=""/>
													</span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center"
                                                 style="background: url({{ asset('assets/app/media/img/misc/user_profile_bg.jpg') }}); background-size: cover;">
                                                <div class="m-card-user m-card-user--skin-dark">
                                                    <div class="m-card-user__pic">
                                                        <img src="{{ asset('upload/'.$user_foto) }}"
                                                             class="m--img-rounded m--marginless" alt=""/>
                                                    </div>
                                                    <div class="m-card-user__details">
                                                        <span class="m-card-user__name m--font-weight-500">{{ $user_nama }}</span>
                                                        <span class="m-card-user__name">- {{ $user_role_name }}</span>
                                                        <a href="mailto:{{ $user_email }}"
                                                           class="m-card-user__email m--font-weight-300 m-link">{{ $user_email }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav m-nav--skin-light">
                                                        <li class="m-nav__section m--hide">
                                                            <span class="m-nav__section-text">Section</span>
                                                        </li>
                                                        <li class="m-nav__item m--hide">
                                                            <a href="{{ route('profilPage') }}" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                                <span class="m-nav__link-title">
																				<span class="m-nav__link-wrap">
																					<span class="m-nav__link-text">Profil Saya</span>
																				</span>
																			</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__separator m-nav__separator--fit">
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="{{ route('logoutDo') }}"
                                                               class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        {!! $menu !!}
        @yield('body')
    </div>
    {!! $footer !!}
</div>

<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>


<div class='container-loading hidden'>
    <div class='loader'>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--text'></div>
        <div class='loader--desc'></div>
    </div>
</div>

<span id="base-value"
      class="hidden"
      data-csrf-token="{{ csrf_token() }}"
      data-page-method="{{ $pageMethod }}"
      data-base-url="{{ URL('/') }}"
      data-decimal-step="{{ $decimalStep }}"
      data-ppn-persen="{{ $ppnPersen }}"
      data-method-proses="{{ $methodProses }}"

      data-route-city-list="{{ route('cityList') }}"
      data-route-subdistrict-list="{{ route('subdistrictList') }}"

      >
</span>

<textarea id="user-role-value" class="hidden">{!! $user_role_data !!}</textarea>
<textarea id="user-role-menu-action" class="hidden">{!! json_encode($menuAction) !!}</textarea>

<div class="wrapper-modal"></div>
<div class="temp-view-pdf m--hide"></div>

<form action="{{ route('cetakPdf') }}" method="post" class="form-cetak-pdf m--hide" target='_blank'>
    {{ csrf_field() }}
    <textarea name="view"></textarea>
</form>

<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/cleave/cleave.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
@yield('js')
</body>
</html>
