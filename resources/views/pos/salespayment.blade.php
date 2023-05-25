@extends('pos.layout.master')
@section('title','Customer | POS')
<style>
  .active{
    background-color: #e5e5e5;
  }
</style>
@section('body')
  <main id="main" class="main">
    <div class="pos">
      <div class="pos-topheader">
        <div class="pos-branding">
          <div class="ticket-button">
            <a href="{{ route('pos.viewOrdersDashboard') }}" style="color:#000;">
              <div class="with-badge" badge="{{ $total_orders }}">
                <i class="fa fa-ticket" aria-hidden="true"></i>
                Orders
              </div>
            </a>
          </div>
        </div>
      </div>
      <div class="pos-content">
        <div class="window">
          <div class="subwindow">
            <div class="subwindow-container">
              <div class="subwindow-container-fix screens">
                <div class="payment-screen screen">
                  <div class="screen-content">
                    <div class="top-content">
                      <div class="button back">
                        <i class="fa fa-angle-double-left fa-fw"></i>
                        <a class="back_text" href="{{URL::previous()}}">Back</a>
                      </div>
                      <div class="top-content-center">
                        <h1>Payment</h1>
                      </div>
                    </div>
                    <div class="main-content">
                      <div class="left-content">
                        <div class="paymentmethods-container">
                          <div class="paymentmethods">
                            <p class="title-category">Payment method</p>
                            <div class="button paymentmethod" id="method">
                              <div class="payment-name" id="cash" data-value="Cash">Cash</div>
                            </div>
                            <div class="button paymentmethod" id="method">
                              <div class="payment-name" id="bank" data-value="Bank">Bank</div>
                            </div>
                            <div class="button paymentmethod" id="method">
                              <div class="payment-name" id="customer_account" data-value="Customer_Account">Customer Account</div>
                            </div>
                          </div>
                          <div class="paymentlines">
                            <p class="title-category">Summary</p>
                          </div>
                          <div class="paymentlines2">
                             
                          </div>
                        </div>
                        <button class="button next validation">
                            <div class="pay-circle">
                              <i class="fa fa-chevron-right" role="img" aria-label="Pay" title="Pay"></i>
                            </div>
                            <span class="next_text">Validate</span>
                        </button>
                      </div>
                      <div class="center-content">
                        <section class="paymentlines-container">
                          <div class="paymentlines-empty" id="payment-section">
                            <div class="total">$<span id="id">{{ $sum }}</span></div>
                            <div class="message"> Please select a payment method. </div>
                          </div>
                        </section>
                        <div class="payment-buttons-container">
                          <section class="payment-numpad">
                            <div class="numpad">
                              <button class="input-button button number-char" data-number="1">1</button>
                              <button class="input-button button number-char" data-number="2">2</button>
                              <button class="input-button button number-char" data-number="3">3</button>
                              <button class="mode-button button" data-number="10">+10</button>
                              <button class="input-button button number-char" data-number="4">4</button>
                              <button class="input-button button number-char" data-number="5">5</button>
                              <button class="input-button button number-char" data-number="6">6</button>
                              <button class="mode-button button" data-number="20">+20</button>
                              <button class="input-button button number-char" data-number="7">7</button>
                              <button class="input-button button number-char" data-number="8">8</button>
                              <button class="input-button button number-char" data-number="9">9</button>
                              <button class="mode-button button" data-number="50">+50</button>
                              <button class="input-button number-char" >+/-</button>
                              <button class="input-button button number-char" data-number="0">0</button>
                              <button class="input-button button number-char" data-number=".">.</button>
                              <button class="input-clear number-char">
                                <img src="{{ asset('pos/assets/img/backspace.png') }}" width="24" height="21" alt="Backspace">
                              </button>
                            </div>
                          </section>
                        </div>
                      </div>
                      @php $user = DB::table('pos__orders')->where('order_no', $order_number)->first() @endphp
                      <div class="right-content">
                        <div class="payment-buttons">
                          <div class="partner-button">
                            <a href="#" class="button">
                              <i class="fa fa-user" role="img" title="Customer"></i>
                              <span>{{ $user->customer_name }}</span>
                              </a>
                          </div>
                          <div class="payment-controls">
                            <a href="#" class="button js_invoice">
                              <i class="fa fa-file-text-o"></i> Invoice
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="popups" hidden=""></div>
    </div>
    <div>
      <div class="o_effects_manager"></div>
      <div class="o_dialog_container">
        <div></div>
      </div>
      <div class="o_notification_manager"></div>
      <div></div>
      <div class="o_notification_manager o_upload_progress_toast"></div>
      <div class="o_popover_container"></div>
      <div class="o_fullscreen_indication">
        <!-- <p>Press <span>esc</span> to exit full screen </p> -->
      </div>
    </div>
  </main>

