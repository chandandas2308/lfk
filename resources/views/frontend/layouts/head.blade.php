<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="tags" content="Developed by BrainCave Software Pvt. Ltd" href="https://braincavesoft.com/">
    <!-- Mobile Specific Metas
      ================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
    <meta name="author" content="" />
    <meta name="generator" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Themefisher Icon font -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/themefisher-font/style.css') }}" />
    <!-- bootstrap.min css -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Animate css -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/animate/animate.css') }}" />
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="{{ asset('frontend/plugins/slick/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/plugins/slick/slick-theme.css') }}" />

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('toastr/toastr.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://kendo.cdn.telerik.com/2022.3.1109/styles/kendo.default-v2.min.css" />

    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-datepicker.min.css') }}">

    <style>
        .dt-head-center {
            text-align: center !important;
        }

        /* #addressesCards > thead, th, td {text-align: center !important;} */
        #addressesCards_filter {
            display: none;
        }

        .paginate_button.previous:before {
            content: '←';
        }

        .paginate_button.next:after {
            content: '→';
        }

    </style>

</head>
