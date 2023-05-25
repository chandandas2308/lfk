<!-- Modal -->
<div class="modal fade" id="addPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="addPaymentForm">
        <div class="modal-body bg-white px-3">

          <!-- info & alert section -->
          <div class="alert alert-success" id="addPaymentAlert" style="display:none"></div>
          <div class="alert alert-danger" style="display:none">
            <ul></ul>
          </div>
          <!-- end -->

          <div class="card">
            <div class="card-body">

              <div class="form-group">
                  <label for="customer_name">Customer Name</label>
                  <!-- <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Customer Name" readonly> -->
                  <select name="customer_name" id="chooseCustomerName" onchange="dropAllInvoice()" class="form-control"></select>
                  <input type="text" name="customer_id" id="customer_id_payment_on" style="display:none;" />
              </div>

              <div class="form-group">
                <label for="invoiceNo">Invoice Number</label>
                <select name="invoiceNo" id="invoiceNoPayments" onchange="selectInvoiceNo()" class="form-control"></select>
              </div>

              <div class="form-group">
                <label for="invoicedaate">Invoice Date</label>
                <input type="text" class="form-control" id="invoicedaate" name="invoicedaate" placeholder="Invoice Date" readonly />
              </div>
              
              <div class="form-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount" readonly />
                <input type="text" name="amount" class="form-control" id="amount1" placeholder="Amount" style="display: none;" />
              </div>
              <div class="form-group">
                <input type="checkbox" name="forPartialAmount" id="forPartialAmount">
                <label for="amount">Check for Partial Amount</label>
              </div>
              <div class="form-group">
                <label for="amount">Partial Amount</label>
                <input type="text" name="partialamount" class="form-control" id="partialamount" placeholder="Partial Amount" disabled />
              </div>
              <div class="form-group">
                <label for="paymentType">Payment Type</label>
                <select name="paymentType" id="paymentType" class="form-control">
                  <option value="">Choose payment type</option>
                  <option value="cash">Cash</option>
                  <option value="cheque">Cheque</option>
                  <option value="account">Account Transfer</option>
                </select>
              </div>
              <div class="form-group">
                <label for="paymentDate">Payment Date</label>
                <input type="date" class="form-control" id="paymentDate" value="<?= date('Y-m-d') ?>" name="paymentDate" placeholder="Payment Date" />
              </div>
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

    $.validator.addMethod("validate", function(value) {
      return /[A-Za-z]/.test(value);
    });

    $("#addPaymentForm").validate({
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
      }

    });
  });
  // end here

  function dropAllInvoice() {

    let id = this.event.target.id;
    let pro = $('#' + id).val();

    $.ajax({
      type: "GET",
      url: "{{ route('SA-FetchAllInvoiceForPayments')}}",
      data: {
        "id": pro
      },
      success: function(response) {
        $('#invoiceNoPayments').html('');
        $('#invoiceNoPayments').append('<option value="">Select invoice no.</option>');
        jQuery.each(response, function(key, value) {
          $('#customer_id_payment_on').val(value["customer_name"]);
          $('#invoiceNoPayments').append(
            '<option value=' + value["invoice_no"] + '>' + value["invoice_no"] + '</option>'
          );
        });
      }
    });
  }

  function selectInvoiceNo() {
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
            //$('#partialamount').val(value['invoice_date']);
            $('#editAmount').val(value["total"]);
            $('#editAmount2').val(value["total"]);
            $('#invoicedaate').val(value["invoice_date"]);
            $('#editinvoicedaate').val(value["invoice_date"]);
          });
        }
      });
    }
  };

  // store data in db

  jQuery("#addPaymentForm").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
    });


    jQuery.ajax({
      url: "{{ route('SA-AddPayment') }}",
      data: jQuery("#addPaymentForm").serialize(),
      enctype: "multipart/form-data",
      type: "post",

      success: function(result) {
        if (result.error != null) {
          // jQuery(".alert-danger>ul").html(
          //         "<li> Info ! Please complete below mentioned fields : </li>"
          //     );
          // jQuery.each(result.error, function (key, value) {
          //     jQuery(".alert-danger").show();
          //     jQuery(".alert-danger>ul").append(
          //         "<li>" + key + " : " + value + "</li>"
          //     );
          // });
        } else if (result.barerror != null) {
          jQuery("#addPaymentAlert").hide();
          jQuery(".alert-danger").show();
          jQuery(".alert-danger").html(result.barerror);
        } else if (result.success != null) {
          jQuery(".alert-danger").hide();
          jQuery("#addPaymentAlert").html(result.success);
          jQuery("#addPaymentAlert").show();
          jQuery("#addPaymentForm")["0"].reset();
          getPaymentDetials();
          updateInvoice();
        } else {
          jQuery(".alert-danger").hide();
          jQuery("#addPaymentAlert").hide();
        }
      },
    });
  });
</script>