<!-- <style>
    .dt-head-center {text-align: center !important;}
    thead, th, td {text-align: center !important;}
    .dataTables_filter {
        display: none;
        }
</style>

<div class="modal fade" id="posStock" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="BlogLongTitle">Stock Management</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body bg-white px-3">
                            <div class="page-header flex-wrap mx-3" >
                                <div class="d-flex">
                                    <a class="btn-sm btn-primary" id="addStockBtnId" data-toggle="modal" data-target="#addStock" href="javascript:void(0)">ADD STOCK</a>
                                </div>
                            </div>
                            <div class="responsive">
                                <table class="table" id="outletStockTable">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Product Name</th>
                                            <th>Product Variant</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="outletStockTableBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>
                </div>
            </div>
        </div> -->

<script>

// function getAllOutletStockDetails(id){
//     jQuery.ajax({
//         url: "{{ route('SA-FetchAllOutletStockDetails') }}",
//         type: "get",
//         data: {
//             "id" : id,
//         },
//         success : function(response){
//             let i = 0;
//                 $('#outletStockTable').DataTable().clear().destroy();
//                 $('#outletStockTable').DataTable( {
//                     data: response,
//                     columns: [
//                         { data: null,
//                             render: function ( data, type, row ) {
//                                 return ++i;
//                             }
//                         },
//                         { data: 'product_name' },
//                         { data: 'product_varient' },
//                         { data: 'unit_price' },
//                         { data: 'quantity' },
//                         { data: null,
//                             render: function ( data, type, row ) {
//                                 return `
//                                         <a name="updateOutletStockInfo" href="javascript:void(0)" data-toggle="modal" data-target="#updateStock" data-id="${data["id"]}" > <i class="mdi mdi-pencil"></i> </a>
//                                         |
//                                         <a name="removeOutletStockInfo" href="javascript:void(0)" data-id="${data["id"]}"> <i class="mdi mdi-delete"></i> </a>
//                                     `;
//                             }
//                         }
//                     ]
//                 } );
//         }
//     });
// }

$(document).on('click', 'a[name="updateOutletStockInfo"]', function(key, value){
    $id = $(this).data('id');
    
    jQuery.ajax({
        url: "{{ route('SA-FetchSingleOutletStockDetails') }}",
        type: "get",
        data: {
            "id" : $id,
        },
        success : function(response){
            $('#updateStockId').val(response[0]["id"]);
            $('#update_posStockPName').val(response[0]["product_name"]);
            // getUpdateVariantName(response[0]["product_name"]);
            $('#update_posStockVariant').val(response[0]["product_varient"]);
            $('#update_pos_stock_unit_price').val(response[0]["unit_price"]);
            $('#update_posStockQuantity').val(response[0]["quantity"]);
            
        }
    });

});

$(document).on('click', 'a[name="removeOutletStockInfo"]', function(key, value){
    $id = $(this).data('id');
    
    bootbox.confirm("DO YOU WANT TO DELETE?", function(result) {
        if(result){
            jQuery.ajax({
                url: "{{ route('SA-OutletRemoveStock') }}",
                type: "get",
                data: {
                    "id" : $id,
                },
                success : function(response){
                    if(response.success != null){
                        successMsg(response.success);
                        getAllOutletStockDetails($('#addStockOwnerId').val());
                    }else{
                        errorMsg(response.error);
                    }
                }
            });
        }
    });
});


</script>