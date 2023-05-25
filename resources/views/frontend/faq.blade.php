@extends('frontend.layouts.master')
@section('title','LFK | FAQ')
@section('body')

<section class="bg-gray page-header">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <ol class="breadcrumb">
            <li><a href="/">{{ __('lang.home') }}</a></li>
            <li class="active">FAQs</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  
 <div class="faq">
 <div class="container">
 <div class="title text-center">
 <h2>Frequently Asked Questions</h2>
    </div>


<main class="faq-main">


  <div class="acc-container">

    <button class="acc-btn">What Products Are Sold By LFK?</button>
    <div class="acc-content">
      <p>
      LFK Singapore is an online grocery store selly products of Korean origin in Singapore.
      </p>
    </div>

    <button class="acc-btn">
    How can I check the Order History at LFK Singapore?
    </button>
    <div class="acc-content">
      <p>
      We have provided the link to <a href="{{ route('order-history') }}" style="color: #ec1c24c4;">check the order history</a>below in the footer as well as in the logged-in profile by clicking on the Order history menu.
      </p>
    </div>

    <button class="acc-btn">
    Mode of Payment Accepted By LFK Singapore?
    </button>
    <div class="acc-content">
      <p>
      We accept payment from debit cards, credits, net banking, and cash on delivery.
      </p>
    </div>

    <button class="acc-btn">
    How Order Delivery Is Done By LFK Singapore?
    </button>
    <div class="acc-content">
      <p>
      Any Person who places an order for a particular product and within that date places another order. Then all orders will be delivered on a particular date.
Example: If a person places an order on the 1st of the month and the delivery date is the 5th of the month and then places second order on the 3rd of the month, then both orders will be delivered on the 5th of the month.

      </p>
    </div>

    <button class="acc-btn">
    Is It Required To Pay For Delivery Charges for Each Order?

    </button>
    <div class="acc-content">
      <p>
      As we have mentioned that all orders will be delivered at the same time if they fall before the delivery date then a single charge will be required to pay.
      </p>
    </div>

    <button class="acc-btn">
    Will I Receive a Receipt for My Payment?
    </button>
    <div class="acc-content">
      <p>
      After a successful purchase, a receipt will be generated and will be delivered to the email of the purchaser.

      </p>
    </div>

    <button class="acc-btn">
    What are Loyalty Points?
    </button>
    <div class="acc-content">
      <p>
      For every successful purchase loyalty points are rewarded to the customer. These can be used to redeem discounts on purchases.

      </p>
    </div>

    <button class="acc-btn">
    Is Required To Save Banking Details?
    </button>
    <div class="acc-content">
      <p>
      No. We do not ask our customers to provide and store banking details on the website or any other platform.
      </p>
    </div>

    <button class="acc-btn">
    What Is Refund Policy?
    </button>
    <div class="acc-content">
      <p>
      In case of cancellation of the order, the refund will take approximately 7-14 days.
      </p>
    </div>
    <button class="acc-btn">
    What is the Minimum Amount To Avail of Free Delivery?

    </button>
    <div class="acc-content">
      <p>
      To avail of the benefits of free delivery, an order of a minimum of USD 70 is compulsory.
      </p>
    </div>
  </div>
</main>

</div>
 </div>
 

@endsection