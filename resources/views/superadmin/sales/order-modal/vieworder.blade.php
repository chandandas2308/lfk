<!-- Modal -->
<div class="modal fade" id="viewQuotationORDER" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Quotation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="viewQuotationForm">
        <div class="modal-body bg-white px-3"> 
            <!-- invoice body start here -->

            <!-- row 1 -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="customerName">Customer Name</label>
                    <input type="text" name="customerName" class="form-control" id="customerNameVQorder" disabled />
                </div>
                <div class="col-md-6">
                    <label for="expiration">Expiration</label>
                    <input type="date" name="expiration" id="expirationVQorder" class="form-control" placeholder="Expiration" disabled>
                </div>
            </div>

            <!-- row 2 -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="customerAddress">Customer Address</label>
                    <textarea name="customerAddress" class="form-control" id="customerAddressVQorder" rows="4" placeholder="Address" disabled></textarea>
                </div>
                <div class="col-md-6">
                    <label for="paymentTerms">Payment Terms</label>
                    <select name="paymentTerms" class="form-control" id="paymentTermsVQorder" disabled>
                        <option value="">Select Payment Terms</option>
                        <option value="cash on delivery">cash on delivery</option>
                        <option value="30 days">30 days</option>
                    </select>
                </div>
            </div>        

            <!-- row 3 -->
            <div class="form-group row">
                <div class="col-md-8">
                    
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label for="taxInclude" class="text-primary form-control"><input type="checkbox" name="taxInclude" id="taxIncludeVQorder" onclick="return false" /> Tax Inclusive</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="gstValue" value="7" id="gstValueVieworder" min="1" placeholder="GST (In %)" disabled />
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
                                <table class="table text-center border" id="productsTableVQorder" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>      
                                            <th>Product Name</th>      
                                            <th>Category</th>
                                            <th>Variant</th>
                                            <th>SKU Code</th>
                                            <th>Batch Code</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Gross Amount</th>
                                            <th>Net Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBodyVQorder"></tbody>
                                </table>
                            </div>
                    </fieldset>
                </div>                
            </div>        

            <div class="form-group row">
                <div class="col-md-6">
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Sub Total</div>
                        <div class="col-md-7">
                                <div class="form-group my-auto">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-facebook" type="button">
                                                $
                                            </button>
                                        </div>
                                        <input type="number" name="untaxtedAmount1" id="untaxtedAmountVQorder" class="form-control" placeholder="Sub Total" disabled>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">GST</div>
                        <div class="col-md-7">
                                <div class="form-group my-auto">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-facebook" type="button">
                                                $
                                            </button>
                                        </div>
                                        <input type="number" name="gst1" id="gstVQorder" class="form-control" placeholder="GST" disabled>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Grand Total</div>
                        <div class="col-md-7">
                                <div class="form-group my-auto">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-facebook" type="button">
                                                $
                                            </button>
                                        </div>
                                        <input type="number" id="quotationTotalVQorder" name="quotationTotal1" class="form-control" name="totalBill" placeholder="Grand Total" disabled>
                                    </div>
                                </div>
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

<script>

    getCustomerNameQorder();

    // get customer list
    function getCustomerNameQorder(){
        $.ajax({
            type : "GET",
            url : "{{ route('SA-CustomersList')}}",
            success : function (response){
                $('#customerNameVQorder').append('<option value="">Select Customer</option>');
                jQuery.each(response, function(key, value){
                    $('#customerNameVQorder').append(
                        '<option value="'+value["customer_name"]+'">\
                        '+value["customer_name"]+'\
                        </option>'
                    );
                });
            }
        });
    }
</script>