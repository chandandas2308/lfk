<div class="p-3">
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Top Selling Products
            </h4>
        </div>
        <!-- alert section -->
            <div class="alert alert-success" id="delInvoiceAlert" style="display:none"></div>
        <!-- alert section end-->

        <!-- table start -->
        <div class="table-responsive">
            <table class="text-center table table-responsive table-bordered">
                <caption class="sales-invoice-main-table"></caption>
                <thead class="fw-bold text-dark">
                    <tr>
                        <th class=" border border-secondary">S/N</th>
                        <th class=" border border-secondary">Product Id</th>
                        <th class=" border border-secondary">Product Name</th>
                        <th class=" border border-secondary">Item Sold</th>
                        <th class=" border border-secondary">Total Revenue</th>
                    </tr>
                </thead>
                <tbody class="tbody invoice-list">

                </tbody>
            </table>
        </div>  
        <!-- table end here -->
</div>

<!-- jQuery CDN -->
<script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
      integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
<!-- backend js file -->

<script>
    jQuery(document).ready(function (){
        updateInvoice();
    });

    // All Product Details
    function updateInvoice(){
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-InvoiceList') }}",
            success : function (response){
                let i = 0;
                jQuery('.invoice-list').html('');
                $('.sales-invoice-main-table').html('Total Invoices : '+response.total);
                var productId = [];
                jQuery.each(response.data, function (key, value){
                    var products_details = value["products"];
                        var parsed = JSON.parse(products_details);
                        var products = parsed[0];
                        productId.push(products.product_Id);                       
                });

                let final = [];
                for(var t = 0; t<productId.length; t++){
                    let total_quantity = 0;
                    let total_revenu = 0;
                    let p_name ;
                    jQuery.each(response.data, function (key, value){
                        var products_details = value["products"];
                        var parsed = JSON.parse(products_details);
                        var products = parsed[0];
                        
                        if(products.product_Id == productId[t]){
                            var q = products.quantity;
                            var tax = value["total"];
                            productidis = productId[t];
                            total_quantity += parseInt(q);
                            total_revenu += parseInt(tax);
                            p_name = products.product_name;
                        }
                    });
                    
                    var obj = {
                        "product_id":productidis,
                        "quantity":total_quantity,
                        "revenu":total_revenu,
                        "product_name":p_name,
                    };
                    final.push(obj);
                    
                    var newArray = [];

                    $.each(final, function(key, value) {
                        var exists = false;
                        $.each(newArray, function(k, val2) {
                            if(value.product_id == val2.product_id){ exists = true };
                             
                        });
                        if(exists == false && value.product_id != "") { newArray.push(value); }
                        
                    });
                }
                $.uniqueSort(productId);
                //console.log('final array');
                //console.log(newArray);
                $.each(newArray, function(new_key, new_value){
                    $('.invoice-list').append('<tr>\
                        <td class=" border border-secondary">'+ ++i +'</td>\
                        <td class=" border border-secondary">'+new_value["product_id"]+'</td>\
                        <td class=" border border-secondary">'+new_value["product_name"]+'</td>\
                        <td class=" border border-secondary">'+new_value["quantity"]+'</td>\
                        <td class=" border border-secondary">'+new_value["revenu"]+'</td>\
                    </tr>'); 
                });


            }
        });
    }
    // End function here



</script>