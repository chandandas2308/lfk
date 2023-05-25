<!-- Modal -->
<style>
    @media screen {
  #printSection {
      display: none;
  }
}

@media print {
  body * {
    visibility:hidden;
  }
  #printSection, #printSection * {
    visibility:visible;
  }
  #printSection {
    position:absolute;
    left:0;
    top:0;
  }
}



</style>
<div id="printThis">
<div class="modal fade" id="viewInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="salesEditInvoiceForm">
        <div class="modal-body bg-white px-3"> 
            <!-- invoice body start here -->

            <!-- row 0 -->
            <div class="form-group row">
                <div class="col-md-2 col-form-label">Order No.</div>
                <div class="col-md-4">
                    <!-- <select name="quotationNumber" onchange="getQuotationDetailsInvoice()" id="quotationNumberVInvoice" class="form-control text-dark" disabled></select> -->
                    <input type="text" name="quotationNumber" id="quotationNumberVInvoice" class="form-control text-dark" placeholder="Order No." disabled />
                </div>
                <!-- <div class="col-md-2 form-control text-center border-0 fw-bold text-dark">
                    <h6>OR</h6>
                </div> -->
                <div class="col-md-2 col-form-label">Invoice No.</div>
                <div class="col-md-4">
                    <input type="text" class="form-control text-dark" name="refNextQColumn" id="refNextColumnVInvoice" placeholder="Invoice No." disabled />
                </div>
            </div>

            <!-- row 2 -->
            <div class="form-group row">
                <div class="col-md-2 col-form-label">Customer Name</div>
                <div class="col-md-4">
                    <!-- <select name="customerName" class="form-control" id="customerNameVInvoice" disabled ></select> -->
                    <input type="text" name="customerName" class="form-control" id="customerNameVInvoice" disabled />
                </div>
                <div class="col-md-2 col-form-label">Invoice Date</div>
                <div class="col-md-4">
                    <input type="date" name="invoiceDate" class="form-control text-dark" id="invoiceDateVInvoice" placeholder="Invoice Date" disabled />
                </div>
            </div>

            <!-- row 3 -->
            <div class="form-group row">
                <div class="col-md-2 col-form-label">Payment Reference</div>
                <div class="col-md-3">
                    <input type="text" name="paymentReference" class="form-control text-dark" id="pymentReferenceVInvoice" placeholder="Payment Reference" disabled />
                </div>
                <div class="col-md col-form-label">Due Date</div>
                <div class="col-md-3">
                    <input type="date" name="dueDate" class="form-control text-dark" id="invoiceDueVInvoice" disabled />
                </div>
                <div class="col-md col-form-label text-center border-0 fw-bold text-dark"><h6>OR</h6></div>
                <div class="col-md-2">
                    <select name="selectTerms" id="selectTermsVInvoice" class="form-control form-control-lg text-dark" disabled>
                        <option value="">Select Payment Terms</option>
                        <option value="cash on delivery">cash on delivery</option>
                        <option value="30 days">30 days</option>
                    </select>
                </div>
            </div>

            <!-- row 4 -->
            <div class="row">
                <div class="col-md-8">
                    
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label for="taxInclude" class="text-primary form-control"><input type="checkbox" onclick="return false" name="taxInclude" id="taxIncludeViewInvoice"> Tax Inclusive</label>
                            </div>
                        </div>                            
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="gstValue" value="7" id="gstValueInvoiceView" min="1" placeholder="GST (In %)" disabled />
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
                        <legend class="float-none w-auto p-2">Invoice Details</legend>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table text-center border" id="productTableVInvoice" style="width: 100%; border-collapse: collapse;">
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
                                    <tbody id="productTableViewInvoiceBody"></tbody>
                                </table>
                            </div>
                    </fieldset>
                </div>                
            </div>        

            <div class="form-group row">
                <div class="col-md-6">
                    <!-- <div id="download_btn"></div> -->
                    <a id="invoice_download_btn" class="btn btn-primary text-white">Download</a>
                    <a id="btnPrintSalesInvoice" target="_blank" class="btn btn-primary text-white">Print</a>
                    <input type="text" name="notes" id="notesVInvoice" class="form-control" placeholder="Add an Internal Note" disabled />
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Sub Total</div>
                        <div class="col-md-7 my-auto">
                            <input type="number" name="untaxtedAmountVInvoice" id="untaxtedAmountVInvoice" class="form-control" placeholder="Sub Total" disabled>
                        </div>
                    </div>
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">GST</div>
                        <div class="col-md-7 my-auto">
                            <input type="number" name="GST" id="gstVInvoice" class="form-control" placeholder="GST" disabled>
                        </div>
                    </div>
                    <hr />
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Grand Total</div>
                        <div class="col-md-7 my-auto">
                            <input type="number" id="invoiceVTotal" name="invoiceETotal" class="form-control" name="totalBill" placeholder="Grand Total" disabled>
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
</div>
<!-- jQuery CDN -->
<script>
   
    // fetch all quotation number
    getQuotationNumVInvoice();
    
    function getQuotationNumVInvoice(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetAllQuotations')}}",
                success : function (response){
                    $('#quotationNumberVInvoice').append('<option value="">Select Quotation Number</option>');
                    jQuery.each(response, function(key, value){
                        $('#quotationNumberVInvoice').append(
                            '<option value="'+value["id"]+'">\
                            '+value["id"]+'\
                            </option>'
                        );
                    });
                }
            });
        }


        // get customer list
        getCustomerVInvoice();

        function getCustomerVInvoice(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-CustomersList')}}",
                success : function (response){
                    $('#customerNameVInvoice').append('<option value="">Select Customer</option>');
                    jQuery.each(response, function(key, value){
                        $('#customerNameVInvoice').append(
                            '<option value="'+value["customer_name"]+'">\
                            '+value["customer_name"]+'\
                            </option>'
                        );
                    });
                }
            });
        }

        
</script>