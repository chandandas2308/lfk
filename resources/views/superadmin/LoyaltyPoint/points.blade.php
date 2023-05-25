<div class="p-3">
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Loyalty Points
            </h4>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card text-dark bg-light mb-3" style="max-width: auto;">
                    <div class="card-header">
                        Points
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Todays Loyalty Point Value</h5>
                        <p class="card-text">$<span id="loyaltyPointAmount">1</span> = <span id="loyaltyTotalPoints">100</span> Points</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                    <!-- info & alert section -->
                    <div class="alert alert-success alert-dismissible fade show" id="addLoyaltyPoints" style="display:none" role="alert">
                        <strong></strong> <span id="addLoyaltyPointsMSG"></span>
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                <div class="card text-dark bg-light mb-3" style="max-width: auto;">
                    <div class="card-header">
                        Loyalty Point Conversion 
                    </div>
                    <div class="card-body">
                        <form id="loyaltySystemPointsForm" method="post">                        
                            <div class="form-group">
                                <label for="dollorValue" class="form-label">Price ($)<span style="color:red">*</span></label>
                                <input type="text" name="dollor" id="dollorValue" class="form-control" placeholder="Enter Value($)...">
                            </div>
                            <input type="text" name="prevAmount" id="prevAmount" style="display:none;" />
                            <div class="form-group">
                                <label for="loyaltyPoints" class="form-label">Total Points<span style="color:red">*</span></label>
                                <input type="text" name="loyaltyPoints" id="loyaltyPoints" class="form-control" placeholder="Enter Total Points...">
                            </div>
                            <input type="text" name="prevPoints" id="prevPoints" style="display:none;" />
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-tablist" id="loyaltySystemPointsFormClr">Clear</button>
                                <button type="submit" class="btn btn-primary btn-tablist" id="salesInvoiceForm1t">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>

    $('#loyaltySystemPointsFormClr').on('click', function(){
        $('#loyaltySystemPointsForm')["0"].reset();
        getAllLoyaltyPoints();
    });

    getAllLoyaltyPoints();
    function getAllLoyaltyPoints() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-FetchLoyaltyPoints')}}",
            success: function(response) {
                jQuery.each(response, function(key, value){
                    $('#loyaltyPointAmount').html(value['amount']);
                    $('#loyaltyTotalPoints').html(value['points']);

                    $('#prevAmount').val(value['amount']);
                    $('#prevPoints').val(value['points']);
                });
            }
        });
    }

    $(document).ready(function(){
        jQuery('#loyaltySystemPointsForm').submit(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules:{
                dollor : {
                    required : true,
                    number: true,
                },
                loyaltyPoints : {
                    required : true,
                    number: true,
                },
            },
            message:{},
            submitHandler: function(){
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        jQuery.ajax({
                            url: "{{ route('SA-StoreLoyaltyPoints') }}",
                            data: jQuery("#loyaltySystemPointsForm").serialize(),
                            enctype: "multipart/form-data",
                            type: "post",
                            success: function(result) {
                                
                                if(result.success != null){
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                            // jQuery("#addLoyaltyPointsMSG").html(result.success);
                                            // jQuery("#addLoyaltyPoints").show();
                                            jQuery("#loyaltySystemPointsForm")["0"].reset();
                                            getAllLoyaltyPoints();
                                }else{
                                    errorMsg(result);
                                    jQuery("#addLoyaltyPoints").hide();
                                }
                            }
                        });
                    }
                });
            }
        })
    });

</script>