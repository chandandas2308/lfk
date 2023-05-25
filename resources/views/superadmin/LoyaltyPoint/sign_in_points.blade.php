<div class="p-3">
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Welcome Points Setting
            </h4>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card text-dark bg-light mb-3" style="max-width: auto;">
                    <div class="card-header">
                        Points
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Welcome Bonus Points</h5>
                        <p class="card-text"><span id="bonusTotalPoints">0</span> Points</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-dark bg-light mb-3" style="max-width: auto;">
                    <div class="card-header">
                        Bonus Points 
                    </div>
                    <div class="card-body">
                        <form id="welcomeBonusPointsForm" method="post">
                            <input type="text" name="prevPoints" id="prevPoints1" style="display:none;" />
                            <div class="form-group">
                                <label for="bonusPoints" class="form-label">Total Points<span style="color:red">*</span></label>
                                <input type="text" name="bonusPoints" id="bonusPoints" class="form-control" placeholder="Enter Total Points...">
                            </div>
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
        $('#welcomeBonusPointsForm')["0"].reset();
        welcomeBonusPoints();
    });

    welcomeBonusPoints();
    function welcomeBonusPoints() {
        $.ajax({
            type: "GET",
            url: "{{ route('sign_in.create')}}",
            data:{
                status : 1,
            },
            success: function(response) {
                $('#bonusTotalPoints').html(response.points);
                $('#prevPoints1').val(response.points);
            }
        });
    }

    $(document).ready(function(){
        jQuery('#welcomeBonusPointsForm').submit(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules:{
                bonusPoints : {
                    required : true,
                    number: true,
                },
            },
            message:{},
            submitHandler: function(){
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        jQuery.ajax({
                            url: "{{ route('sign_in.store') }}",
                            data: jQuery("#welcomeBonusPointsForm").serialize(),
                            enctype: "multipart/form-data",
                            type: "post",
                            success: function(result) {
                                
                                if(result.success != null){
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                    jQuery("#welcomeBonusPointsForm")["0"].reset();
                                    welcomeBonusPoints();
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