<!-- Modal -->
<div class="modal fade" id="addPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="addPaymentForm">
        <div class="modal-body bg-white">

          <!-- info & alert section -->
          <div class="alert alert-success" id="addPaymentAlert" style="display:none"></div>
          <div class="alert alert-danger" style="display:none">
            <ul></ul>
          </div>
          <!-- end -->

            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="customer_name">Customer Name <span style="color:red; font-size:medium">*</span></label>
                    <select name="customer_name" id="chooseCustomerName" onchange="dropAllInvoice()" class="form-control"></select>
                    <input type="text" name="customer_id" id="customer_id_payment_on" style="display:none;" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="invoiceNo">Invoice No.<span style="color:red; font-size:medium">*</span></label>
                    <select name="invoiceNo" id="invoiceNoPayments" onchange="selectInvoiceNo()" class="form-control">
                      <option value="">Select Invoice No.</option>
                    </select>
                    <input type="hidden" name="invoiceId" id="payinvoiceId">
                    <input type="hidden" name="pInvNam" id="pInvId">
                  </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="invoicedaate">Invoice Date</label>
                    <input type="text" class="form-control" id="invoicedaate" name="invoicedaate" placeholder="Invoice Date" readonly />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount" readonly />
                    <input type="text" name="amount" class="form-control" id="amount1" placeholder="Amount" style="display: none;" />
                  </div>
                </div>
            </div>

            <!-- <hr> -->
            <div class="row">
                                <div class="col-md-6 my-auto">
                                    <div class="form-group my-auto">
                                      <label for="forPartialAmount" class="my-auto">  
                                        <input type="checkbox" name="forPartialAmount" id="forPartialAmount" class="my-auto">&nbsp;Partial Amount
                                      </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pending_amt">Pending Amount</label>
                                        <input type="text" name="pending_amt" class="form-control" id="pending_amt" placeholder="Pending Amount" readonly />
                                    </div>
                                </div>
            </div>
             <!-- <hr> -->

            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="amount">Partial Amount</label>
                      <input type="text" name="partialamount" class="form-control" id="partialamount" placeholder="Partial Amount" disabled />
                      <span style="font-size:small; color:red; display:none;" id="balanceAmtAlert">Amount should not be more than Balance Amount. <br><strong>Balance Amount : $<span id="balanceAmountAlrt"></span></strong></span>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="paymentType">Payment Type <span style="color:red; font-size:medium">*</span></label>
                    <select name="paymentType" id="paymentType" class="form-control">
                      <option value="">Choose Payment Type</option>
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
                    <input type="date" class="form-control" id="paymentDate" value="<?= date('Y-m-d') ?>" name="paymentDate" placeholder="Payment Date" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="paymentStatus">Payment Status</label>
                    <select name="paymentStatus" id="paymentStatus" class="form-control">
                      <option value="">Payment Status</option>
                      <option value="paid">Paid</option>
                      <option value="partial">Partial</option>                  
                    </select>
                  </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="addPaymentClearFormBtn">Clear</button>
          <button type="submit" id="addPaymentForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

    if($(this).is(':checked')){
      $('#partialamount').removeAttr('disabled');
      $('#paymentStatus').val('partial');
    }else{
      $('#partialamount').attr('disabled', true);
      $('#paymentStatus').val('paid');
    }

  $('#forPartialAmount').click(function(){
    if($(this).is(':checked')){
      $('#partialamount').removeAttr('disabled');
      $('#paymentStatus').val('partial');
    }else{
      $('#partialamount').attr('disabled', true);
      $('#paymentStatus').val('paid');
    }
  });

  // clear form
  jQuery('#addPaymentClearFormBtn').on('click', function() {
    jQuery("#addPaymentForm")["0"].reset();
  });

  // validation script start here
  $(document).ready(function() {

    jQuery("#addPaymentForm").submit(function(e) {
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

        customer_name: {
          required: true,
        },

        invoiceNo: {
          required: true,
        },

        // amount : {
        //   required: true,
        //   min: 1,
        // },

        paymentType: {
          required: true,
        },

        paymentDate: {
          required: true,
        },

        paymentStatus: {
          required: true,
        },

      },
      messages: {
        customer_name: {
          required: "Please choose customer name.",
        },
        invoiceNo: {
          required: "Invoice number field required.",
        },
        amount: {
          required: "Amount field required.",
          min: "Please enter valid amount.",
        },
        paymentType: {
          required: "Please choose payment type.",
        },
        paymentDate: {
          required: "Payment date required.",
        },
        paymentStatus: {
          required: "Payment status required.",
        },
      },
      submitHandler:function(){
        bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
          if(result){
            jQuery.ajax({
              url: "{{ route('SA-AddPayment') }}",
              data: jQuery("#addPaymentForm").serialize(),
              enctype: "multipart/form-data",
              type: "post",

              success: function(result) {
                if (result.error != null) {
                  errorMsg(result.error);
                } else if (result.barerror != null) {
                  jQuery("#addPaymentAlert").hide();
                  errorMsg(result.barerror);
                } else if (result.success != null) {
                  jQuery(".alert-danger").hide();
                  successMsg(result.success);
                  $('.modal .close').click();
                  jQuery("#addPaymentForm")["0"].reset();
                  $('#partialamount').attr('disabled', true);
                  payment_main_table.ajax.reload();
                  sales_invoice_main_table.ajax.reload();
                } else {
                  jQuery(".alert-danger").hide();
                  jQuery("#addPaymentAlert").hide();
                }
              },
            });
          }
        });
      }

    });
  });
  // end here

  let invoiceDetailsPay = [];

  function dropAllInvoice() {
    let id = this.event.target.id;
    let pro = $('#' + id).val();

    let custId = $('#chooseCustomerName').val();

    jQuery("#addPaymentForm")["0"].reset();

    $('#chooseCustomerName').val(custId);

    $.ajax({
      type: "GET",
      url: "{{ route('SA-FetchAllInvoiceForPayments1')}}",
      data: {
        "id": pro
      },
      success: function(response) {

        invoiceDetailsPay = response;

        $('#invoiceNoPayments').html('');
        $('#invoiceNoPayments').append('<option value="">Select Invoice No.</option>');
        jQuery.each(response, function(key, value) {
          $('#customer_id_payment_on').val(value["customer_name"]);
          $('#invoiceNoPayments').append(
            // '<option value=' + ((value["Qref_no"] != null)?value["Qref_no"]:value["quotation_no"]) + '>' + ((value["Qref_no"] != null)?value["Qref_no"]:value["quotation_no"]) + '</option>'
            `<option value="${value["invoice_no"]}">${value["inv_no"]}</option>`
          );
        });

      }
    });
  }

  $('#partialamount').on('keypress change', function(){

    let currentPayAmt = parseFloat($(this).val());

    let totalBill = $('#amount1').val();
    let partiallyPay = $('#pending_amt').val();

    let balanceBill = parseFloat(totalBill)-parseFloat(partiallyPay);

    $('#balanceAmountAlrt').text(partiallyPay);

    if(currentPayAmt > partiallyPay || currentPayAmt <= 0){
        $('#balanceAmtAlert').show();
        $('#partialamount').val('');
    }else{
        $('#balanceAmtAlert').hide();
    }

  })

  function selectInvoiceNo() {
    let id = this.event.target.id;
    let pro = $('#' + id).val();
    // getProduct(pro, id);

    //     get single product details
    // function getProduct(pro, id) {
    //   $.ajax({
    //     type: "GET",
    //     url: "{{ route('SA-InvoiceDetails')}}",
    //     data: {
    //       "pro": pro
    //     },

    // console.log(invoiceDetailsPay);

        // success: function(response) {
          jQuery.each(invoiceDetailsPay, function(key, value) {
            if(pro == value['invoice_no']){
              $('#payinvoiceId').val(value['id']);
              $('#pInvId').val(value['inv_no']);
              $('#amount').val(value['total']);
              $('#amount1').val(value['total']);
              //$('#partialamount').val(value['invoice_date']);
              $('#pending_amt').val(((value["pending_amount"] != null)?value["pending_amount"]:value["total"]));
              $('#editAmount').val(value["total"]);
              $('#editAmount2').val(value["total"]);
              $('#invoicedaate').val(value["invoice_date"]);
              $('#editinvoicedaate').val(value["invoice_date"]);
            }
          });
    //     }
    //   });
    // }
  };
</script>