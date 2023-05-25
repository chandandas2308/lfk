@extends('pos.layout.master')
@section('title','Customer | POS')
@section('body')
<?php
// print_r($new);
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Customer</h1>
        <br>
    </div>
    @if(session()->has('message'))
    <div class="alert alert-success" id="alert">
        {{ session()->get('message') }}
        <!-- <button type="button" class="close" data-dismiss="alert">x</button> -->
    </div>
    @endif
   
    <div class="row">
        <div class="col-12">
        <div class="card">
                <div class="card-header">
                            <h5>Edit Customer</h5>
                        </div>
                  <div class="card-body">
                  
                  <form action="{{url('/pos/updatecustomer',$new->id)}}" method="post" enctype="multipart">
                @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="inputText" class="col-sm-5 col-form-label">Customer Name <span style="color:red;">*</span> :</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{$new->customer_name }}" class="form-control" >
                         
                                @error('customer_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                             <label for="inputText" class="col-sm-5 col-form-label">DOB :</label>
                            <input type="date" name="dob" id="dob" value="{{$new->dob}}" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="inputText" class="col-sm-5 col-form-label">Mobile Number <span style="color:red;">*</span>:</label>
                            <input type="number" name="mobile_number" id="mobile_number" value="{{$new->mobile_number }}" class="form-control">
                            @error('mobile_number')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                             <label for="inputText" class="col-sm-5 col-form-label">Email ID <span style="color:red;">*</span>:</label>
                            <input type="email" name="email_id" id="email_id" value="{{$new->email_id}}" class="form-control">
                            @error('email_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="inputText" class="col-sm-5 col-form-label">Phone Number:</label>
                            <input type="number" name="phone_number" id="phone_number" value="{{$new->phone_number}}" class="form-control">
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                             <label for="outletPostCode" class="col-sm-5 col-form-label">Postal Code:</label>
                            <input type="text" name="postcode" id="outletPostCode" value="{{$new->postal_code}}" class="form-control">
                            @error('postal_code')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="outlet_address" class="col-sm-5 col-form-label">Address:</label>
                            <select name="address" name="outlet_address" id="outlet_address" value="{{$new->outlet_address}}" class="form-control">
                                <option value="{{$new->address}}">{{$new->address}}</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                            <label for="outletUnitCode" class="col-sm-5 col-form-label">Unit:</label>
                            <input type="text" name="unitCode" id="unitCode" value="{{$new->unit}}" class="form-control">
                            @error('unitCode')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>
                   
                    <div class="mt-3" style="text-align:end !important;">
                               <button type="submit" class="bg-addbtn  mx-2 rounded">UPDATE</button> 
                               <a href="{{ url('pos/showcustomer') }}"  class="bg-addbtn  mx-2 rounded">BACK</a>
                              </div>
                </form>
                        
                         
    </div>
</div>
        </div>
    </div>
    <!-- <section class="section customer">
        <div class="row">
            <div class="col-12">
                <form action="{{url('/pos/updatecustomer',$new->id)}}" method="post" enctype="multipart">
                @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="inputText" class="col-sm-5 col-form-label">Customer Name <span style="color:red;">*</span> :</label>
                            <input type="text" name="customer_name" id="customer_name" value="{{$new->customer_name }}" class="form-control" >
                         
                                @error('customer_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                             <label for="inputText" class="col-sm-5 col-form-label">DOB :</label>
                            <input type="date" name="dob" id="dob" value="{{$new->dob}}" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="inputText" class="col-sm-5 col-form-label">Mobile Number <span style="color:red;">*</span>:</label>
                            <input type="number" name="mobile_number" id="mobile_number" value="{{$new->mobile_number }}" class="form-control">
                            @error('mobile_number')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                             <label for="inputText" class="col-sm-5 col-form-label">Email ID <span style="color:red;">*</span>:</label>
                            <input type="email" name="email_id" id="email_id" value="{{$new->email_id}}" class="form-control">
                            @error('email_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="inputText" class="col-sm-5 col-form-label">Phone Number:</label>
                            <input type="number" name="phone_number" id="phone_number" value="{{$new->phone_number}}" class="form-control">
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                             <label for="outletPostCode" class="col-sm-5 col-form-label">Postal Code:</label>
                            <input type="text" name="postcode" id="outletPostCode" value="{{$new->postal_code}}" class="form-control">
                            @error('postal_code')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="outlet_address" class="col-sm-5 col-form-label">Address:</label>
                            <select name="address" name="outlet_address" id="outlet_address" value="{{$new->outlet_address}}" class="form-control">
                                <option value="{{$new->address}}">{{$new->address}}</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                            <label for="outletUnitCode" class="col-sm-5 col-form-label">Unit:</label>
                            <input type="text" name="unitCode" id="unitCode" value="{{$new->unit}}" class="form-control">
                            @error('unitCode')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                    </div>
                    <br>
                    <div class="row mt-3 cust-btn">
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        <div class="col-sm-3">
                            <a href="{{ url('/pos/showcustomer') }}" class="btn btn-warning">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section> -->
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
     $(document).on('change', '#outletPostCode', function(){
        let postcode = $(this).val();

        jQuery.ajax({
            url: "https://developers.onemap.sg/commonapi/search",
            type: "get",
            data: {
                "searchVal" : postcode,
                "returnGeom" : 'N',
                "getAddrDetails" : 'Y',
            },
            success : function(response){
                $('#outlet_address').html('');
                $('#outlet_address').append('<option value="">Select Address</option>');
                $.each(response.results, function(key, value){
                    $('#outlet_address').append(`
                        <option value="${value["ADDRESS"]}">${value["ADDRESS"]}</option>
                    `);
                });
            }
        });
    });
</script>
@endsection()