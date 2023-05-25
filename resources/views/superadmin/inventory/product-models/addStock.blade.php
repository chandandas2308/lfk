<div class="modal fade addStock" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form enctype="multipart/form-data" method="post" id="addStockForm1">
        <div class="modal-body bg-white p-3">
        
              <!-- info & alert section -->
                <div class="alert alert-success alert-dismissible fade show" id="addStockAlert" style="display:none" role="alert">
                  <strong></strong> <span id="addStockAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="addStockAlertDanger" style="display:none" role="alert">
                  <strong></strong> <span id="addStockAlertDangerMSG">Product is already exists in stock.</span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <!-- end -->

          <!-- warehouse name  -->
          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Warehouse Name<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <select name="warehouse_id" onchange="listRacksAddStock()" id="stockWarehouseList" class="form-control check1"></select>
              <input type="text" name="warehouse" id="warehouseNameAddStock"  style="display:none;" />
              <div id="checkPrev" style="font-size:smaller; color:red;"></div>
            </div>
          </div>

          <!-- select rack  -->
          <div class="form-group row">
            <label for="racks" class="col-sm-3 col-form-label">Racks</label>
            <div class="col-sm-9">
              <select name="rack" id="racksListAddStock" class="form-control check2">
                <option value="">Select Rack...</option>
              </select>
              <div id="checkPrev1" style="font-size:smaller; color:red;"></div>
            </div>
          </div>

          <!-- product name  -->
          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Product Name<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <select name="product_name" id="stockProductList" onchange="productNameInput()" class="form-control check3">
              <div id="checkPrev2" style="font-size:smaller; color:red;"></div>
              </select>
              <input type="text" name="product_id" id="product_name_input" style="display:none" />
            </div>
          </div>
          
          <!-- product category -->
          <div class="form-group row">
            <label for="product_category_addStock" class="col-sm-3 col-form-label">Product Category<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <input type="text" name="category" id="product_category_addStock" class="form-control" placeholder="Product Category" readonly />
            </div>
          </div>

          <!-- product varient -->
          <div class="form-group row">
            <label for="product_varient" class="col-sm-3 col-form-label check5">Product Variant<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <!-- <input type="text" class="form-control" id="product_varient" name="varient" placeholder="Product Varient" /> -->
              <select name="varient" id="listStockVarients" onchange="myGetIdFn()" class="form-control">
              <option value="">Select Variant</option>
              </select>
            </div>
          </div>

          <!-- sku code  -->
          <div class="form-group row">
            <label for="skuCode" class="col-sm-3 col-form-label">Batch Code<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <input type="text" class="form-control check8" id="skuCodeAddStock" name="batchCode" placeholder="Enter Batch Code" />
            </div>
          </div>          

          <!-- quantity  -->
          <div class="form-group row">
            <label for="quantity" class="col-sm-3 col-form-label">Quantity<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <input type="number" class="form-control check6" id="quantity" name="quantity" placeholder="Quantity" />
            </div>
          </div>
          
          <!-- expiry date  -->
          <div class="form-group row">
            <label for="expiryDate" class="col-sm-3 col-form-label">Expiry</label>
            <div class="col-sm-9">
              <input type="text" class="form-control check7 datepicker" id="expiryDate" name="expiryDate" placeholder="Expiry" />
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="stockFormClearBtn">Clear</button>
          <button type="submit" id="addStockForm" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery CDN -->
    <!-- <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
      integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script> -->
<!-- backend js file -->
<!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->
@section('javascript')

<script>
    $(".datepicker").datepicker({
      dateFormat : "dd/mm/yy",
      minDate : new Date(),
    });
</script>

@endsection
<script>

  // clear form
  jQuery('#stockFormClearBtn').on('click', function (){
        jQuery("#addStockForm1")["0"].reset();
      });

  // validation script start here
  $(document).ready(function(e) {
      
      jQuery("#addStockForm1").submit(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

        $.validator.addMethod("validate", function(value) {
          return /[A-Za-z]/.test(value);
        });

      }).validate({
        rules: {

          warehouse_id : {
            required: true,
          },
          rack : {
            // required : true,
          },

          name : {
            required: true,
          },

          skuCode : {
            required: true,
          },

          category : {
            required: true,
          },

          varient : {
            required: true,
          },

          quantity : {
            required: true,
            min : 1,
          },

          expiryDate : {
            // required: true,
          },

        },
        messages : {
          warehouse_id:{
              required: "Please choose warehouse.",
          },
          rack:{
            // required: "Please choose rack.",
          },
          name: {
            required: "Please select valid product name.",
          },
          skuCode: {
              required: "Please choose/add Batch Code.",
          },
          category: {
            required: "Please choose product category.",
          },
          varient: {
            required: "Please choose product variants",
          },
          quantity: {
            required: "Product quantity required.",
            min : "Quantity value atleat 1 required."
          },
          expiryDate: {
            // required: "Please select exipry date.",
          },
        },
        submitHandler : function(){

          bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
            if(result){
                jQuery.ajax({
                  url: "{{ route('SA-AddStock') }}",
                  data: jQuery("#addStockForm1").serialize(),
                  enctype: "multipart/form-data",
                  type: "post",

                  success: function (result) {
                      if(result.error !=null ){
                        errorMsg(result.error);
                      }
                      else if(result.barerror != null){
                          errorMsg(result.barerror);
                      }
                      else if(result.success != null){
                          successMsg(result.success);
                        $('.modal .close').click();
                          jQuery("#addStockForm1")["0"].reset();
                          product_main_table.ajax.reload();
                          stock_aging_main_table.ajax.reload();
                      }else {
                          jQuery("#addStockAlertDanger").hide();
                          jQuery("#addStockAlert").hide();
                      }
                  },
              });
            }
          });
        }
      });
    });
  // end here

