 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">
   
  
   <div class="side-navbar" id="sidebar-nav">
     <div class="row mt-2">

       <div class="col-md-12">
            <div class="mx-7 mb-3">
              <a href="{{url('/pos/pos-dashboard')}}">
                <div class="nav-box {{ (request()->is('pos/pos-dashboard')) ? 'active' : '' }}">
                  <i class="fa fa-home" aria-hidden="true"></i>
                  <p>Dashboard</p>
                </div>
              </a>
            </div>
       </div>

       <div class="col-md-12">
            <div class="mx-7 mb-3">
              <a href="{{url('/pos/showcustomer')}}">
                <div class="nav-box {{ (request()->is('pos/showcustomer')) ? 'active' : '' }}">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  <p>Customers</p>
                </div>
              </a>
            </div>
       </div>


       {{-- 
       <div class="col-md-12" >
         <div class="mx-7 mb-3 ">
           <a href="#" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" style="display: contents !important; text-align: center !important;">
             <div class="nav-box {{ (request()->is('pos/customer')) ? 'active' : '' }}">
               <i class="fa fa-user" aria-hidden="true"></i>
               <p>Customer</p>
               <br>
               <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
                 <div class="accordion-body">
                   <a href="{{url('/pos/customer')}}">
                     <i class="fa-solid fa-plus"></i>
                     <p>Add</p>
                     <!-- <span>Add</span> -->
                   </a>
                   <br>
                   <a href="{{url('/pos/showcustomer')}}">
                     <i class="fa-solid fa-users"></i>
                     <p>Total</p>
                     <!-- <span>Show</span> -->
                   </a>
                 </div>
               </div>
             </div>
           </a>
         </div>
       </div>
       --}}
      
     </div>
     <div class="row mt-2">
       
     <div class="col-md-12">
         <div class="mx-7 mb-3">
           <a class="{{ Request::is('/pos/sales/orders-dashboard') ? 'active':''}}" href="{{route('pos.viewOrdersDashboard')}}">
             <div class="nav-box {{ (request()->is('pos/sales/orders-dashboard')) ? 'active' : '' }}">
             <i class="fa fa-bag-shopping"></i>
               <p>Start Session</p>
             </div>
           </a>
         </div>
       </div>

       <div class="col-md-12">
         <div class="mx-7 mb-3">
           <a href="{{route('Pos-SalesShow')}}" class="{{ Request::is('pos/pos-sales') ? 'active':''}}">
             <div class="nav-box {{ (request()->is('pos/pos-sales')) ? 'active' : '' }}">
               <i class="fa fa-bag-shopping"></i>
               <p>Sales Show</p>
             </div>
           </a>
         </div>
       </div>
     </div>
     <div class="row mt-2">
       <div class="col-md-12">
         <div class="mx-7 mb-3">
           <a href="{{url('/pos/product')}}">
             <div class="nav-box  {{ (request()->is('pos/product')) ? 'active' : '' }}">
               <i class="fa fa-cube" aria-hidden="true"></i>
               <p>Products</p>
             </div>
           </a>
         </div>
       </div>
       <div class="col-md-12">
         <div class="mx-7 mb-3">
           <a href="{{url('/pos/stock')}}">
             <div class="nav-box {{ (request()->is('pos/stock')) ? 'active' : '' }}">
             <i class="fa fa-boxes-stacked"></i>
               <p>Stock</p>
             </div>
           </a>
         </div>
       </div>
     </div>
     <!-- <div class="row mt-3"><div class="col-md-12"><div class="mx-7 mb-3"><a href="../products2.html"><div class="nav-box"><i class="fa fa-cubes" aria-hidden="true"></i><p>Products</p></div></a></div></div><div class="col-md-12"><div class="mx-7 mb-3"><a href="../services2.html"><div class="nav-box"><i class="fa fa-scissors" aria-hidden="true"></i><p>Services</p></div></a></div></div></div> -->
     <!-- <div class="row mt-3"><div class="col-md-6"><a href="../report.html"><div class="nav-box"><i class="fa fa-file-text" aria-hidden="true"></i><p>Report</p></div></a></div><div class="col-md-6"><a href="../stock.html"><div class="nav-box"><i class="fa fa-line-chart" aria-hidden="true"></i><p>Stock</p></div></a></div></div> -->
   </div>
   
 </aside>
 <!-- End Sidebar-->