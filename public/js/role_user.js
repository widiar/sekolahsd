$(document).ready(function () {

    $('.check-akses.parent-super').change(function () {
        var no = $(this).data('no');
        var checked_child_parent = $('.check-akses[data-no-parent="' + no + '"]:checked').length;

        if ($(this).prop("checked") === true) {
            $('.check-akses.child-super[data-no="' + no + '"]').prop('checked', true);
        } else {
            $('.check-akses.child-super[data-no="' + no + '"]').prop('checked', false);

            /**
             * Saat child nya sudah ada checked, tidak bisa uncheck parent
             */
            if (checked_child_parent > 0) {
                $(this).prop('checked', true);
            }
        }

    });

    $('.check-akses.child-super').change(function () {
        var no = $(this).data('no');
        var child_count = $('.check-akses.child-super[data-no="' + no + '"]').length;
        var child_checked_count = $('.check-akses.child-super[data-no="' + no + '"]:checked').length;

        /**
         * jika child super check or uncheck, maka parent super akan check or uncheck juga
         */
        if (child_checked_count > 0) {
            $('.check-akses.parent-super[data-no="' + no + '"]').prop('checked', true);
        } else {
            $('.check-akses.parent-super[data-no="' + no + '"]').prop('checked', false);
        }
    });

    $('.check-akses.parent').change(function () {
        var no = $(this).data('no');
        var no_parent = $(this).data('no-parent');
        var parent_checked_count = $('.check-akses.parent[data-no-parent="' + no_parent + '"]').length;
        var child_parent_checked_count = $('.check-akses.child[data-no-parent="' + no_parent + '"]:checked').length;
        var checked_count = parseInt(parent_checked_count) + parseInt(child_parent_checked_count);

        //console.log(parent_checked_count, child_parent_checked_count, checked_count);

        /**
         * jika parent check or uncheck, maka child ikut check or uncheck all of them
         */
        if ($(this).prop("checked") === true) {
            $('.check-akses.child[data-no="' + no + '"]').prop('checked', true);
        } else {
            $('.check-akses.child[data-no="' + no + '"]').prop('checked', false);
        }

        /**
         * jika parent chec or uncheck, maka akan mengecheck, apakah parent dan child ada yang tercentang,
         * jika ada, maka parent super akan di centang, jika tidak, maka parent super akan di uncheck
         */
        if (checked_count > 0) {
            $('.check-akses.parent-super[data-no="' + no_parent + '"]').prop('checked', true);
        } else {
            $('.check-akses.parent-super[data-no="' + no_parent + '"]').prop('checked', false);
        }

    });

    $('.check-akses.child').change(function () {
        var no = $(this).data('no');
        var no_parent = $(this).data('no-parent');
        var child_count = $('.check-akses.child[data-no="' + no + '"]').length;
        var child_checked_count = $('.check-akses.child[data-no="' + no + '"]:checked').length;

        var child_parent_count = $('.check-akses.child[data-no-parent="' + no_parent + '"]').length;
        var child_parent_checked_count = $('.check-akses.child[data-no-parent="' + no_parent + '"]:checked').length;

        /**
         * Jika child parent dicentang, dan child parent tersebut pertama kali dicentang,
         * maka parent nya akan tercentang, untuk menu nya dapat di akses
         *
         * Jika saat unCheck, child parent tidak ada tercentang,
         * maka, parent agan unCheck juga
         */
        if ($(this).prop('checked') === true) {
            $('.check-akses.parent[data-no="' + no + '"]').prop('checked', true);
        } else {
            if (child_checked_count > 0) {
                $('.check-akses.parent[data-no="' + no + '"]').prop('checked', true);
            } else {
                $('.check-akses.parent[data-no="' + no + '"]').prop('checked', false);
            }
        }

        /**
         * Jika ada salah satu child parent di check or uncheck,
         * maka parent super akan ikut check or uncheck
         */
        if (child_parent_checked_count > 0) {
            $('.check-akses.parent-super[data-no="' + no_parent + '"]').prop('checked', true);
        } else {
            $('.check-akses.parent-super[data-no="' + no_parent + '"]').prop('checked', false);
        }


    });
});