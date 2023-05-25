<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('pos/assets/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('pos/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('pos/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('pos/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('pos/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('pos/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('pos/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('pos/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('pos/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Template Main CSS File -->
  <link href="{{ asset('pos/assets/css/style.css') }}" rel="stylesheet">
  <!-- <link rel="stylesheet" href="{{ asset('toastr/toastr.css') }}"> -->
  <link rel="stylesheet" href="{{ asset('toastr/toastr.css') }}">
  <link href="{{ asset('pos/assets/css/demo.css') }}" rel="stylesheet">
  <style>
    th.dt-center, td.dt-center { text-align: center; }
    table#pos-sales-orders-table-list,
    table#pos_stock_table_orders_list {
      text-align: center;
    }
    .table>thead {
      text-align-last: center;
    }
    </style>
</head>