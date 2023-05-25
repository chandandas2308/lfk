                <div class="content-wrapper pb-0 bg-white">
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="card text-dark bg-light mb-3" style="max-width: auto;">
                                        <div class="card-header">
                                            Live Date Configuration
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Live Date & Time</h5>
                                            <p class="card-text"><span id="consolidateDateValueView">00-00-0000</span></p>
                                            <h5 class="card-title">Live Link</h5>
                                            <p class="card-text"><span id="consolidateMessageView">Message</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">                        
                                    <div class="card text-dark bg-light" style="max-width: auto;">
                                        <div class="card-header">
                                            Config Manual Date & Time
                                        </div>
                                        <div class="card-body bg-white">
                                            <form id="localDateTimeConfigForm" method="post">
                                                <!--  -->
                                                <div class="form-group my-4">
                                                    <label for="dateInput">Date & Time</label>
                                                    <input type="datetime-local" id="dateInput" name="date" class="form-control" placeholder="..." required />
                                                </div>
                                                <!--  -->
                                                <input type="hidden" id="prevDate" name="prevDate" />
                                                <!--  -->
                                                <div class="form-group my-4">
                                                    <label for="message">Live Link</label>
                                                    <textarea name="message" id="message" class="form-control" placeholder="Add Live Link..." required ></textarea>
                                                </div>
                                                <!--  -->
                                                <input type="hidden" id="prevMessage" name="prevMessage" />
                                                <!--  -->
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary btn-tablist" id="ConfigDateTimeFormClr">Clear</button>
                                                    <button type="submit" id="salesInvoiceForm1" class="btn btn-primary btn-tablist">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
            <!-- </div> -->

            <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
     $('#ConfigDateTimeFormClr').on('click', function(){
        $('#localDateTimeConfigForm')["0"].reset();
        getConsolidateConfig();
    });

    getLocalDateTimeConfig();

    function getLocalDateTimeConfig() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-FetchLiveDateConfiguration')}}",
            success: function(response) {
                jQuery.each(response, function(key, value){
                    $('#consolidateDateValueView').html(value['date']);
                    $('#consolidateMessageView').html(value['message']);
                    $('#prevDate').val(value['date']);
                    // $('#dateInput').val(value['date']);
                    $('#prevMessage').val(value['message']);
                    // $('#message').val(value['message']);
                });
            }
        });
    }

    $(document).ready(function(){
        // configuration live date and time with message to db
        jQuery('#localDateTimeConfigForm').submit(function(e){

            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules:{
                date : {
                    required : true,
                },
                message : {
                    required : true,
                    url : true,
                }
            },
            message:{},
            submitHandler: function(){
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        jQuery.ajax({
                            url: "{{ route('SA-UpdateLiveDateConfiguration') }}",
                            data: jQuery("#localDateTimeConfigForm").serialize(),
                            enctype: "multipart/form-data",
                            type: "post",
                            success: function(result) {
                                
                                if(result.success != null){
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                    jQuery("#localDateTimeConfigForm")["0"].reset();
                                    getLocalDateTimeConfig();
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