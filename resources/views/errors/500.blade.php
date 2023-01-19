


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Ooops ada yang salah</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" />
</head>
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid  m-error-6" style="background-image: url({{ asset('assets/app/media/img//error/bg6.jpg') }});">
        <div class="m-error_container">
            <div class="m-error_subtitle m--font-light">
                <h1>Oops...</h1>
            </div>
            <p class="m-error_description m--font-light">
                Sepertinya ada yang salah.<br>
                Mohon hubungi <a href="https://mahendrawardana.com" target="_blank" style="color: rgb(255,180,180);">Mahendra Wardana</a><br />
                dengan Kode Insiden : <strong>{{ $incidentCode }}</strong>
            </p>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>

</body>

</html>