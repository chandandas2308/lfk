<!-- Modal -->
<div class="modal fade" id="viewRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Requisition</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editRequestForm">
        <div class="modal-body bg-white px-3">
            <!-- invoice body start here -->

            <!-- row 1 -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="vendorNameVQ">Vendor</label>
                    <select name="vendorName" class="form-control" id="vendorNameVQ" disabled>
                        
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="receiptDateVQ">Recept Date</label>
                    <input type="date" name="receiptDate" id="receiptDateVQ" class="form-control" placeholder="Receipt Date" disabled />
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="vendorReferenceVQ">Vendor Reference</label>
                    <input type="text" name="vendorReference" id="vendorReferenceVQ" class="form-control" placeholder="Vendor Reference" disabled />
                </div>
                <div class="col-md-6">
                    <input type="checkbox" class="mt-4" name="askForConfirm" value="confirm" id="askForConfirmVQ1"  onclick="return false" /> <label for="askForConfirmVQ" class="mt-4 text-primary">Ask for Confirmation</label>
                </div>
            </div>             

            <!-- row 3 -->
            <!-- <div class="form-group row">
                <div class="col">
                    <input type="checkbox" name="taxIncludeVQ" id="taxIncludeVQ" disabled /> <label for="taxIncludeVQ" class="text-primary">Tax inclusive</label>
                </div>
            </div> -->

            <div class="row">
                <div class="col-md-8">
                    
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group form-control">
                                    <input type="checkbox" name="taxInclude" id="taxIncludeVQ"  onclick="return false" />
                                    <label for="taxInclude" class="text-primary my-auto">&nbsp; Tax Inclusive</label>
                            </div>
                        </div>                            
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="gstValue"  id="gstValueEReqview" min="1" placeholder="GST (In %)" disabled />
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-facebook" type="button">
                                            %
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row 5 -->
            <div class="form-group row">
                <div class="col">
                    <fieldset class="border border-secondary p-2">
                        <legend class="float-none w-auto p-2">Order Details</legend>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table text-center border" id="productsTableVQ" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>      
                                            <th>Product Name</th>      
                                            <th>Category</th>
                                            <th>Variant</th>
                                            <th>SKU Code</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <!-- <th>Taxes</th> -->
                                            <th>Gross Amount</th>
                                            <th>Net Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBodyVQ"></tbody>
                                </table>
                            </div>
                    </fieldset>
                </div>                
            </div>        

            <div class="form-group row">
                <div class="col-md-6">
                    <a id="purchaseReq_download_btn" class="btn btn-primary text-white">Download</a>
                    <input type="text" name="notes" id="notesVQ" class="form-control" placeholder="Add an Internal Note" disabled />
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Sub Total</div>
                        <div class="col-md-7 my-auto">
                            <input type="text" name="untaxtedAmount1" id="untaxtedAmountVQ" class="form-control" placeholder="Sub Total" disabled>
                            <input type="text" name="untaxtedAmount" id="untaxtedAmountVQ1" class="form-control" placeholder="Sub Total" style="display: none;">
                        </div>
                    </div>
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">GST</div>
                        <div class="col-md-7 my-auto">
                            <input type="text" name="gst1" id="gstVQ" class="form-control" placeholder="GST" disabled>
                            <input type="text" name="gst" id="gstVQ1" class="form-control" placeholder="GST" style="display: none;">                        
                        </div>
                    </div>
                    <hr />
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Grand Total</div>
                        <div class="col-md-7 my-auto">
                            <input type="text" id="quotationTotalVQ" name="quotationTotal1" class="form-control" name="totalBill" placeholder="Grand Total" disabled>
                            <input type="text" id="quotationTotalVQ1" name="quotationTotal" class="form-control" name="totalBill" placeholder="Grand Total" style="display: none;">
                        </div>                   
                    </div>
                </div>
            </div>


            <!-- end here -->

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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

        getVendorNamesVQ();

        // get customer list
        function getVendorNamesVQ(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-FetchAllVendor')}}",
                success : function (response){
                    $('#vendorNameVQ').html('');
                    $('#vendorNameVQ').append('<option value="">Select Vendor Name</option>');
                    jQuery.each(response, function(key, value){
                        $('#vendorNameVQ').append(
                            '<option value="'+value["vendor_name"]+'">\
                            '+value["vendor_name"]+'\
                            </option>'
                        );
                    });
                }
            });
        }
</script>