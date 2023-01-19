var BootstrapDatepicker = function () {
    var t;
    t = mUtil.isRTL() ? {
            leftArrow: '<i class="la la-angle-right"></i>', rightArrow: '<i class="la la-angle-left"></i>'
        }
        : {
            leftArrow: '<i class="la la-angle-left"></i>', rightArrow: '<i class="la la-angle-right"></i>'
        }
    ;
    return {
        init: function () {
            $("#m_datepicker_1, #m_datepicker_1_validate").datepicker({
                    rtl: mUtil.isRTL(),
                    todayHighlight: !0,
                    orientation: "bottom left",
                    templates: t,
                    autoClose: true,
                }
            ),
                $("#m_datepicker_1_modal").datepicker({
                        rtl: mUtil.isRTL(), todayHighlight: !0, orientation: "bottom left", templates: t
                    }
                ),
                $("#m_datepicker_2, #m_datepicker_2_validate").datepicker({
                        rtl: mUtil.isRTL(), todayHighlight: !0, orientation: "bottom left", templates: t
                    }
                ),
                $(".m_datepicker").datepicker({
                        rtl: mUtil.isRTL(),
                        todayHighlight: !0,
                        orientation: "bottom left",
                        format: 'dd-mm-yyyy',
                        templates: t,
                        autoClose: true
                    }
                ).on('change', function(){
                    $('.datepicker').hide();
                }),
                $(".m_datepicker_top").datepicker({
                        rtl: mUtil.isRTL(),
                        todayHighlight: !0,
                        orientation: "top left",
                        format: 'dd-mm-yyyy',
                        templates: t,
                        autoClose: true
                    }
                ).on('change', function(){
                    $('.datepicker').hide();
                }),
                $(".m_datepicker_2").datepicker({
                        rtl: mUtil.isRTL(),
                        todayHighlight: !0,
                        orientation: "bottom left",
                        format: 'dd-mm-yyyy',
                        templates: t,
                        autoClose: true,
                    }
                ),
                $(".m_datepicker-year-month").datepicker({
                        rtl: mUtil.isRTL(),
                        todayHighlight: !0,
                        orientation: "bottom left",
                        format: 'mm-yyyy',
                        templates: t,
                        viewMode: "months",
                        minViewMode: "months"
                    }
                ),
                $(".m_datepicker-year").datepicker({
                    rtl: mUtil.isRTL(),
                    todayHighlight: !0,
                    orientation: "bottom left",
                    format: "yyyy",
                    viewMode: "years",
                    minViewMode: "years"
                }),
                $(".m_datepicker-month").datepicker({
                        rtl: mUtil.isRTL(),
                        todayHighlight: !0,
                        orientation: "bottom left",
                        format: 'mm',
                        templates: t,
                        viewMode: "months",
                        minViewMode: "months"
                    }
                ),
                $("#m_datepicker_2_modal").datepicker({
                        rtl: mUtil.isRTL(), todayHighlight: !0, orientation: "bottom left", templates: t
                    }
                ),
                $("#m_datepicker_3, #m_datepicker_3_validate").datepicker({
                        rtl: mUtil.isRTL(), todayBtn: "linked", clearBtn: !0, todayHighlight: !0, templates: t
                    }
                ),
                $("#m_datepicker_3_modal").datepicker({
                        rtl: mUtil.isRTL(), todayBtn: "linked", clearBtn: !0, todayHighlight: !0, templates: t
                    }
                ),
                $("#m_datepicker_4_1").datepicker({
                        rtl: mUtil.isRTL(), orientation: "top left", todayHighlight: !0, templates: t
                    }
                ),
                $("#m_datepicker_4_2").datepicker({
                        rtl: mUtil.isRTL(), orientation: "top right", todayHighlight: !0, templates: t
                    }
                ),
                $("#m_datepicker_4_3").datepicker({
                        rtl: mUtil.isRTL(),
                        todayHighlight: !0,
                        orientation: "bottom left",
                        format: 'dd-mm-yyyy',
                        templates: t
                    }
                ),
                $("#m_datepicker_4_5").datepicker({
                        rtl: mUtil.isRTL(),
                        todayHighlight: !0,
                        orientation: "bottom left",
                        format: 'dd-mm-yyyy',
                        templates: t
                    }
                ),
                $("#m_datepicker_4_4").datepicker({
                        rtl: mUtil.isRTL(), orientation: "bottom right", todayHighlight: !0, templates: t
                    }
                ),
                $("#m_datepicker_5").datepicker({
                        rtl: mUtil.isRTL(),
                        todayHighlight: !0,
                        templates: t,
                        orientation: "bottom left",
                        format: 'dd-mm-yyyy'
                    }
                ),
                $("#m_datepicker_6").datepicker({
                        rtl: mUtil.isRTL(),
                        todayHighlight: !0,
                        templates: t,
                        orientation: "bottom right",
                        format: 'dd-mm-yyyy'
                    }
                )
        }
    }
}

();
jQuery(document).ready(function () {
        BootstrapDatepicker.init()
    }
);