<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>

<script>

    let type = "Cash";
    let value;
    let actionArr = [];
    let bill_amount = "{{$sum}}";

      $("#method > .payment-name").on('click', function(){
        type = $(this).data('value');
        $(this).parent().parent().find('.active').removeClass('active');
        $(this).addClass('active');
        $('.paymentlines2').find('.'+type).attr('id', 0);
      })

      $(".numpad > .button").on('click', function(){
        value = $(this).data('number');

        const id = $('.paymentlines2').find('.'+type).attr('id');

        let status = actionArr.some(function(o){return o["type"] === type});
        
        if(status != true){
          actionArr.push({
            "type":type,
            "value":value,
          })
        }else{
          var foundIndex = actionArr.findIndex(x => x.type == type);
          if(id == 1){
            if(value == 10 || value == 20 || value == 50){
              actionArr[foundIndex]["value"] = parseFloat(actionArr[foundIndex]["value"])+value;
            }else{
              actionArr[foundIndex]["value"] = actionArr[foundIndex]["value"]+''+value;
            }
          }else{
            // if(value == 10 || value == 20 || value == 50){
            //   actionArr[foundIndex]["value"] = parseFloat(actionArr[foundIndex]["value"])+value;
            // }else{
              actionArr[foundIndex]["value"] = value;
            // }
          }
        }
          topSection(actionArr);
      });

      function topSection(actionArr){

        $('#payment-section').html('');
        $('.paymentlines2').html('');
        let sum = 0;

        if(actionArr.length == 0){
          $('#payment-section').html(
            `
             <div class="total">$<span id="id">${bill_amount}</span></div>
             <div class="message"> Please select a payment method. </div>
             `
          );
        }

        $.each(actionArr, function(key, value){

          sum+=parseFloat(value["value"]);
          remaining_amount = parseFloat(bill_amount)-sum;

          $('#payment-section').html(`
            <div class="d-flex justify-content-between py-1" style="font-size: x-large;">
              <div><strong>Remaining</strong> $<span id="">${remaining_amount.toFixed(2)<0?'0.00':remaining_amount.toFixed(2)}</span></div>
              <div><strong>Change</strong> $<span>${remaining_amount.toFixed(2)<0?Math.abs(remaining_amount.toFixed(2)): '0.00'}</span></div>
            </div>
            <div class="text-muted" style="font-size:initial;font-weight:600;">Total Due $${bill_amount}</div>
          `);

          $('.paymentlines2').append(`
            <div class="d-flex justify-content-between p-1 ${value["type"]}" id="0" data-index="${key}">
              <div>${value["type"]}</div>
              <div>
                $${parseFloat(value["value"])} &nbsp;&nbsp; <i id="removeElement" class="fa-solid fa-circle-xmark"></i>
              </div>
            </div>
          `);
          
        })

        if(sum >= bill_amount){
          $('.screen .button.next:not(.highlight)').css('opacity', 1);
          $('.screen .button.next:not(.highlight)').css('cursor', 'pointer');
          $('.screen .button.next:not(.highlight)').children().attr('id','getPayment');
          $('.screen .button.next:not(.highlight)').css('pointer-events', 'all');
        }else{
          $('.screen .button.next:not(.highlight)').css('opacity', 0.3);
          $('.screen .button.next:not(.highlight)').css('cursor', 'not-allowed');
          $('.screen .button.next:not(.highlight)').css('pointer-events', 'none');
          $('.screen .button.next:not(.highlight)').children().removeAttr('id');
        }

        $('.paymentlines2').children().attr('id', 1);
      }

      $(document).on('click','#removeElement', function(){
        const index = $(this).parent().parent().data('index');
        actionArr.splice(index, index==0?1:index);
        topSection(actionArr);
      })

      $(document).on('click', '.input-clear', function(){
        if(actionArr.length != 0){
          var foundIndex = actionArr.findIndex(x => x.type == type);
          let amount = actionArr[foundIndex]["value"];
          let myFunction = num => Number(num);
          var amount_arr = Array.from(String(amount), myFunction);
          amount_arr.pop();
          const final_amount = amount_arr.join('');
          
          if(final_amount == ''){
            actionArr[foundIndex]["value"] = 0;
          }else{
            actionArr[foundIndex]["value"] = final_amount;
          }
        }
        topSection(actionArr);
      })

      $(document).on('click', '#getPayment', function(){
        $.ajax({
          url : "{{route('pos.payment-sales-payment')}}",
          type : "GET",
          data : {
            order_number : "{{ $order_number }}",
            payments : actionArr
          },
          success:function(data){
            if(data.status){
              window.location.href=data.route;
            }else{
              toastr.error(data.message);
            }
          }          
        })
    })

</script>

@endsection