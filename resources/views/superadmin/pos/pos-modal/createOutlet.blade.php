<div class="modal fade" id="addOutlet" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="BlogLongTitle">Add Outlet</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data" id="storeOutlet">
                        @csrf
                        <div class="modal-body bg-white px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="outletName">Outlet Name<span style="color:red;">*</span></label>
                                        <input type="text" name="name" class="form-control" id="outletName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="outletEmail">Email ID<span style="color:red;">*</span></label>
                                        <input type="email" name="email" class="form-control" id="outletEmail" placeholder="Email ID">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="outletPassword">Password<span style="color:red;">*</span></label>
                                        <input type="text" name="password" class="form-control" id="outletPassword" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="outlet_mobile_number">Mobile Number<span style="color:red;">*</span></label>
                                        <input type="tel" name="mobile_number" class="form-control" id="outlet_mobile_number" placeholder="Mobile Number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="outletPostCode">Postcode<span style="color:red;">*</span></label>
                                        <input type="text" name="postcode" class="form-control" id="outletPostCode" placeholder="Postcode">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="outlet_address">Address<span style="color:red;">*</span></label>
                                        <!-- <select name="address" id="outlet_address" class="form-control">
                                            <option value="">Select Address</option>
                                        </select> -->
                                        <textarea name="address" id="outlet_address" placeholder="Address" class="form-control" readonly></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="outletUnitCode">Unit<span style="color:red;">*</span></label>
                                        <input type="text" name="unitCode" id="outletUnitCode" class="form-control" placeholder="unit">
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="clearOutletForm" >Clear</button>
                            <button type="submit" value="Submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    
        <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>


    $(document).on('click', '#clearOutletForm', function(){
        $('#storeOutlet')[0].reset();
    });

    $(document).ready(function(){
        jQuery('#storeOutlet').submit(function(e){
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
                password : {
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
                        const formData = new FormData($('#storeOutlet')["0"]);
                        jQuery.ajax({
                            url: "{{ route('SA-PosStoreOutlet') }}",
                            enctype: "multipart/form-data",
                            type: "post",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(result) {
                                
                                if(result.success != null){
                                    jQuery("#storeOutlet")["0"].reset();
                                    successMsg(result.success);
                                    outlet_table_caption.ajax.reload();
                                    $('#addOutlet .close').click();
                                }else{
                                    errorMsg(result.error);    
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

        if(postcode.length == 6){

        

        jQuery.ajax({
            url: "{{route('user.postaladdresses')}}",
                type: "get",
                data: {
                    postalcode: $(this).val()
                },

                beforeSend: function() {
                    $('#outlet_address').val('Loading...');
                },
            success : function(response){
                if(JSON.parse(response).found == 0) {
                    $('#outlet_address').val('');
                    $('#outletPostCode').val('');
                    toastr.error('Please Enter Valid Postal Code');

                }else{
                    $('#outlet_address').val(JSON.parse(response).results[0].ADDRESS);

                }
            }
        });
    }else{
        toastr.error('Please  Enter 6 Digits Postal Code');
    }
    });


</script>