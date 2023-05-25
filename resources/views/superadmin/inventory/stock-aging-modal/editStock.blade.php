<div class="modal fade editStock" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form enctype="multipart/form-data" method="post" id="editStockForm1">
        <div class="modal-body bg-white p-3">

          <input type="text" name="id" id="stockId" style="display: none;">

          <!-- warehouse name  -->
          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Warehouse Name<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <!-- <select name="warehouse_id" onchange="listRacksEditStock()" id="stockWarehouseListEdit" class="form-control check1"></select> -->
              <input type="text" name="warehouse_name" id="stockWarehouseListEdit" class="form-control" readonly />
            </div>
          </div>

          <!-- select rack  -->
          <div class="form-group row">
            <label for="racks" class="col-sm-3 col-form-label">Racks</label>
            <div class="col-sm-9">
              <!-- <select name="rack" id="racksListEditStock" class="form-control check2"></select> -->
              <!-- <div id="checkPrev1" style="font-size:smaller; color:red;"></div> -->
              <input type="text" name="rack" id="racksListEditStock" class="form-control" readonly />
            </div>
          </div>

          <!-- product name  -->
          <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">Product Name<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <!-- <select name="product_name" id="stockProductListEdit" onchange="productNameInputEdit()" class="form-control check3">
              <div id="checkPrev2" style="font-size:smaller; color:red;"></div>
              </select>
              <input type="text" name="product_id" id="product_name_input_edit" style="display:none" /> -->
              <input type="text" name="product_name" id="stockProductListEdit" class="form-control" readonly />
            </div>
          </div>
          
          <!-- product category -->
          <div class="form-group row">
            <label for="product_category_editStock" class="col-sm-3 col-form-label">Product Category<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <input type="text" name="category" id="product_category_editStock" class="form-control" placeholder="Enter Product Category" readonly />
            </div>
          </div>

          <!-- product varient -->
          <div class="form-group row">
            <label for="product_varient" class="col-sm-3 col-form-label check5">Product Variant<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="listStockVarientsEdit" name="varient" placeholder="Product Variant" readonly />
              <!-- <select name="varient" id="listStockVarientsEdit" class="form-control"></select> -->
            </div>
          </div>

          <!-- sku code  -->
          <div class="form-group row">
            <label for="skuCode" class="col-sm-3 col-form-label">Batch Code<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <input type="text" class="form-control check8" id="skuCodeAddStockEdit" name="batchCode" placeholder="Enter Batch Code" />
            </div>
          </div>          

          <!-- quantity  -->
          <div class="form-group row">
            <label for="quantity" class="col-sm-3 col-form-label">Quantity<span style="color: red;">*</span></label>
            <div class="col-sm-9">
              <input type="number" class="form-control check6" id="quantityEdit" name="quantity" placeholder="Quantity" />
            </div>
          </div>
          
          <!-- expiry date  -->
          <div class="form-group row">
            <label for="expiryDate" class="col-sm-3 col-form-label">Expiry</label>
            <div class="col-sm-9">
              <input type="text" class="form-control datepicker" id="expiryDateEdit" name="expiryDate" placeholder="Expiry" />
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="stockFormClearBtnEdit">Clear</button>
          <button type="submit" id="addStockForm" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

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
  jQuery('#stockFormClearBtnEdit').on('click', function (){
        jQuery("#editStockForm1")["0"].reset();
      });

  // validation script start here
  $(document).ready(function(e) {
      
      jQuery("#editStockForm1").submit(function (e) {
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

          warehouse_name : {
            required: true,
          },
          rack : {
            // required : true,
          },

          product_name : {
            required: true,
          },

          batchCode : {
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
              required: "Warehouse required.",
          },
          rack:{
            // required: "racks required.",
          },
          name: {
            required: "Product name required",
          },
          skuCode: {
              required: "Please add Batch Code.",
          },
          category: {
            required: "Please add product category.",
          },
          varient: {
            required: "Please add product varients",
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
          bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
            if(result){
                jQuery.ajax({
                  url: "{{ route('SA-UpdateStockDetails') }}",
                  data: jQuery("#editStockForm1").serialize(),
                  enctype: "multipart/form-data",
                  type: "post",

                  success: function (result) {
                      if(result.error !=null ){
                        errorMsg(result.error);
                      }
                      else if(result.barerror != null){
                          jQuery("#editStockAlert").hide();
                          // jQuery("#editStockAlertDanger").show();
                          // jQuery("editStockAlertDangerMSG").html(result.barerror);
                          errorMsg(result.barerror);
                      }
                      else if(result.success != null){
                          // jQuery("#editStockAlertDanger").hide();
                          // jQuery("#editStockAlertMSG").html(result.success);
                          // jQuery("#editStockAlert").show();

                          successMsg(result.success);
                          $('.modal .close').click();

                          jQuery("#editStockForm1")["0"].reset();
                          getProducts();
                          getStockAging();
                      }else {
                          jQuery("#editStockAlertDanger").hide();
                          jQuery("#editStockAlert").hide();
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
</script>