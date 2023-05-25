    <!-- Stock Tracking Tab -->
    <div class="p-3">
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Stock Tracking
            </h4>
        </div>
        <!-- <div class="table-responsive"> -->
        <table class="text-center table table-responsive table-bordered" id="stockTrackingTable">
            <thead>
                <tr>
                    <th class="text-center">S/N</th>
                    <th class="text-center">Vendor/Customer</th>
                    <th class="text-center">Invoice Date</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
        </table>
        <!-- </div> -->
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- backend js file -->

    @include('superadmin.inventory.stock-tracking-modal.viewProducts')

    <script>
        $(document).ready(function() {
            stockTrackingTable = $('#stockTrackingTable').DataTable({
                "aaSorting": [],
                "bDestroy": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: false,
                // "scrollX": true,
                dom: "Bfrtip",
                pageLength: 10,
                buttons: [],
                ajax: {
                    url: "{{ route('SA-FetchStockTrackingDetails') }}",
                    type: 'GET',
                },
            });
            $(document).find('#stockTrackingTable').wrap('<div style="overflow-x:auto; width:100%;"></div>')
        });

        //     $('document').ready(function(){

        //         getStockTrackingDetials();

        //         $('#resetREFilterStockTracking').click(function(){
        //             getStockTrackingDetials();
        //         })
        //     });
        // function getStockTrackingDetials(){
        //     $('document').ready(function (){
        //         $.ajax({
        //             type : "GET" ,
        //             url : "{{ route('SA-FetchStockTrackingDetails') }}",
        //             success : function (response){
        //                 jQuery('.stock-tracking-details').html('');
        //                 $('.stock-tracking-main-table').html('Total no. of Stock Tracking : '+response.total);
        //                 jQuery.each(response.data, function (key, value){
        //                     let countRow = $('#stockTrackingTable tr').length;

        //                         $('.stock-tracking-details').append(
        //                         '<tr>\
        //                             <td class="border border-secondary">'+ countRow +'</td>'+
        //                             '<td class="border border-secondary">'+ value["name"] +'</td>'+
        //                             '<td class="border border-secondary">'+ value["receipt_date"] +'</td>'+
        //                             '<td class="border border-secondary">'+ value["status"] +'</td>\
        //                             <td class="border border-secondary">'+
        //                                 '<button data-toggle="modal" class="bg-primary text-black" id="stockTrackingModalPopBtn" onclick="fetchProducts('+ value["id"] +')" data-target="#viewProducts" >View Products</button>'+
        //                             '</td>\
        //                         </tr>'
        //                         );
        //                 });

        //                 $('.stock-tracking-pagination-refs').html('');
        //                             jQuery.each(response.links, function (key, value){
        //                                 $('.stock-tracking-pagination-refs').append(
        //                                     '<li id="stock_tracking_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
        //                                 );
        //                 });

        //             }
        //         });
        //     });

        //     // pagination links css and access page
        //     $(function() {
        //       $(document).on("click", "#stock_tracking_pagination a", function() {
        //         //get url and make final url for ajax 
        //         var url = $(this).attr("href");
        //         var append = url.indexOf("?") == -1 ? "?" : "&";
        //         var finalURL = url + append;

        //         $.get(finalURL, function(response) {
        //             let i = response.from;
        //             jQuery('.stock-tracking-details').html('');
        //             $('.stock-tracking-main-table').html('Total no. of Stock Tracking : '+response.total);
        //                 jQuery.each(response.data, function (key, value){

        //                     // let countRow = $('#stockTrackingTable tr').length;

        //                     $('.stock-tracking-details').append(
        //                         '<tr>\
        //                             <td class="border border-secondary">'+ i++  +'</td>'+
        //                             '<td class="border border-secondary">'+ value["name"] +'</td>'+
        //                             '<td class="border border-secondary">'+ value["receipt_date"] +'</td>'+
        //                             '<td class="border border-secondary">'+ value["status"] +'</td>\
        //                             <td class="border border-secondary">'+
        //                                 '<button data-toggle="modal" onclick="fetchProducts('+ value["id"] +')" data-target="#viewProducts" >View Products</button>'+
        //                             '</td>\
        //                         </tr>'
        //                     );
        //                 });

        //             $('.stock-tracking-pagination-refs').html('');
        //             jQuery.each(response.links, function (key, value){
        //                 $('.stock-tracking-pagination-refs').append(
        //                                     '<li id="stock_tracking_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
        //                                 );
        //                 });
        //             });
        //             return false;
        //         });
        //     });
        //     // end here
        // }


        // view products detials
        function fetchProducts(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-FetchStockProductsDetails') }}",
                data: {
                    'id': id
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#customerName').val(value['name'])
                        $('#statusTracking').val(value['status'])

                        jQuery('.stock-tracking-details-view').html('');

                        let obj = JSON.parse(value["products"]);

                        jQuery.each(obj, function(k, v) {
                            let slno = $('#stockTrackingTableView tr').length;
                            $('.stock-tracking-details-view').append(
                                '<tr>\
                            <td class="border border-secondary">' + slno + '</td>' +
                                '<td class="border border-secondary">' + v["product_name"] + '</td>' +
                                '<td class="border border-secondary">' + v["product_varient"] + '</td>' +
                                '<td class="border border-secondary">' + v["quantity"] + '</td>\
                        </tr>'
                            );
                        });
                    });
                }
            });
        }


        // All Filter Stock Tracking Details
        function stockTrackingFilter() {

            let user = jQuery('#stockTrackingFilter').val();

            $.ajax({
                type: "GET",
                url: "{{ route('SA-FetchStockProductsDetailsFilter') }}",
                data: {
                    "user": user
                },
                success: function(response) {

                    console.log(response);

                    jQuery('.stock-tracking-details').html('');
                    $('.stock-tracking-main-table').html('Total no. of Stock Tracking : ' + response.total);
                    jQuery.each(response.data, function(key, value) {
                        let countRow = $('#stockTrackingTable tr').length;

                        $('.stock-tracking-details').append(
                            '<tr>\
                            <td class="border border-secondary">' + countRow + '</td>' +
                            '<td class="border border-secondary">' + value["name"] + '</td>' +
                            '<td class="border border-secondary">' + value["receipt_date"] + '</td>' +
                            '<td class="border border-secondary">' + value["status"] + '</td>\
                            <td class="border border-secondary">' +
                            '<button data-toggle="modal" class="bg-primary text-white" id="stockTrackingModalPopBtn" onclick="fetchProducts(' + value["id"] + ')" data-target="#viewProducts" >View Products</button>' +
                            '</td>\
                        </tr>'
                        );
                    });

                    $('.stock-tracking-pagination-refs').html('');
                    jQuery.each(response.links, function(key, value) {
                        $('.stock-tracking-pagination-refs').append(
                            '<li id="search_stock_tracking_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
                        );
                    });
                }
            });

            // pagination links css and access page
            $(function() {
                $(document).on("click", "#search_stock_tracking_pagination a", function() {
                    //get url and make final url for ajax 
                    var url = $(this).attr("href");
                    var append = url.indexOf("?") == -1 ? "?" : "&";
                    var finalURL = url + append;

                    $.get(finalURL, function(response) {
                        let i = 0;
                        jQuery('.stock-tracking-details').html('');
                        $('.stock-tracking-main-table').html('Total no. of Stock Tracking : ' + response.total);
                        jQuery.each(response.data, function(key, value) {

                            let countRow = $('#stockTrackingTable tr').length;

                            $('.stock-tracking-details').append(
                                '<tr>\
                            <td class="border border-secondary">' + countRow + '</td>' +
                                '<td class="border border-secondary">' + value["name"] + '</td>' +
                                '<td class="border border-secondary">' + value["receipt_date"] + '</td>' +
                                '<td class="border border-secondary">' + value["status"] + '</td>\
                            <td class="border border-secondary">' +
                                '<button data-toggle="modal" onclick="fetchProducts(' + value["id"] + ')" data-target="#viewProducts" >View Products</button>' +
                                '</td>\
                        </tr>'
                            );
                        });

                        $('.stock-tracking-pagination-refs').html('');
                        jQuery.each(response.links, function(key, value) {
                            $('.stock-tracking-pagination-refs').append(
                                '<li id="search_stock_tracking_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
                            );
                        });
                    });
                    return false;
                });
            });
            // end here
        }


        $(document).on("click", "a[name = 'deleteCat']", function(e) {
            let id = $(this).data("id");
            $('#confirmRemoveSelectedElementCat').data('id', id);
        });
    </script>


    <div class="modal fade" id="removeModalCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Alert</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">DO YOU WANT TO DELETE?<span id="removeElementId"></span> </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                    <a name="removeConfirmCategory" class="btn btn-primary" id="confirmRemoveSelectedElementCat">
                        YES
                    </a>
                </div>
            </div>
        </div>
    </div>