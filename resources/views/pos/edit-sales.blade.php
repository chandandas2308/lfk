@extends('pos.layout.master')
@section('title','Customer | POS')
@section('body')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Sales</h1>
        <br>
    </div>
    @if(session()->has('message'))
    <div class="alert alert-success" id="alert">
        {{ session()->get('message') }}
        <!-- <button type="button" class="close" data-dismiss="alert">x</button> -->
    </div>
    @endif
    <section class="section customer">
        <div class="row">
        <form action="{{route('Pos-StoreSales')}}" method="post">
                @csrf
            <div class="col-12 mb-4">
                    <div class="row mb-3">
                        <div class="col-5">
                            <label for="inputText" class="col-sm-8 col-form-label">Customer Name:</label>
                            <select name="customer_name" id="customer_name" class="form-control">
                                <option value="0" default>{{$payment[0]->customer_name }}</option>
                            </select>
                            @error('customer_name')
                                    <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        
                   </div>
            </div> 
        </div>
    </section>
</main>
@endsection