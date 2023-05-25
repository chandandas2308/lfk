<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('backend/vendors/mdi/css/materialdesignicons.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendors/flag-icon-css/css/flag-icon.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendors/css/vendor.bundle.base.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendors/font-awesome/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('backend/css/style.css')}}" />
    <link rel="shortcut icon" href="{{ asset('backend/images/favicon.png')}}" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.css') }}">

    <link
      rel="stylesheet"
      href="{{ asset('backend/vendors/css/vendor.bundle.base.css')}}"
    />
    

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.3.0/css/fixedColumns.dataTables.css">
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>

      input[type=search],
      #selectCategory,
      #selectVarient,
      #stockAgingFilter,
      #customerManagement1,
      #selectInvoiceStatus,
      #selectSalesPaymentStatus{
        height: 38px !important;
        display: inline-block;
        border: 2px solid #ccc;
        padding: 5px 2px !important;
        box-sizing: border-box;
        text-transform: capitalize;
        margin: auto !important;
      }

      #resetVendorFilterSection,
      #resetPurchaseReqFilter,
      #resetPurchaseOrderFilter,
      #resetsalesQuotationBtn,
      #resetcustomerManagementBtn,
      #resetWarehouseFilterBtn,
      #stockTrackingModalPopBtn,
      #searchLabel,
      #searchLabel1,
      #resetREFilterCategory,
      #resetREFilter,
      #resetcustomerManagementBtn1,
      #resetProductFilter,
      #resetProductFilterStockAgaing,
      #resetSalesInvoiceFilter,
      #resetSalesPaymentFilter{
       border: 2px solid #ccc;
       height: 38px;
       margin-top: 7px;
       text-transform: capitalize;
       
      }
      #stockTrackingModalPopBtn:hover
      {
        color:#fff !important;
      }
      input, select{
        color: black !important;
      }

    </style>

  </head>
  <body>
    <div class="container-scroller">