@section('title','Configguration | LFK')
@include('superadmin.layouts.header')
@include('superadmin.layouts.aside')
@include('superadmin.layouts.nav')

<body onload="init()">

<!-- sales css file -->
<link rel="stylesheet" href="{{ asset('inventorybackend/css/style.css')}}" />

    <div class="main-panel">
        <div class="content-wrapper pb-0 bg-white tabs">
            <div role="tablist" aria-label="Programming Languages">
                <button role="tab" aria-selected="true" class="btn btn-primary btn-sm" id="consolidateConfig">
                    Consolidate Setting
                </button>
                <!-- <button role="tab" aria-selected="false" class="btn btn-primary btn-sm" id="liveDateConfig">
                    Live Date 
                </button> -->
            </div>
            <div role="tabpanel" aria-labelledby="consolidateConfig">
                <!-- <div class="main-panel"> -->
                    <div class="content-wrapper pb-0 bg-white">
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="card text-dark bg-light mb-3" style="max-width: auto;">
                                        <div class="card-header">
                                            Consolidate Order Configuration
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Consolidate Order Time</h5>
                                            <p class="card-text"><span id="consolidateDayValueView">0</span> Day</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">                        
                                    <div class="card text-dark bg-light" style="max-width: auto;">
                                        <div class="card-header">
                                            Config Manual Day
                                        </div>
                                        <div class="card-body">
                                            <form id="consolidateConfig1" method="post">
                                                <div class="form-group my-4">
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-sm btn-facebook" type="button">
                                                                Day
                                                            </button>
                                                        </div>
                                                        <input type="number" id="dayInput" name="day" class="form-control" placeholder="Enter Day..." required />
                                                    </div>
                                                </div>
                                                <input type="hidden" id="prevDay" name="prevDay" />
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary btn-tablist" id="loyaltySystemPointsFormClr">Clear</button>
                                                    <button type="submit" class="btn btn-primary btn-tablist" id="salesInvoiceForm1">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                <!-- </div> -->
            </div>
        </div>
    <!-- </div> -->

<!-- sales js file -->
<script src="{{ asset('inventorybackend/js/action.js')}}"></script>

</body>
@include('superadmin.layouts.footer')

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>

    $('#loyaltySystemPointsFormClr').on('click', function(){
        $('#consolidateConfig1')["0"].reset();
        getConsolidateConfig();
    });

    // 
    getConsolidateConfig();
    
    // 

    function getConsolidateConfig() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-FetchConsolidateConfiguration')}}",
            success: function(response) {
                jQuery.each(response, function(key, value){
                    $('#consolidateDayValueView').html(value['day']);
                    $('#prevDay').val(value['day']);
                });
            }
        });
    }

    // $(document).ready(function(){
        jQuery('#consolidateConfig1').submit(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules:{
                day : {
                    required : true,
                    number: true,
                    min : 1,
                },
            },
            message:{},
            submitHandler: function(){
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        jQuery.ajax({
                            url: "{{ route('SA-UpdateConfiguration') }}",
                            data: jQuery("#consolidateConfig1").serialize(),
                            enctype: "multipart/form-data",
                            type: "post",
                            success: function(result) {                                
                                if(result.success != null){
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                            // jQuery("#addLoyaltyPointsMSG").html(result.success);
                                            // jQuery("#addLoyaltyPoints").show();
                                            jQuery("#consolidateConfig1")["0"].reset();
                                            getConsolidateConfig();
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

        // ===================================================================================================================================================
        // ===================================================================================================================================================
        // ===================================================================================================================================================

    //     // configuration live date and time with message to db
    //     jQuery('#localDateTimeConfigForm').submit(function(e){
    //         e.preventDefault();

    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //             },
    //         });
    //     }).validate({
    //         rules:{
    //             date : {
    //                 required : true,
    //             },
    //             message : {
    //                 required : true,
    //             }
    //         },
    //         message:{},
    //         submitHandler: function(){
    //             bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
    //                 if(result){
    //                     jQuery.ajax({
    //                         url: "{{ route('SA-UpdateLiveDateConfiguration') }}",
    //                         data: jQuery("#localDateTimeConfigForm").serialize(),
    //                         enctype: "multipart/form-data",
    //                         type: "post",
    //                         success: function(result) {
                                
    //                             if(result.success != null){
    //                                 successMsg(result.success);
    //                                 $('.modal .close').click();
    //                                         // jQuery("#addLoyaltyPointsMSG").html(result.success);
    //                                         // jQuery("#addLoyaltyPoints").show();
    //                                         jQuery("#localDateTimeConfigForm")["0"].reset();
    //                                         getLocalDateTimeConfig();
    //                             }else{
    //                                 errorMsg(result);
    //                                 jQuery("#addLoyaltyPoints").hide();
    //                             }
    //                         }
    //                     });
    //                 }
    //             });
    //         }
    //     })
    // });

</script>