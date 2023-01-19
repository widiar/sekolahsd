<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
    <li class="m-nav__item m-nav__item--home">
        <a href="{{ route('dashboardPage') }}" class="m-nav__link">
            <span class="m-nav__link-text">Dashboard</span>
        </a>
    </li>
    @foreach($menu as $label=>$key)
        @if($key['route'] == $currentUrl)
            <li class="m-nav__separator">
                <i class="la la-angle-right"></i>
            </li>
            <li class="m-nav__item">
                <a href="{{ $key['route'] }}" class="m-nav__link">
                    <span class="m-nav__link-text">{{ $label }}</span>
                </a>
            </li>
        @else
            @if(isset($key['sub']))
                @foreach($key['sub'] as $label2=>$key2)
                    @if($key2['route'] == $menuActive)
                        <li class="m-nav__separator">
                            <i class="la la-angle-right"></i>
                        </li>
                        <li class="m-nav__item">
                            <a href="{{ $key['route'] }}" class="m-nav__link">
                                <span class="m-nav__link-text">{{ $label }}</span>
                            </a>
                        </li>

                        <li class="m-nav__separator">
                            <i class="la la-angle-right"></i>
                        </li>
                        <li class="m-nav__item">
                            <a href="{{ $key2['route'] }}" class="m-nav__link">
                                <span class="m-nav__link-text">{{ $label2 }}</span>
                            </a>
                        </li>
                    @else
                        @if(isset($key2['sub']))
                            @foreach($key2['sub'] as $label3=>$key3)
                                @if($key3['routeName'] == $routeName)
                                    <li class="m-nav__separator">
                                        <i class="la la-angle-right"></i>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="{{ $key['route'] }}" class="m-nav__link">
                                            <span class="m-nav__link-text">{{ $label }}</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__separator">
                                        <i class="la la-angle-right"></i>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="{{ $key2['route'] }}" class="m-nav__link">
                                            <span class="m-nav__link-text">{{ $label2 }}</span>
                                        </a>
                                    </li>
                                    <li class="m-nav__separator">
                                        <i class="la la-angle-right"></i>
                                    </li>
                                    <li class="m-nav__item">
                                        <a href="{{ $currentUrl }}" class="m-nav__link">
                                            <span class="m-nav__link-text">{{ $label3 }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endif
                @endforeach
            @endif
        @endif
    @endforeach
</ul>