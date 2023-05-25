@extends('pos.layout.master')
@section('title','Customer | POS')
@section('body')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Customer</h1>
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
                            <h5>Add Customer</h5>
                        </div>
                  <div class="card-body">
                  
                 <form action="" method="POST" id="CustomerStore">
                @csrf
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="inputText" class="col-sm-5 col-form-label">Customer Name<span style="color:red;">*</span></label>
                            <input type="text" name="customer_name" id="customer_name" value="{{old('customer_name')}}" class="form-control" >
                         
                                @error('customer_name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                             <label for="inputText" class="col-sm-5 col-form-label">DOB</label>
                            <input type="date" name="dob" id="dob" value="" class="form-control" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="inputText" class="col-sm-5 col-form-label">Mobile Number <span style="color:red;">*</span></label>
                            <input type="number" name="mobile_number" id="mobile_number" value="" class="form-control">
                            @error('mobile_number')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                             <label for="inputText" class="col-sm-5 col-form-label">Email ID<span style="color:red;">*</span></label>
                            <input type="email" name="email_id" id="email_id" value="{{old('email_id')}}" class="form-control">
                            @error('email_id')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <label for="inputText" class="col-sm-5 col-form-label">Phone Number</label>
                            <input type="number" name="phone_number" id="phone_number" value="{{old('phone_number')}}" class="form-control">
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                             <label for="outletPostCode" class="col-sm-5 col-form-label">Postal Code<span style="color:red;">*</span></label>
                            <input type="text" name="postcode" id="outletPostCode" value="" class="form-control">
                            @error('postcode')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                        <label for="outlet_address" class="col-sm-5 col-form-label">Address<span style="color:red;">*</span></label>
                            <select name="address"  id="outlet_address" class="form-control">
                                <option value="">Select Address</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                                        <label class="col-sm-5 col-form-label" for="outletUnitCode">Unit<span style="color:red;">*</span></label>
                                        <input type="text" name="unitCode" id="outletUnitCode" class="form-control" >
                                    </div>
                        </div>
                    </div>
                    <br>
                    <div style="text-align:end !important;">
                               <button type="submit" class="bg-addbtn  mx-2 rounded">SAVE</button> 
                               <button type="reset" id="clearOutletForm" class="bg-addbtn  mx-2 rounded">CANCEL</button>
                              </div>
                </form>
                        
                         
                          </div>
                        </div>
        </div>
    </div>

</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
        function hide()
        {
            document.get("alert").style.visibility="hidden";
        }
        setTimeout("hide", 3000);
</script>
<script>
$(document).on('click', '#clearOutletForm', function(){
        $('#CustomerStore')[0].reset();
    });

    $(document).ready(function(){
        jQuery('#CustomerStore').submit(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules:{
                name : {
                    required : true,
                },
                email : {
                    required : true,
                },
                mobile_number : {
                    required : true,
                },
                postcode : {
                    required : true,
                },
                address : {
                    required : true,
                },
                unitCode : {
                    required : true,
                },
            },
            message:{},
            submitHandler: function(){
                
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        const formData = new FormData($('#CustomerStore')["0"]);
                        jQuery.ajax({
                            url: "{{ route('Pos-Customer') }}",
                            enctype: "multipart/form-data",
                            type: "post",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(result) {
                                
                                if(result.success != null){
                                    jQuery("#CustomerStore")["0"].reset();
                                    toastr.success(result.success);
                                    // fetchAllOutletDetails();
                                    // $('#main .close').click();
                                    window.location.href="/pos/showcustomer/";
                                }else{
                                    toastr.error(result.error["email_id"]);    
                                }

                            }
                        });
                    }
                });
            }
        })
    });

    // 
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
@endsection