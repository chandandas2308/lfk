@extends('pos.layout.master')
@section('title','Dashboard | POS') 
@section('body')
 <main id="main" class="main">
  <div class="pagetitle">
    <h1 class="breadcrumb">Dashboard</h1>
  </div>
  <!-- End Page Title -->
  <section class="section dashboard" style="padding: 20px 30px">
    <!-- <h1>POS DASHBOARD</h1> -->
    <div class="row">
      <!-- Sales Card -->
      <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card" style="background-color: #ffab2d;">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded d-flex align-items-center justify-content-center">
                <i class="bi bi-cart"></i>
              </div>
              <div class="ps-4">
                <h6>{{ $todays }}</h6>
                <h5 class="card-title">Sales | <span class="small pt-1 fw-bold" style="color: #cb0202 !important;">Today</span>
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Sales Card -->
      <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card" style="background-color: #f26722;">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded d-flex align-items-center justify-content-center">
                <i class="bi bi-cart"></i>
              </div>
              <div class="ps-4">
                <h6>{{ $last_month }}</h6>
                <h5 class="card-title">Sales | <span class="small pt-1 fw-bold" style="color: #fff59d !important;">Last Month</span>
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Revenue Card -->
      <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card" style="background-color: #f26722;">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded d-flex align-items-center justify-content-center">
                <i class="bi bi-cart"></i>
              </div>
              <div class="ps-4">
                <h6 style="color: #fff59d!important;">{{ $this_month }}</h6>
                <h5 class="card-title">Sale <span class="small pt-1 fw-bold" style="color: #fff59d !important;">| This Month</span>
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card" style="background-color: #ffab2d;">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded d-flex align-items-center justify-content-center">
                <i class="bi bi-bag"></i>
              </div>
              <div class="ps-4">
                <h6 style="color: #fff59d!important;">{{ $total_products }}</h6>
                <h5 class="card-title">Products <span class="small pt-1 fw-bold" style="color: #cb0202 !important;">| Available</span>
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- End Revenue Card -->
      <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card" style="background-color: #ffab2d;">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded d-flex align-items-center justify-content-center">
                <i class="bi bi-list-check"></i>
              </div>
              <div class="ps-4">
                <h6>{{ $total_customer }}</h6>
                <h5 class="card-title">Customers <span class="small pt-1 fw-bold" style="color: #cb0202 !important;">| Total</span>
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Sales Card -->
      
      <!-- End Revenue Card -->
      <div class="col-xxl-4 col-md-6">
        <div class="card info-card sales-card" style="background-color: #f26722;">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="card-icon rounded d-flex align-items-center justify-content-center">
                <i class="bi bi-list-check"></i>
              </div>
              <div class="ps-4">
                <h6>{{ $this_month_customer }}</h6>
                <h5 class="card-title">Customers <span class="small pt-1 fw-bold" style="color: #fff59d !important;">| This Month</span>
                </h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Sales Card -->
    </div>
  </section>
</main> @endsection