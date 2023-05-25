@extends('superadmin.layouts.master')
@section('title','Refferal Awards | LFK')
@section('body')

<!-- sales css file -->
<link rel="stylesheet" href="{{ asset('inventorybackend/css/style.css')}}" />
<!-- sales js file -->
<script src="{{ asset('inventorybackend/js/action.js')}}"></script>

<div class="main-panel">
    <div class="content-wrapper pb-0">
        <ul id="tabs">
            <!-- <li><a href="#Refferal">Refferal System</a></li> -->
          
        </ul>

        <!-- Quotation Tab Content -->
        <div class="tabContent" id="Refferal">
            @include('superadmin.refferal.refferal')
        </div>        

      

    </div>
@endsection        