<?php header('Access-Control-Allow-Origin: *'); ?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Auth::user()->name }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ config('app.cdn') }}/assets/vendor/perfect-scrollbar/perfect-scrollbar.css">

    <link rel="stylesheet" href="{{ config('app.cdn') }}/assets/css/admin.css">

    <link rel="shortcut icon" href="{{ config('app.cdn') }}/assets/img/favicon.ico">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>

</head>

<body>
    <div id="app">


        @include('account.sidebar')

        <div id="main" class='layout-navbar'>

            @include('account.navigation')

            <div id="main-content">

                <div class="page-heading">

                    @include("account.{$view_file}")

                </div>

                @include('account.footer')

            </div>

        </div>

    </div>

    <script src="{{ config('app.cdn') }}/assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="{{ config('app.cdn') }}/assets/js/admin.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    <script src="{{ config('app.cdn') }}/assets/vendor/bootstrap-select/bootstrap-select.js"></script>
    <link rel="stylesheet" href="{{ config('app.cdn') }}/assets/vendor/bootstrap-select/bootstrap-select.css">

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        $('.selectpicker').selectpicker();

        $(document).ready(function() {
            $('.summernote').summernote({
                height: 130,
                toolbar: [
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link', 'video']],
                ]
            });
        });
    </script>
</body>

</html>
