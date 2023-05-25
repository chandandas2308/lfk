@extends('pos.layout.master')
@section('title','Customers | POS')

<head>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>

@section('body')

<main id="main" class="main">
    <div class="pagetitle">
        <h1> Customer Details</h1>
    </div>

    <section class="section customer">
        <div class="row">
            <div class="col-12">
                   <a href="javascript:void(0)" class="nav-link bg-addbtn mx-2 rounded float-end" data-bs-toggle="modal" data-bs-target="#addCustomer">Add Customer</a>
            </div>
            <div class="table table-responsive mt-2">
                    <table class="table table-borderd" id="customer_all_list_table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>NAME</th>
                                <th>E-MAIL</th>
                                <th>Mobile No.</th>
                                <th>ADDRESS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                   </table>
            </div>

            <!--  -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Customer Details</h5>
                            <!-- // <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                            <button type="button" data-bs-dismiss="modal" class="btn btn-none">X</button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <label for="name" class="form-label mt-2" >NAME :</label>
                                            <input type="text" id="cust-name" name="cust-name" class="form-control" disabled>
                                        </div>
                                    </div> 
                                    <div class="col-12 mt-3">
                                      <div class="row">
                                            <label for="email" class="form-label mt-2" >EMAIL :</label>
                                            <input type="text" id="cust-email" name="cust-email" class="form-control" disabled>
                                      </div>
                                    </div> 
                                    <div class="col-12 mt-3">
                                        <div class="row">
                                            <label for="mobile" class="form-label mt-2" >MOBILE NO :</label>
                                            <input type="text" name="cust-mobile" id="cust-mobile" class="form-control" disabled></span>
                                        </div>
                                    </div> 
                                    <div class="col-12 mt-3">
                                        <div class="row">
                                            <label for="address" class="form-label mt-2" >ADDRESS :</label>
                                            <input type="text" name="cust-address" id="cust-address" class="form-control" disabled></span>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="bg-addbtn  mx-2 rounded" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>
    </section>
</main>

<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

@include('pos.add-customer');

<!-- update-customer -->
<div class="modal fade" id="updateCustomerModal" tabindex="-1">
  <div class="modal-dialog modal-lg" style="width: 800px;">
    <div class="modal-content" id="updateCustomerDetails2"></div>
  </div>
</div>
<!-- end modal here -->

<script>

$(document).ready(function(){
    customer_all_list_table = $('#customer_all_list_table').DataTable({
        "aaSorting": [],
        rowReorder: {
            selector: 'td:nth-child(2)'
        },

        // responsive: 'false',
        // dom: "Bfrtip",

        ajax: {
            url: "{{ route('pos.allCustomersList') }}",
            type: 'get',
            data: {
                status : "{{$order_number}}"
            }
        },        
    });
})

$(document).on('click', '#viewCustomerDetails', function(){
    $.ajax({
        url : $(this).data("url"),
        type : "GET",
        success : function(data){
            $('#updateCustomerModal').modal('show');
            $('#updateCustomerDetails2').html(data);
        }
    })
})

$(document).on('click', '#updateCustomerDetails', function(){
    $.ajax({
        url : $(this).data("url"),
        type : "GET",
        success : function(data){
            $('#updateCustomerModal').modal('show');
            $('#updateCustomerDetails2').html(data);
        }
    })
})

    $(document).on('click','#removeCustomer', function(){

        let id = $(this).data('id');

        bootbox.confirm({
              size: "large",
              message: "DO YOU WANT TO DELETE?",
              callback: function(result){
                if (result) {
                    $.ajax({
                        url : "/pos/delete-customer/"+id,
                        type : "GET",
                        success : function(data){
                            customer_all_list_table.ajax.reload();
                            if(data.status){
                                toastr.success(data.success);
                            }else{
                                toastr.error(data.error);
                            }
                        }
                    })
                }
            }
        })
    })

    
        

        
    
</script>

@endsection