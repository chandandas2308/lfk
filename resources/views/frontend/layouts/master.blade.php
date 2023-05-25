@include('frontend.layouts.head')
@include('frontend.layouts.menubar')
@yield('body')
@include('frontend.layouts.footer')
<script>
    var add_to_cart = "{{ __('lang.add_to_cart') }}";

    var buy_now = "{{ __('lang.buy_now') }}";
    var out_of_stock = "{{ __('lang.out_of_stock') }}";
</script>
@yield('javascript')

<script>
    $(document).ready(function() {
        setInterval(() => {
            check_all_product_details()
        }, 2000);
    });

    function check_all_product_details() {
        $.ajax({
            'url': "{{ route('check_all_product_details') }}",
            type: 'get',
            success: function(data) {
                // console.log(data)
            }
        });
    }
</script>
