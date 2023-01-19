<div class="m-portlet m-portlet--tab">
    <form method="get" class="m-form m-form--fit m-form--label-align-right form-dashboard-filter">
        <div class="m-portlet__body">
            <div class="form-group m-form__group row text-center">
                @if(in_array('date', $type))
                    <label class="col-form-label col-lg-2 col-sm-12">Rentang Tanggal Data</label>
                    <div class="col-lg-2 col-md-9 col-sm-12">
                        <input type='text'
                               class="form-control m_datepicker_1_modal"
                               readonly
                               value="{{ $date_from }}"
                               placeholder="Select time"
                               name="date_from"/>
                    </div>
                    <div class="col-lg-2 col-md-9 col-sm-12">
                        <input type='text'
                               class="form-control m_datepicker_1_modal"
                               readonly
                               value="{{ $date_to }}"
                               placeholder="Select time"
                               name="date_to"/>
                    </div>
                @endif
                @if(in_array('keywords', $type))
                    <div class="col-lg-2 col-md-9 col-sm-12">
                        <input type='text'
                               class="form-control"
                               value="{{ $keywords }}"
                               placeholder="Ketik kata pencarian ..."
                               name="keywords"/>
                    </div>
                @endif
                <div class="col-lg-1 col-sm-12">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-accent  m-btn--pill">
                            <i class="la la-search"></i> Filter Data
                        </button>
                        @if(in_array('date', $type))
                            <button type="button"
                                    class="btn btn-info  m-btn--pill dropdown-toggle dropdown-toggle-split"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tipe Filter
                                <span class="sr-only">
                            Toggle Dropdown
                        </span>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item"
                                   href="?date_from={{ date('d-m-Y') }}&date_to={{ date('d-m-Y') }}&keywords={{ urlencode($keywords) }}">
                                    <i class="la la-search"></i> Data Hari Ini
                                </a>
                                <a class="dropdown-item"
                                   href="?date_from={{ date('01-m-Y') }}&date_to={{ date('t-m-Y') }}&keywords={{ urlencode($keywords) }}">
                                    <i class="la la-search"></i> Data Bulan Ini
                                </a>
                                <a class="dropdown-item"
                                   href="?date_from={{ date('d-m-Y', strtotime($date_first)) }}&date_to={{ date('t-m-Y') }}&keywords={{ urlencode($keywords) }}">
                                    <i class="la la-search"></i> Semua Data
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>