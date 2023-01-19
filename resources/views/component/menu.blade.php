<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i
            class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
         m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            
            @foreach($menu as $key=>$value)
                @if(!isset($value['sub']))
                    @php
                        $aksesName = 'akses-'.$key;
                        $menuStatus = '';
                        if($menuActive) {
                            if($key == $menuActive) {
                                $menuStatus = 'm-menu__item--active';
                            }
                        } elseif($routeName == $value['route'] && $routeName !== 'underconstructionPage') {
                            $menuStatus = 'm-menu__item--active';
                        }
                    @endphp
                    <li class="m-menu__item {{ $menuStatus }} {{ $aksesName }}"
                        data-akses-name="{{ $aksesName }}"
                        aria-haspopup="true">
                        <a href="{{ route($value['route']) }}" class="m-menu__link ">
                            <i class="m-menu__link-icon {{ $value['icon'] }}"></i>
                            <span class="m-menu__link-title">
                                <span class="m-menu__link-wrap">
                                    <span class="m-menu__link-text">{{ Main::menuAction($key) }}</span>
                                    @if($key == 'stok_alert')
                                        {!! $stokAlertBadge !!}
                                    @endif
                                </span>
                            </span>
                        </a>
                    </li>
                @else
                    @php

                        $aksesName = 'akses-'.$key;

                        $menuArr = [];
                        foreach($value['sub'] as $r) {
                            $menuArr[] = $r['route'];
                        }

                        $labelArr = [];
                        foreach($value['sub'] as $label=>$r) {
                            $labelArr[] = $label;
                        }

                        $subMenuStatus = '';
                        if(in_array($routeName, $menuArr) || $routeName == $value['route']) {
                            $subMenuStatus = 'm-menu__item--active m-menu__item--open akses-aktif';
                        } else {
                            if(in_array($menuActive, $labelArr)) {
                                $subMenuStatus = 'm-menu__item--active m-menu__item--open akses-aktif';
                            }
                        }

                    //ksort($value['sub']);

                    @endphp
                    <li class="m-menu__item  m-menu__item--submenu {{ $subMenuStatus }} {{ $aksesName }}"
                        data-akses-name="{{ $aksesName }}"
                        aria-haspopup="true"
                        m-menu-submenu-toggle="hover">
                        <a href="javascript:;" class="m-menu__link m-menu__toggle">
                            <i class="m-menu__link-icon {{ $value['icon'] }}"></i>
                            <span class="m-menu__link-text">{{ Main::menuAction($key) }}</span>
                            <i class="m-menu__ver-arrow la la-angle-right"></i>

                        </a>
                        <div class="m-menu__submenu ">
                            <span class="m-menu__arrow"></span>
                            <ul class="m-menu__subnav">
                                {{-- @dd($value['sub']); --}}
                                @foreach($value['sub'] as $key2=>$value2)

                                    @php

                                        $aksesName = 'akses-'.$key;

                                        $subMenuActive = '';
                                        if($routeName == $value2['route'] || $menuActive == $key2 ) {
                                            $subMenuActive = 'm-menu__item--active akses-aktif';
                                        }
                                        $name = str_replace("kelas ","",$key2);
                                        if(!is_null(Request::route('kls'))){
                                            if(Request::route('kls') ==  $name){
                                                $subMenuActive = 'm-menu__item--active akses-aktif';
                                            }
                                        }

                                    @endphp
                                    <li class="m-menu__item {{ $subMenuActive }} {{ $aksesName }}"
                                    @if($is_guru == 1)
                                    @if(!in_array($name, $role_guru) && str_contains($key2, 'kelas')) style="display: none" @endif
                                    @endif
                                        data-akses-name="{{ $aksesName }}"
                                        aria-haspopup="true">
                                        <a href="{{ route($value2['route']) }}" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span>
                                            </i>
                                            <span class="m-menu__link-text">{{ Main::menuAction($key2) }}</span>

                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
