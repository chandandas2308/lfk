<style>
    .d-flex.justify-content-between {
        display: flex;
        justify-content: space-between;
    }
</style>            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Order Details</h4>
            </div>

            <form class="text-left clearfix" id="addAddressForm2" method="POST">
                @csrf
                @php
                    $unit_no = DB::table('addresses')->where('id',$delivery_date->address_id)->first();
                @endphp
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <div style="font-weight: 500; color: black;">
                            Delivery Address<br> {{$address->address}} 
                            <br>
                            Unit No: {{ $unit_no->unit }}
                            <br>
                            Remark: {{ $notification->remark }}
                        </div>
                        <div style="font-weight: 500; color: black;">
                            Delivery Date<br> {{ $delivery_date->delivery_date }}
                        </div>
                    </div>
                    <hr>
                    <div style="overflow: auto;">
                        <table id="orderProductDetails" class="text-center">
                            <thead>
                                <tr>
                                    <th>Product Image</th>                      
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Product Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <a class="btn-sm btn-primary" target="_blank" style="background-color: #d35a1f;border-color: #f56025;" href="{{ route('SA-GenerateOnlineSaleInvoicePDFUser',$consolidate_order_no) }}">Download Invoice</a>
                        </div>
                        <div style="font-weight: 500; color: black;">
                            Sub Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ${{ number_format($sub_total,2) }} <br>
                            Shipping Charge&nbsp;&nbsp;&nbsp;: ${{ $shipping_charge }} <br>
                            @if(!empty($voucher_code))
                                Voucher Amount&nbsp;&nbsp;&nbsp;: ${{ number_format($voucher_code->discount_amount,2) }} <br>
                            @endif
            
                            Total Amount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: ${{ number_format($final_price,2)}}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-small btn-solid-border" data-dismiss="modal">Close</button>
                </div>
            </form>

            

<script>
        $('#orderProductDetails').dataTable({
            "aaSorting": [],
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                language: {
                    'paginate': {
                        'previous': '<span class="prev-icon"></span>',
                        'next': '<span class="next-icon"></span>'
                    },
                    search: "{{ __('lang.search') }}",
                    "emptyTable": "{{ __('lang.no_data_table') }}",
                },
                pageLength: 5,
                // responsive: 'false',
                dom: "Bfrtip",
                ajax: {
                    url: "{{ route('all_order_list') }}",
                    type: 'get',
                    data: {
                        consolidate_order_no: "{{ request()->id }}"
                    }
                },
        });
</script>