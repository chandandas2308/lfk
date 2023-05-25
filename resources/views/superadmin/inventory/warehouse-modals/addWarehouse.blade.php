
<style>
  #tag-ip{
    text-indent: 25px;
    outline: none;
  }
  .warehouse-rack-list{
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }
  .warehouse-rack-list .item{
    padding: 5px 8px;
    background-color: #fff;
    border: 1px solid #888;
    border-radius: 5px;
    color: #111;
    user-select: none;
  }

  .warehouse-rack-list .item .delete-btn{
    display: inline-block;
    margin: 0px 2px;
    width: 8px;
    text-align: center;
    color: #555;
  }
</style>

<div class="modal fade addWarehouse" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Warehouse</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form class="forms-sample" id="addWarehouseForm1" enctype="multipart/form-data" method="post">
          @csrf
          <div class="modal-body">

              <!-- info & alert section -->
                  <div class="alert alert-success alert-dismissible fade show" id="addWarehouseAlert" style="display:none" role="alert">
                    <strong>Info ! </strong> <span id="addWarehouseAlertMsg"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="alert alert-danger alert-dismissible fade show" id="addWarehouseError" style="display:none" role="alert">
                    <strong>Info ! </strong> <span id="addWarehouseErrorMsg"></span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <!-- end -->

              <!-- end -->

              <div class="card">
                <div class="card-body">

                    <!-- Warehouse Name  -->
                    <div class="form-group row">
                      <label for="name" class="col-sm-3 col-form-label fw-bolder">Warehouse Name<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control text-dark" id="name" name="name" placeholder="Warehouse Name" />
                      </div>
                    </div>

                    <!-- Short Code -->
                    <div class="form-group row">
                      <label for="shortCode" class="col-sm-3 col-form-label fw-bolder">Short Code<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control text-dark" id="shortCode" name="shortCode" placeholder="Short Code" />
                      </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group row">
                      <label for="address" class="col-sm-3 col-form-label fw-bolder">Address</label>
                      <div class="col-sm-9">
                          <textarea name="address" id="address" class="form-control text-dark" cols="30" rows="5" placeholder="Address"></textarea>
                      </div>
                    </div>

                    <!-- Warehouse Detials -->
                    <div class="form-group row">
                      <label for="address" class="col-sm-3 col-form-label fw-bolder">Rack Details</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="warehouse_rack" name="racks" placeholder="Add Rack" />
                          <div class="alert-info px-2 py-1 small">Rack 1, Rack 2</div>
                          <div class="warehouse-rack-list"></div>
                          <span style="color:red; font-size:small; display:none;" id="racksListWarehouse">Rack field required.</span>
                      </div>
                    </div>

                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addWarehouseFormClearBtn" >Clear</button>
                <button type="submit" id="addWarehouseForm" class="btn btn-primary">Save</button>
              </div>
          </div>
        </form>
    </div>
  </div>
</div>


<script>

      // clear form
      jQuery('#addWarehouseFormClearBtn').on('click', function (){
        jQuery("#addWarehouseForm1")["0"].reset();
      });

  // validation script start here// store into DB
jQuery(document).ready(function () {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
  
    jQuery("#addWarehouseForm1").submit(function (e) {
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
        name : {
          required: true,
          minlength: 1,
          validate: true,
        },

        shortCode : {
          required: true,
        },

      },
      messages : {
        name: {
          required: "Please enter valid warehouse name.",
          minlength: "Warehouse name length atleast 1 required.",
          validate: "Plase enter valid warehouse name."
        },
        shortCode: {
            required: "Short Code required.",
        },
        warehouse_detials: {
          required: "Please enter warehouse details",
          minlength: "Please enter valid warehouse details",
          validate: "Please enter valid warehouse details",
        },
      },
      submitHandler : function(){
            bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
              if(result){
                jQuery.ajax({
                  url: "{{ route('SA-AddWarehouse') }}",
                  data: jQuery("#addWarehouseForm1").serialize()+"&rack="+rack,
                  enctype: "multipart/form-data",
                  type: "post",

                  success: function (result) {
                      warehouse_main_table.ajax.reload();
                      if(result.error !=null ){
                          errorMsg(result.error);
                      }
                      else if(result.barerror != null){
                          jQuery("#addWarehouseError").show();
                          jQuery("#addWarehouseForm1")["0"].reset();
                          $(".warehouse-rack-list").html('');
                          errorMsg(result.barerror);
                          rack.splice(0, rack.length);
                      }
                      else if(result.success != null){
                          successMsg(result.success);
                          $('.modal .close').click();
                          warehouse_main_table.ajax.reload();
                          jQuery("#addWarehouseForm1")["0"].reset();
                          $(".warehouse-rack-list").html('');
                          rack.splice(0, rack.length);
                          getStockWarehouseList();
                      }else {
                          jQuery("#addWarehouseError").hide();
                          jQuery("#addWarehouseAlert").hide();
                      }
                  },
                });
              }
            });
          }
      // }
    });
  });
// end here


let rack = [] ;
let rackArr = [];

function addRack(e){
  $('#racksListWarehouse').hide();
  let code = (e.keyCode ? e.keyCode : e.which);

  if(code !=13){
    return;
  }

  let tag = e.target.value.trim();

  tag = tag.replace(/,*$/, '');
  
  if(tag.length < 1 || rack.includes(tag)){
    e.target.value = "";
    return;
  }
  let index = rack.push(tag);

  $(".warehouse-rack-list").html('');

  $.each(rack, function(k,v){
    let tagItem = document.createElement("div");
    tagItem.classList.add("item");
    
    tagItem.innerHTML = `
        <span class="delete-btn" onclick="deleteRack(this, '${v}')">
        &times;
        </span>
        <span>${v}</span>
    `;

    document.querySelector(".warehouse-rack-list").appendChild(tagItem);
  });

  e.target.value = "";

  // console.log(rack);

}

function deleteRack(ref, tag){
  let parent = ref.parentNode.parentNode;
  parent.removeChild(ref.parentNode);
  let index = rack.indexOf(tag);

  Array.prototype.removeAt = function (iIndex){
    var vItem = this[iIndex];
    if (vItem) {
        this.splice(iIndex, 1);
    }
    return vItem;
  };

  rack.removeAt(index);
}

document.querySelector('#warehouse_rack').addEventListener("keyup", addRack);

</script>