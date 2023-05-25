<!-- Modal -->
<div class="modal fade" id="editPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editPaymentForm">
        <div class="modal-body bg-white px-3">

          <!-- info & alert section -->
          <div class="alert alert-success" id="editPaymentAlert" style="display:none"></div>
          <div class="alert alert-danger" style="display:none">
            <ul></ul>
          </div>
          <!-- end -->

          <div class="card">
            <div class="card-body">

              <input type="text" name="id" id="editFormId" style="display: none;">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="invoiceNo">Invoice Number</label>
                    <input type="text" name="invoiceNo" id="editInvoiceNoPayments" onchange="selectInvoiceNoEditPayment()" class="form-control text-dark" list="paymentInvoiceList" readonly />
                    <datalist id="paymentInvoiceList"></datalist>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="invoiceDate">Invoice Date</label>
                    <input type="date" class="form-control" id="editinvoicedaate" name="invoicedaate" placeholder="Invoice Date" readonly />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="customer_name">Customer Name</label>
                    <select name="customer_name" id="customerNameEditOnPayment" onchange="dropAllInvoiceEditPayment()" class="form-control text-dark" disabled ></select>
                    <input type="text" name="customer_id" id="customer_id_payment_on_edit" style="display:none;" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" name="amount" class="form-control" id="editAmount" placeholder="Amount" readonly />
                    <input type="text" name="amount" class="form-control" id="editAmount2" placeholder="Amount" style="display: none;" />
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="amount">Partial Amount</label>
                    <input type="text" name="partialamount" class="form-control" id="editpartialamount" placeholder="Partial Amount" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="paymentType">Payment Type</label>
                    <select name="paymentType" id="editPaymentType" class="form-control text-dark">
                      <option value="default">Choose payment type</option>
                      <option value="cash">Cash</option>
                      <option value="cheque">Cheque</option>
                      <option value="account">Account Transfer</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="paymentDate">Payment Date</label>
                    <input type="date" class="form-control" id="editPaymentDate" name="paymentDate" placeholder="Payment Date" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="paymentStatus">Payment Status</label>
                    <select name="paymentStatus" id="editPaymentStatusSales" class="form-control text-dark">
                      <option value="">Payment Status</option>
                      <option value="paid">Paid</option>
                      <option value="partial">Partial</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="editPaymetClearBtn">Clear</button>
          <button type="submit" id="editPaymentForm1" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

jQuery('#editPaymetClearBtn').on('click', function (){
    jQuery("#editPaymentForm")["0"].reset();
});

  function dropAllInvoiceEditPayment() {

    let id = this.event.target.id;
    let pro = $('#' + id).val();

    $.ajax({
      type: "GET",
      url: "{{ route('SA-FetchAllInvoiceForPayments')}}",
      data: {
        "id": pro
      },
      success: function(response) {

        $('#paymentInvoiceList').html('');
        jQuery.each(response, function(key, value) {
          $('#customer_id_payment_on_edit').val(value['customer_name']);
          $('#paymentInvoiceList').append(
            '<option value=' + value["invoice_no"] + '>'
          );
        });
      }
    });
  }

  function selectInvoiceNoEditPayment() {
    let id = this.event.target.id;
    let pro = $('#' + id).val();
    getProduct(pro, id);

    //     get single product details
    function getProduct(pro, id) {
      $.ajax({
        type: "GET",
        url: "{{ route('SA-InvoiceDetails')}}",
        data: {
          "pro": pro
        },
        success: function(response) {
          jQuery.each(response, function(key, value) {
            $('#amount').val(value['total']);
            $('#amount1').val(value['total']);
          });
        }
      });
    }
  };

  // store edited data in db

  jQuery("#editPaymentForm").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
    });


    jQuery.ajax({
      url: "{{ route('SA-editPaymentDetails') }}",
      data: jQuery("#editPaymentForm").serialize(),
      enctype: "multipart/form-data",
      type: "post",

      success: function(result) {
        if (result.error != null) {
          jQuery(".alert-danger>ul").html(
            "<li> Info ! Please complete below mentioned fields : </li>"
          );
          jQuery.each(result.error, function(key, value) {
            jQuery(".alert-danger").show();
            jQuery(".alert-danger>ul").append(
              "<li>" + key + " : " + value + "</li>"
            );
          });
        } else if (result.barerror != null) {
          jQuery("#editPaymentAlert").hide();
          jQuery(".alert-danger").show();
          jQuery(".alert-danger").html(result.barerror);
        } else if (result.success != null) {
          jQuery(".alert-danger").hide();
          jQuery("#editPaymentAlert").html(result.success);
          jQuery("#editPaymentAlert").show();
          jQuery("#addPaymentForm")["0"].reset();
          getPaymentDetials();
          updateInvoice();
        } else {
          jQuery(".alert-danger").hide();
          jQuery("#editPaymentAlert").hide();
        }
      },
    });
  });
</script>