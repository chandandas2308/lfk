<div class="">
    <h5 class="bg-primary px-3 py-2 text-white text-center">Return Goods Warehouse</h5>
    <!-- table start -->
    <!-- <div class="table-responsive"> -->
            <table class="text-center table table-responsive table-bordered" id="return_goods_main_table">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">User Name</th>
                        <th class="text-center">Invoice Date</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Unit Price</th>
                    </tr>
                </thead>
            </table>
        <!-- </div> -->
</div>

<script>

    $(document).ready(function() {
        return_goods_main_table = $('#return_goods_main_table').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength:10,
            buttons: [],
            ajax: {
                url: "{{ route('SA-GetReturnGoodsWarehouseDetails') }}",
                type: 'GET',
                data : {
                    "type" : "return",
                },
            }
        });
        $(document).find('#return_goods_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>')
    });  

    // jQuery(document).ready(function (){
    //     getReturnGoodsWarehouseDetials();
    // });

    // // All warehouse details Details
    // function getReturnGoodsWarehouseDetials(){
    //     $.ajax({
    //         type : "GET" ,
    //         url : "{{ route('SA-GetReturnGoodsWarehouseDetails') }}",
    //         data : {
    //             "type" : "return",
    //         },
    //             success : function (response){
    //             let i = 0;
    //             jQuery('.return-goods-warehouse-details').html('');
    //             $('.return-goods-main-table').html('Total No. of Return Goods : '+response.total);
    //             jQuery.each(response.data, function (key, value){
    //                 $('.return-goods-warehouse-details').append('<tr>\
    //                     <td class="border border-secondary">'+ ++i +'</td>\
    //                     <td class="border border-secondary">'+ value["user_name"] +'</td>\
    //                     <td class="border border-secondary">'+ value["invoice_date"] +'</td>\
    //                     <td class="border border-secondary">'+ value["product_name"] +'</td>\
    //                     <td class="border border-secondary">'+ value["quantityRAC"] +'</td>\
    //                     <td class="border border-secondary">'+ value["unit_price"] +'</td>\
    //                 </tr>');
    //             });

    //             $('.return-goods-warehouse-pagination-refs').html('');
    //                         jQuery.each(response.links, function (key, value){
    //                             $('.return-goods-warehouse-pagination-refs').append(
    //                                 '<li id="warehouse_paginationreturn" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
    //                             );
    //             });

    //         }

    //     });
    // }
    // // End function here

    // // pagination links css and access page
    // $(function() {
    //   $(document).on("click", "#warehouse_paginationreturn a", function() {
    //     //get url and make final url for ajax 
    //     var url = $(this).attr("href");
    //     var append = url.indexOf("?") == -1 ? "?" : "&";
    //     var finalURL = url + append;

    //     $.get(finalURL, function(response) {
    //         let i = response.from;
    //         jQuery('.return-goods-warehouse-details').html('');
    //         $('.return-goods-main-table').html('Total No. of Return Goods : '+response.total);
    //             jQuery.each(response.data, function (key, value){
    //                 $('.return-goods-warehouse-details').append('<tr>\
    //                     <td class="border border-secondary">'+ i++ +'</td>\
    //                     <td class="border border-secondary">'+ value["user_name"] +'</td>\
    //                     <td class="border border-secondary">'+ value["invoice_date"] +'</td>\
    //                     <td class="border border-secondary">'+ value["product_name"] +'</td>\
    //                     <td class="border border-secondary">'+ value["quantityRAC"] +'</td>\
    //                     <td class="border border-secondary">'+ value["unit_price"] +'</td>\
    //                 </tr>');
    //             });

    //         $('.return-goods-warehouse-pagination-refs').html('');
    //         jQuery.each(response.links, function (key, value){
    //                 $('.return-goods-warehouse-pagination-refs').append(
    //                     '<li id="warehouse_paginationreturn" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
    //                 );
    //             });
    //         });
    //         return false;
    //     });
    // });
    // end here
</script>