// end here terms

getStockWarehouseList();
// warehouse list
function getStockWarehouseList(){
  jQuery.ajax({
    url: "{{ route('SA-GetAllWarehouseDetails') }}",
    type: "get",
    success: function (result) {
      $("#stockWarehouseList").html('');
      $("#stockWarehouseList").append('<option value="">Select Warehouse</option>');
      $.each(result, function(key, value){
        $("#stockWarehouseList").append(
          '<option value="'+value["id"]+'">'+value["name"]+'</option>'
        );
      });
    }
  });
}

  function listRacksAddStock(){
    let id = this.event.target.id;
    let val = $('#'+id).val();

    $.ajax({
      type : "GET",
      url : "{{ route('SA-GetListWarehouseNameDetails')}}",
      data : {
        "id" : val
      },
      success : function (response){
        jQuery.each(response, function(key, value){
          $('#warehouseNameAddStock').val(value['name']);


          // list of racks in dropdowns
                            const racks = value['racks'];
                            const racksArr = racks.split(/\s*,\s*/);

                            $('#racksListAddStock').html('');
                            $('#racksListAddStock').append('<option value="">Select Rack...</option>');
                            $.each(racksArr, function(key, value){
                                $('#racksListAddStock').append(
                                    '<option value="'+value+'">\
                                        '+value+'\
                                    </option>'
                                );
                            });

        });
      }
    });
  }

          varientsList();

            function varientsList(){
                $.ajax({
                    type : "GET",
                    url : "{{ route('SA-ListUniqueVarients')}}",
                    success : function (response){
                        $('#listStockVarients').html('');
                        $('#listStockVarients').append('<option value="">Select Variant</option>');
                        jQuery.each(response, function(key, value){
                                $('#listStockVarients').append(
                                    '<option value="'+value["product_varient"]+'">\
                                        '+value["product_varient"]+'\
                                    </option>'
                                );
                        });
                    }
                });
            }

let proIdArr = [];

    function productNameInput(){
    let id = this.event.target.id;
    let val = $('#'+id).val();
    productNameStock(val, id);

            function productNameStock(val, id){
                $.ajax({
                    type : "GET",
                    url : "{{ route('SA-GetNameProducts')}}",
                    data : {
                        "val" : val
                    },
                    success : function (response){

                      proIdArr = response;

                      console.log('start');
                      console.log(response);
                      console.log('end');
                        jQuery.each(response, function(key, value){

                          //  product name
                          //  $('#product_name_input').val(value['id']);

                           $('#product_category_addStock').val(value['product_category']);

                           $('#listStockVarients').html('');
                            $('#listStockVarients').append('<option value="" hidden>Choose Variants</option>');
                            jQuery.each(response, function(key, value){
                                    $('#listStockVarients').append(
                                        '<option value="'+value["product_varient"]+'">\
                                            '+value["product_varient"]+'\
                                        </option>'
                                    );
                            });

                        });
                    }
                });
            }    
    }

    function myGetIdFn(){

      let productNameIs = $('#stockProductList').val();
      let varientNameIs = $('#listStockVarients').val();

      $.each(proIdArr, function(key, value){

        if(productNameIs == value['product_name'] && varientNameIs == value['product_varient']){

          $('#product_name_input').val(value['id']);

        }

      });

    }

    getStockProductList();

    // products list
        function getStockProductList(){
          jQuery.ajax({
            url: "{{ route('SA-GetAllProducts') }}",
            type: "get",
            success: function (result) {
              console.log(result);
              $("#stockProductList").html('');
              $("#stockProductList").append('<option value="">Select Product</option>');
              $.each(result, function(key, value){
                $("#stockProductList").append(
                  '<option value="'+value["product_name"]+'">'+value["product_name"]+'</option>'
                );
              });
            }
          });
        }
  

  getCategoryinStock();

    function getCategoryinStock(){
          jQuery.ajax({
            url: "{{ route('SA-ListCategories') }}",
            type: "get",
            success: function (result) {
              $("#product_category_addStock").html('');
              $("#product_category_addStock").append('<option value="">Select Category</option>');
              $.each(result, function(key, value){
                $("#product_category_addStock").append(
                  '<option value="'+value["name"]+'">'+value["name"]+'</option>'
                );
              });
            }
          });
        }

</script>

