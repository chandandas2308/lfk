<!-- Modal -->
<div class="modal fade" id="addSpecialPrice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Special Price</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="addSpecialPriceForm">
        <div class="modal-body bg-white px-3">

                  <div class="alert alert-success alert-dismissible fade show" id="specialPriceAlert" style="display:none" role="alert">
                    <strong>Info ! </strong> <span id="specialPriceAlertContent"></span>
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <div class="card">
                  <div class="card-body">

                    <!-- row 1 -->
                  <div class="form-group row">
                      <div class="col-md-4 form-group">
                          <label for="special_price_customer_id">Customer Id</label><br>
                          <input type="text" name="customer_id" class="form-control" id="special_price_customer_id" placeholder="Customer Id"  style="display: none;" />
                          <input type="text" name="customer_id_1" class="form-control" id="special_price_customer_id1" placeholder="Customer Id" disabled />
                      </div>
                      <div class="col-md-4 form-group">
                        <label for="special_price_customer_name">Customer Name</label><br>
                        <input type="text" name="customer_name" class="form-control" id="special_price_customer_name" placeholder="Customer Name" disabled />
                      </div>
                      <div class="col-md-4 form-group">
                        <label for="special_price_customer_email">Customer Email ID</label><br>
                        <input type="text" name="customer_email" class="form-control" id="special_price_customer_email" placeholder="Customer Email" disabled />
                      </div>
                  </div>

                  <div class="alert alert-danger alert-dismissible fade show" id="specialPriceAlertTableDB" style="display:none" role="alert">
                    <strong>Info ! </strong> <span id="specialPriceAlertTableDBContent"></span>
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <!-- row 2 -->
                  <div class="form-group row">
                    <div class="col">
                        <fieldset class="border border-secondary p-2">
                            <legend class="float-none w-auto p-2">Product Details</legend>
                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table border" id="products">
                                        <thead class="text-center">
                                            <tr>
                                                <th rowspan="2" class="border border-secondary">Product</th>
                                                <!-- <th class="border border-secondary">Id</th> -->
                                                <th rowspan="2" class="border border-secondary">Category</th>
                                                <th rowspan="2" class="border border-secondary">Variant</th>
                                                <th rowspan="2" class="border border-secondary">Unit Price</th>
                                                <th colspan="3" class="border border-secondary">Special Price</th>
                                            </tr>
                                            <tr>
                                                <th class="border border-secondary">Discount Value</th>
                                                <th class="border border-secondary">Final Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="invoiceBody">
                                            <tr>
                                              <form id="addProductForm0">
                                                <!-- product -->
                                                <td class="border border-secondary">
                                                    <select id="productNameSpecialPrice" onchange="selectFunctionSpecialPrice()" class="form-control form-control-lg"></select>
                                                </td>
                                                <!-- productId -->
                                                <!-- Hide content -->
                                                <td class="border border-secondary" style="display: none;">
                                                    <input type="text"  id="productId" class="form-control" placeholder="Id">
                                                    <input type="text"  id="productNameOrder1" class="form-control" placeholder="Id">
                                                </td>
                                                <!-- category -->
                                                <td class="border border-secondary">
                                                    <input type="text" id="categoryOrder" class="form-control" placeholder="Category" disabled />
                                                </td>
                                                <!-- varient -->
                                                <td class="border border-secondary">
                                                    <!-- <input type="text"  id="varientOrder" class="form-control" placeholder="Varient" disabled /> -->
                                                    <select id="varientOrder" class="form-control" onchange="selectVarientSpecialPrice()"></select>
                                                </td>
                                                <td class="border border-secondary" style="display: none;">
                                                    <input type="text"  id="sku_code" class="form-control" placeholder="Varient" disabled />
                                                    <input type="text"  id="batch_code" class="form-control" placeholder="batch code" disabled />
                                                </td>

                                                <!-- unit price -->
                                                <td class="border border-secondary">
                                                    <input type="number" id="unitPriceOrder" class="form-control" placeholder="Unit Price" disabled />
                                                </td>
                                                <!-- special price -->
                                                <!-- <td class="border border-secondary">
                                                    <input type="number" id="subTotalOrderByPercentage" class="form-control" placeholder="Special Price" disabled>
                                                </td> -->
                                                <td class="border border-secondary">
                                                    <input type="number" id="subTotalOrderByAmount" class="form-control" placeholder="Amount" />
                                                </td>
                                                <!-- <td class="border border-secondary">
                                                    <input type="number" id="discount" class="form-control" placeholder="Special Price" readonly>
                                                </td> -->
                                                <td class="border border-secondary">
                                                    <input type="number" id="subTotalOrder" class="form-control" placeholder="Special Price" readonly>
                                                </td>
                                              </form>
                                            </tr>
                                            <tr>
                                                <td >
                                                    <a  id="addSpecialPriceTable" class="btn btn-primary text-white">Add Product</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table text-center border productsTableSpecialPrice" id="productsTableSpecialPrice">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>      
                                                <th>Product ID</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Variant</th>
                                                <th>Unit Price ($)</th>
                                                <th>Special Price ($)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productTableSpecialPrice" class="productTableSpecialPrice"></tbody>
                                    </table>
                                </div>
                        </fieldset>
                    </div>                
                </div> 

                  </div>
                </div>
                
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" >Clear</button>
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
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

