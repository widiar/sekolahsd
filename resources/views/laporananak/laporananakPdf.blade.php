<head>
    <title>Raport Anak</title>
    {{--
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/nota.css') }}"> --}}
    <style>
        :root {
            --blue: #007bff;
            --indigo: #6610f2;
            --purple: #6f42c1;
            --pink: #e83e8c;
            --red: #dc3545;
            --orange: #fd7e14;
            --yellow: #ffc107;
            --green: #28a745;
            --teal: #20c997;
            --cyan: #17a2b8;
            --white: #fff;
            --gray: #6c757d;
            --gray-dark: #343a40;
            --primary: #007bff;
            --secondary: #6c757d;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --breakpoint-xs: 0;
            --breakpoint-sm: 576px;
            --breakpoint-md: 768px;
            --breakpoint-lg: 992px;
            --breakpoint-xl: 1200px;
            --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            font-family: sans-serif;
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }

        article,
        aside,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        main,
        nav,
        section {
            display: block;
        }

        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .clearfix::after {
            display: block;
            clear: both;
            content: "";
        }

        table {
            border-collapse: collapse;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table-sm th,
        .table-sm td {
            padding: 0.3rem;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table-bordered thead th,
        .table-bordered thead td {
            border-bottom-width: 2px;
        }

        .table-borderless th,
        .table-borderless td,
        .table-borderless thead th,
        .table-borderless tbody+tbody {
            border: 0;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-hover tbody tr:hover {
            color: #212529;
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-primary,
        .table-primary>th,
        .table-primary>td {
            background-color: #b8daff;
        }

        .table-primary th,
        .table-primary td,
        .table-primary thead th,
        .table-primary tbody+tbody {
            border-color: #7abaff;
        }

        .table-hover .table-primary:hover {
            background-color: #9fcdff;
        }

        .table-hover .table-primary:hover>td,
        .table-hover .table-primary:hover>th {
            background-color: #9fcdff;
        }

        .table-secondary,
        .table-secondary>th,
        .table-secondary>td {
            background-color: #d6d8db;
        }

        .table-secondary th,
        .table-secondary td,
        .table-secondary thead th,
        .table-secondary tbody+tbody {
            border-color: #b3b7bb;
        }

        .table-hover .table-secondary:hover {
            background-color: #c8cbcf;
        }

        .table-hover .table-secondary:hover>td,
        .table-hover .table-secondary:hover>th {
            background-color: #c8cbcf;
        }

        .table-success,
        .table-success>th,
        .table-success>td {
            background-color: #c3e6cb;
        }

        .table-success th,
        .table-success td,
        .table-success thead th,
        .table-success tbody+tbody {
            border-color: #8fd19e;
        }

        .table-hover .table-success:hover {
            background-color: #b1dfbb;
        }

        .table-hover .table-success:hover>td,
        .table-hover .table-success:hover>th {
            background-color: #b1dfbb;
        }

        .table-info,
        .table-info>th,
        .table-info>td {
            background-color: #bee5eb;
        }

        .table-info th,
        .table-info td,
        .table-info thead th,
        .table-info tbody+tbody {
            border-color: #86cfda;
        }

        .table-hover .table-info:hover {
            background-color: #abdde5;
        }

        .table-hover .table-info:hover>td,
        .table-hover .table-info:hover>th {
            background-color: #abdde5;
        }

        .table-warning,
        .table-warning>th,
        .table-warning>td {
            background-color: #ffeeba;
        }

        .table-warning th,
        .table-warning td,
        .table-warning thead th,
        .table-warning tbody+tbody {
            border-color: #ffdf7e;
        }

        .table-hover .table-warning:hover {
            background-color: #ffe8a1;
        }

        .table-hover .table-warning:hover>td,
        .table-hover .table-warning:hover>th {
            background-color: #ffe8a1;
        }

        .table-danger,
        .table-danger>th,
        .table-danger>td {
            background-color: #f5c6cb;
        }

        .table-danger th,
        .table-danger td,
        .table-danger thead th,
        .table-danger tbody+tbody {
            border-color: #ed969e;
        }

        .table-hover .table-danger:hover {
            background-color: #f1b0b7;
        }

        .table-hover .table-danger:hover>td,
        .table-hover .table-danger:hover>th {
            background-color: #f1b0b7;
        }

        .table-light,
        .table-light>th,
        .table-light>td {
            background-color: #fdfdfe;
        }

        .table-light th,
        .table-light td,
        .table-light thead th,
        .table-light tbody+tbody {
            border-color: #fbfcfc;
        }

        .table-hover .table-light:hover {
            background-color: #ececf6;
        }

        .table-hover .table-light:hover>td,
        .table-hover .table-light:hover>th {
            background-color: #ececf6;
        }

        .table-dark,
        .table-dark>th,
        .table-dark>td {
            background-color: #c6c8ca;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th,
        .table-dark tbody+tbody {
            border-color: #95999c;
        }

        .table-hover .table-dark:hover {
            background-color: #b9bbbe;
        }

        .table-hover .table-dark:hover>td,
        .table-hover .table-dark:hover>th {
            background-color: #b9bbbe;
        }

        .table-active,
        .table-active>th,
        .table-active>td {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table-hover .table-active:hover>td,
        .table-hover .table-active:hover>th {
            background-color: rgba(0, 0, 0, 0.075);
        }

        .table .thead-dark th {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
        }

        .table .thead-light th {
            color: #495057;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        .table-dark {
            color: #fff;
            background-color: #343a40;
        }

        .table-dark th,
        .table-dark td,
        .table-dark thead th {
            border-color: #454d55;
        }

        .table-dark.table-bordered {
            border: 0;
        }

        .table-dark.table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .table-dark.table-hover tbody tr:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.075);
        }

        @media (max-width: 575.98px) {
            .table-responsive-sm {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive-sm>.table-bordered {
                border: 0;
            }
        }

        @media (max-width: 767.98px) {
            .table-responsive-md {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive-md>.table-bordered {
                border: 0;
            }
        }

        @media (max-width: 991.98px) {
            .table-responsive-lg {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive-lg>.table-bordered {
                border: 0;
            }
        }

        @media (max-width: 1199.98px) {
            .table-responsive-xl {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-responsive-xl>.table-bordered {
                border: 0;
            }
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive>.table-bordered {
            border: 0;
        }

        body {
            font-size: 11px;
        }

        h1 {
            font-size: 24px;
        }

        h2 {
            font-size: 20px;
        }

        h3 {
            font-size: 14px;
            font-weight: bold;
        }

        h4 {
            font-size: 12px;
            font-weight: bold;
        }

        .div-logo {
            width: 15%;
            float: left;
            padding: 0 4px 0 0;
        }

        .div-judul {
            width: 85%;
            float: left;
            padding: 0 4px 0 0;
        }

        .div-2 {
            width: 50%;
            float: left;
            padding: 0 4px 0 0;
        }

        .div-3 {
            width: 33.3%;
            float: left;
            padding: 0 4px 0 0;
        }

        .div-3 tr td {
            vertical-align: top;
            padding-top: 0;
        }

        .label-2 label {
            padding-top: 12px;
        }

        .table th,
        .table td {
            padding: 2px 4px;
        }

        .table th {
            text-align: center;
        }

        .table th.number,
        .table td.number {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .logo {
            float: left;
            width: 20%;
        }

        .judul {
            float: left;
            width: 80%;
            padding-left: 20px;
        }

        .judul h4 {
            margin-bottom: 4px;
        }
    </style>
</head>

<body>

    <div class="div-logo">
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAN4AAADTCAYAAADu+a1pAAAACXBIWXMAAAsTAAALEwEAmpwYAAAJTWlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNi4wLWMwMDIgNzkuMTY0NDYwLCAyMDIwLzA1LzEyLTE2OjA0OjE3ICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06RG9jdW1lbnRJRD0iYWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjlhNGVlNTliLWE3NTItNzI0NS04MTMzLTNkMDk1MWMyNzIxOCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo1NWU5NDBiNy0zYWZiLTRlYzQtOGViYy05ODY2N2E5MGU3ODAiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0iNjk0QzQxNzNBN0YyNzRBN0FGRjI3QTVBQkYxNjRDNUIiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0iIiB0aWZmOkltYWdlV2lkdGg9IjQwMCIgdGlmZjpJbWFnZUxlbmd0aD0iMjg2IiB0aWZmOlBob3RvbWV0cmljSW50ZXJwcmV0YXRpb249IjIiIHRpZmY6U2FtcGxlc1BlclBpeGVsPSIzIiB0aWZmOlhSZXNvbHV0aW9uPSI3Mi8xIiB0aWZmOllSZXNvbHV0aW9uPSI3Mi8xIiB0aWZmOlJlc29sdXRpb25Vbml0PSIyIiBleGlmOkV4aWZWZXJzaW9uPSIwMjMxIiBleGlmOkNvbG9yU3BhY2U9IjY1NTM1IiBleGlmOlBpeGVsWERpbWVuc2lvbj0iNDAwIiBleGlmOlBpeGVsWURpbWVuc2lvbj0iMjg2IiB4bXA6Q3JlYXRlRGF0ZT0iMjAyMi0wOS0wN1QxMTozOTo0NiswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMjItMDktMDdUMTE6NDI6MTkrMDg6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDktMDdUMTE6NDI6MTkrMDg6MDAiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo2NjI3NmRlOC1jMmVkLTQ5NTYtOGIzMS1jZjQzYmM0ZjVjYWIiIHN0RXZ0OndoZW49IjIwMjItMDktMDdUMTE6NDI6MTkrMDg6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCAyMS4yIChNYWNpbnRvc2gpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjb252ZXJ0ZWQiIHN0RXZ0OnBhcmFtZXRlcnM9ImZyb20gaW1hZ2UvanBlZyB0byBpbWFnZS9wbmciLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImRlcml2ZWQiIHN0RXZ0OnBhcmFtZXRlcnM9ImNvbnZlcnRlZCBmcm9tIGltYWdlL2pwZWcgdG8gaW1hZ2UvcG5nIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo1NWU5NDBiNy0zYWZiLTRlYzQtOGViYy05ODY2N2E5MGU3ODAiIHN0RXZ0OndoZW49IjIwMjItMDktMDdUMTE6NDI6MTkrMDg6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCAyMS4yIChNYWNpbnRvc2gpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDwvcmRmOlNlcT4gPC94bXBNTTpIaXN0b3J5PiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDo2NjI3NmRlOC1jMmVkLTQ5NTYtOGIzMS1jZjQzYmM0ZjVjYWIiIHN0UmVmOmRvY3VtZW50SUQ9IjY5NEM0MTczQTdGMjc0QTdBRkYyN0E1QUJGMTY0QzVCIiBzdFJlZjpvcmlnaW5hbERvY3VtZW50SUQ9IjY5NEM0MTczQTdGMjc0QTdBRkYyN0E1QUJGMTY0QzVCIi8+IDx0aWZmOkJpdHNQZXJTYW1wbGU+IDxyZGY6U2VxPiA8cmRmOmxpPjg8L3JkZjpsaT4gPHJkZjpsaT44PC9yZGY6bGk+IDxyZGY6bGk+ODwvcmRmOmxpPiA8L3JkZjpTZXE+IDwvdGlmZjpCaXRzUGVyU2FtcGxlPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PidF7mQAASIqSURBVHic7L1nnGVXdeb93/vkm2/l1Dmqg9TdSq1WapSFQEjkIAzYGLDBYfCMx3nsmfHYHnswYMBgQICQAIkgoWRJKAdaqYM65+6qrq6cbjz57PfDqSrAM+84DNBg9Oh31apSV9199t3rrLPC8yyhlOJV/Pzh0Ucf3bR3797Ltm7d+rUNGzaMnen1vIp/HfQzvYBX8a/Hrl27Oj75yU9+fs+ePZtOnz69Skr5x2efffbEmV7Xq/iXQ57pBbyKfz2OHj167iuvvLIpjmO++c1vfuiVV1658kyv6VX86/Cq4f2c4eFH7r/sY3/7V3f4WkBDNZFawu2fv/Vv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"
            width="100%">
    </div>
    <div class="div-judul">
        <h3 align="center">PEMERINTAH KABUPATEN BADUNG</h3>
        <h3 align="center">DINAS PENDIDIKAN KEBUDAYAAN PEMUDA DAN OLAH RAGA </h3>
        <h2 align="center">SDN 4 UNGASAN</h2>
        <h2 align="center">KECAMATAN KUTA SELATAN KABUPATEN BADUNG</h2>
    </div>
    <div class="clearfix"></div>
    <hr />
    <h3 align="center">LAPORAN PENILAIAN HASIL BELAJAR SISWA</h3>
    <h3 align="center">TAHUN PELAJARAN {{ (date('Y')-1).'/'.(date('Y')-0) }}</h3>
    <br />
    <table class="table table-bordered">
        <tr>
            <td width="20" align="center">No</td>
            <td>Nama Lengkap Siswa</td>
            <td align="center">NISN</td>
            <td align="center">Kelas</td>
        </tr>
        <tr>
            <td align="center">1</td>
            <td>{{ $siswa->swa_nama }}</td>
            <td align="center">{{ $siswa->swa_nis }}</td>
            <td align="center">{{ $siswa->kelas->kls_nama }}</td>
        </tr>
    </table>
    <br />
    <table class="table table-bordered">
        <tr>
            <td rowspan="2" width="20" align="center">No</td>
            <td rowspan="2" align="center">Mata Pelajaran</td>
            <td rowspan="2" align="center">KKM</td>
            <td colspan="2" align="center">Nilai</td>
            <td rowspan="2" align="center">Deskripsi Kemajuan Belajar</td>
        </tr>
        <tr>
            <td align="center">Angka</td>
            <td align="center">Huruf</td>
        </tr>
        @php
            $unKKM = 0;
            $total = 0;
            $jumlah = 0;
        @endphp
        @foreach($nilai as $key => $row)
            @php
            $total += $row->nilai;
            $jumlah++;
            @endphp
        <tr>
            <td align="center">{{ ++$key }}</td>
            <td>{{ $row->mata_pelajaran->mpj_nama }}</td>
            <td align="center">{{ $row->mata_pelajaran->mpj_nilai_lulus }}</td>
            <td align="center">{{ $row->nilai }}</td>
            <td>{{ Main::terbilang($row->nilai) }}</td>
            <td>
                @if ($row->nilai >= $row->mata_pelajaran->mpj_nilai_lulus)
                    KKM Tercapai
                @else
                    KKM Tidak Tercapai
                    @php
                    ++$unKKM
                    @endphp
                @endif
            </td>
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td colspan="2">Jumlah</td>
            <td align="center">{{ $total }}</td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Rata-Rata</td>
            <td align="center">{{ round($total/$jumlah) }}</td>
            <td colspan="2"></td>
        </tr>
    </table>
    <br />
    <table class="table table-bordered">
        <tr>
            <td>Keterangan Kenaikan Kelas</td>
            <td>{{count($nilai) >=3 ? $unKKM <= 3 ? 'Naik Kelas' : 'Tidak Naik Kelas' : '-'}}</td>
        </tr>
    </table>
    <br />
    <br />
    <table width="100%">
        <tr>
            <td width="20"></td>
            <td width="20%">Mengetahui</td>
            <td width="50%"></td>
            <td width="30%">Jimbaran, {{ date('d F Y') }}</td>
        </tr>
        <tr>
            <td></td>
            <td>Orang Tua/Wali</td>
            <td></td>
            <td>Wali Kelas</td>
        </tr>
        <tr>
            <td height="50"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>{{ $orang_tua ? $orang_tua->ort_nama_ayah ? $orang_tua->ort_nama_ayah : $orang_tua->ort_nama_ibu
                    : '' }}</strong>
            </td>
            <td></td>
            <td><strong>{{ $guru_wali->gru_nama }}</strong></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>NIP. {{ $guru_wali->gru_nip }}</td>
        </tr>
    </table>

</body>