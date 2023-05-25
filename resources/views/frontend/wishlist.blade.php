@extends('frontend.layouts.master')
@section('title','LFK | Wishlist ')
@section('body')

<section class="bg-gray page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="active">Wishlist</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="" style="margin-bottom: 40px;">
    <div class="title text-center">
        <h2>Wishlist</h2>
    </div>
    <div class="container">


    <div class="container">

    

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <div class="row">
          <div class="col-md-2">
              <div class="card">
              <ul class="user-profile-list-main bg-main" style="padding:30px; margin-top: 70px;">
                  <!-- <li class="underline"><a href="{{ route('user.wishlists') }}" class="underline-a-{{ request()->is('user.wishlists') ? 'active' : '' }}">Wishlist</a></li> -->
                  <li class="underline"><a href="{{ route('user.loyality-points') }}" class="underline-a-{{ request()->is('user.loyality-points') ? 'active' : '' }}">Loyalty Points</a></li>
                  <li class="underline"><a href="{{ route('user.Address') }}" class="underline-a-{{ request()->is('/user/address') ? 'active' : '' }}">Address</a></li>
                  <li class="underline"><a href="{{ route('user.order-history') }}" class="underline-a-{{ request()->is('user.order-history') ? 'active' : '' }}">Order History</a></li>
                </ul>
              </div>
            
            </div>
            <div class="col-md-10">
              <div class="dashboard-wrapper user-dashboard">
                <div class="media">
                  <div class="pull-left">
                    <!-- <img class="media-object user-img" src="{{ asset('frontend/images/avater.jpg') }}" alt="Image" /> -->
                  </div>
                </div>
                <div class="total-order mt-20">
                  <!-- <h4 style="color:#ec1c24; font-weight: 500;">Wishlist Items</h4> -->
                  <div class="table-responsive wishlist-table">
                    <table class="table" id="wishlist_details_table">
                      <thead style="background-color: #fac0a4;">
                        <tr>
                          <th>S/N</th>
                          <th>Image</th>
                          <th>Product Name</th>
                          <th>Total Price</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <!--  -->
                </div>
              </div>

            </div>
           
          </div>
        </div>
       
        
        
        
        
      </div>
    </div>

  </div>
</section>
<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$(document).ready(function() {
    wishlists = $('#wishlist_details_table').DataTable({
      "aaSorting": [],
      rowReorder: {
        selector: 'td:nth-child(2)'
      },
      // responsive: 'false',
      // dom: "Bfrtip",
      ajax: {
        url: "{{ route('user.wishlists') }}",
        type: 'get'
      },
    })
  });
  
  function removeFromWishlist(user_id, product_id) {
    $.ajax({
      url: "{{ route('SA-RemoveWishlist') }}",
      type: "get",
      data: {
        "user_id": user_id,
        "product_id": product_id
      },
      success: function(data) {
        toastr.success(data.success);
        wishlists.ajax.reload();
      },
      error: function(data) {
        toastr.success(data.error);
      }
    })
  }
  </script>

@endsection