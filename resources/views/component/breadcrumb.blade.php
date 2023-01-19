<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
    @foreach($breadcrumb as $row)
        <li class="m-nav__separator">
            <i class="la la-angle-right"></i>
        </li>
        <li class="m-nav__item">
            <a href="{{ $row['route'] }}" class="m-nav__link">
                <span class="m-nav__link-text">{{ Main::menuAction($row['label']) }}</span>
            </a>
        </li>
    @endforeach
</ul>