<script>

  $('#varientOrder').attr('disabled', true);

  $('#subTotalOrderByAmount').on('keyup', function(){
    let amount = $(this).val();
    let unitPrice = $('#unitPriceOrder').val();
    let discount = amount;
    // $('#discount').val(discount);
    $('#subTotalOrder').val(unitPrice-discount);
  });


    getProductforSpecialPrice();

    function getProductforSpecialPrice(){
        $.ajax({
            type : "GET",
            url : "{{ route('SA-GetAllProducts')}}",
            success : function (response){
              console.log(response);
                $('#productNameSpecialPrice').append('<option value="">Select Product</option>');
                jQuery.each(response, function(key, value){
                    $('#productNameSpecialPrice').append(
                        '<option value="'+value["product_name"]+'">\
                        '+value["product_name"]+'\
                        </option>'
                    );
                });
            }
        });
      }

      let specialPriceProducts = [];

          function selectFunctionSpecialPrice(){
            let id = this.event.target.id;
            let pro = $('#'+id).val();
            getProduct(pro, id);

            // get single product details
            function getProduct(pro, id){
                $.ajax({
                    type : "GET",
                    url : "{{ route('SA-GetProductInfo')}}",
                    data : {
                        "pro" : pro
                    },
                    success : function (response){

                      console.log(response);
                      specialPriceProducts = response;

                      $('#varientOrder').html('');
                      $('#varientOrder').append('<option value="">Select Variant...</option>');
                        jQuery.each(response, function(key, value){
                            // product id
                            $('#'+id).closest('tr').find("input[id='productId']").val(value["id"]);
                            // productNameOrder1
                            $('#'+id).closest('tr').find("input[id='productNameOrder1']").val(value["product_name"]);
                            // category
                            $('#'+id).closest('tr').find("input[id='categoryOrder']").val(value["product_category"]);

                            $('#varientOrder').append(
                              `<option value="${value['product_varient']}">${value['product_varient']}</option>`
                            );

                            $('#varientOrder').removeAttr('disabled');

                            // // varient
                            // // $('#'+id).closest('tr').find("input[id='varientOrder']").val(value["product_varient"]);
                        });
                    }
                });
            }
          }

          function selectVarientSpecialPrice(){
            let id = this.event.target.id;
            let varient = $('#'+id).val();
            let product = $('#productNameOrder1').val();
            // console.log(product);
            // console.log(varient);

            getProduct(product, varient);

            // get single product details
            function getProduct(product, varient){
              jQuery.each(specialPriceProducts, function(key, value){
                if(product === value['product_name'] && varient === value['product_varient']){
                            // sku code
                            $('#'+id).closest('tr').find("input[id='sku_code']").val(value["sku_code"]);
                            // batch code
                            $('#'+id).closest('tr').find("input[id='batch_code']").val(value["batch_code"]);
                            // unit price
                            $('#'+id).closest('tr').find("input[id='unitPriceOrder']").val(value["min_sale_price"]);
                            // taxes
                            $('#'+id).closest('tr').find("input[id='taxesOrder']").val(value["tax"]);                  
                }
              });
            }
          };

        // Table
        $('#addSpecialPriceTable').on('click', function() {
            let order_product_id = $('#productId').val();
            let productName = $('#productNameOrder1').val();
            let varient = $('#varientOrder').val();
            let sku_code = $('#sku_code').val();
            let batch_code = $('#batch_code').val();
            let category = $('#categoryOrder').val();
            let unitPrice = $('#unitPriceOrder').val();
            let subTotal = $('#subTotalOrder').val();

            $("#productTableSpecialPrice > tr").each(function(e){
              let findProductId = $(this).find('.product_Id').text();
              let findProductName = $(this).find('.product_name').text();
              let findProductVarient = $(this).find('.product_varient').text();
              
              if(productName == findProductName && varient == findProductVarient){
                // $('#specialPriceAlertTableDB').show();
                // $('#specialPriceAlertTableDBContent').html('Product alredy added in table');
                errorMsg('Product alredy added in table');
                  order_product_id = '';
                  productName = '';
                  varient = '';
                  category = '';
                  unitPrice = '';
                  subTotal = '';
                  sku_code = '';
                  batch_code = '';
                  
                  $('#productId').val('');
                  $('#productNameOrder1').val('');
                  $('#varientOrder').val('');
                  $('#categoryOrder').val('');
                  $('#unitPriceOrder').val('');
                  $('#subTotalOrder').val('');
                  $('#sku_code').val('');
                  $('#batch_code').val('');
                  $('#productNameSpecialPrice').val('');
                  $('#subTotalOrderByAmount').val('');
              }else{
                $('#specialPriceAlertTableDB').hide();
              }
            });
                let slno = $('#productsTableSpecialPrice tr').length;
                if(productName!="" && varient !="" && category!="" && unitPrice!="" && subTotal!=""){
                    $('#productsTableSpecialPrice tbody').append('<tr class="child">\
                      <td>'+ slno +'</td>\
                      <td class="product_Id">'+order_product_id+'</td>\
                      <td class="product_name">'+productName+'</td>\
                      <td class="product_varient">'+varient+'</td>\
                      <td style="display:none;" class="sku_code">'+sku_code+'</td>\
                      <td style="display:none;" class="batch_code">'+batch_code+'</td>\
                      <td class="product_category">'+category+'</td>\
                      <td class="unit_price">'+unitPrice+'</td>\
                      <td class="subtotal">'+subTotal+'</td>\
                      <td>\
                        <a href="javascript:void(0);" class="remPriceList">\
                          <i class="mdi mdi-delete"></i>\
                        </a>\
                      </td>\
                    </tr>'
                  );
                  
                  $('#productId').val('');
                  $('#productNameOrder1').val('');
                  $('#varientOrder').val('');
                  $('#categoryOrder').val('');
                  $('#unitPriceOrder').val('');
                  $('#subTotalOrder').val('');
                  $('#sku_code').val('');
                  $('#batch_code').val('');
                  $('#productNameSpecialPrice').val('');
                  $('#subTotalOrderByAmount').val('');
                  $('#specialPriceAlertTableDB').hide();
                }
        });

        $(document).on('click','.remPriceList',function(){
            $(this).parent().parent().remove();

            $('#productsTableSpecialPrice tbody tr').each(function(i){            
                $($(this).find('td')[0]).html(i+1);
            });
        });

        let alladdSpecialPriceArray = [];

          // store data to database
          jQuery("#addSpecialPriceForm").submit(function (e) {
                  e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                });

                alladdSpecialPriceArray.splice(0, alladdSpecialPriceArray.length);
                
                $("#productTableSpecialPrice > tr").each(function(e){
                    let productId = $(this).find('.product_Id').text();
                    let productName = $(this).find('.product_name').text();
                    let varient = $(this).find('.product_varient').text();
                    let sku_code = $(this).find('.sku_code').text();
                    let batch_code = $(this).find('.batch_code').text();
                    let category = $(this).find('.product_category').text();
                    let unitPrice = $(this).find('.unit_price').text();
                    let subTotal = $(this).find('.subtotal').text();

                    let dbData = {
                            id:productId,
                            product_name:productName,
                            product_varient:varient,
                            sku_code:sku_code,
                            batch_code:batch_code,
                            category:category,
                            unitPrice:unitPrice,
                            specialPrice:subTotal
                    }
                    alladdSpecialPriceArray.push(dbData);
                });

                if(alladdSpecialPriceArray.length === 0){
                  errorMsg('Plese add atleast 1 Product details from below table');
                  return;
                }else{
                  $('#specialPriceAlertTableDB').hide();
                }
        
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                  if(result){
                    jQuery.ajax({
                        url: "{{ route('SA-UpdateCustomerDetails') }}",
                        data: jQuery("#addSpecialPriceForm").serialize()+"&alladdSpecialPriceArray="+JSON.stringify(alladdSpecialPriceArray),
                        enctype: "multipart/form-data",
                        type: "post",
                        success: function (result) {

                            if(result.error !=null ){
                                jQuery.each(result.error, function (key, value) {
                                  errorMsg(result.error);
                                });
                            }
                            else if(result.barerror != null){
                                errorMsg(result.barerror);
                            }
                            else if(result.special_price_success != null){
                                $('.modal .close').click();
                                successMsg(result.special_price_success);
                                alladdSpecialPriceArray.splice(0, alladdSpecialPriceArray.length);
                                business_customer_table.ajax.reload();
                            }else {
                              $('#specialPriceAlert').hide();
                            }
                        },
                    });
                  }
                });
            });

</script>