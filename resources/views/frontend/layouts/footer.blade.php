<!---Whats app icon-->
<a href="https://wa.me/6588393132?text=" class="float" target="_blank">
    <i class="fa fa-whatsapp my-float"></i>
</a>
<!---Whats app icon end-->

<footer class="footer section">
    <div class="footer-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-6">
                            <h4>{{ __('lang.ABOUT')  }}</h4>
                            <ul>
                                <li><a href="{{ route('contact-us') }}">{{ __('lang.contact_us') }}
                                    </a></li>
                                <li><a
                                        href="{{ route('about-us') }}">{{ __('lang.about_us') }}</a>
                                </li>
                                <li><a
                                        href="{{ route('AllProducts') }}">{{ __('lang.buy_now') }}!</a>
                                </li>
                                <li><a
                                        href="{{ route('faq') }}">{{ __('lang.FAQs') }}</a>
                                </li>
                                <!-- <li><a href="#">Carrers</a></li> -->
                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-6">
                            <h4>Services</h4>
                            <ul>
                                <li><a href="{{ route('user.loyality-points') }}">
                                        {{ __('lang.loyalty_points') }}</a></li>
                                <li><a
                                        href="{{ route('user.Address') }}">{{ __('lang.address') }}</a>
                                </li>
                                <li><a
                                        href="{{ route('user.order-history') }}">{{ __('lang.order_history') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-6">
                            <h4>{{ __('lang.POLICY') }}</h4>
                            <ul>
                                <li><a
                                        href="{{ route('return-refund') }}">{{ __('lang.return_policy') }}</a>
                                </li>
                                <li><a
                                        href="{{ route('terms-conditions') }}">{{ __('lang.terms_and_conditions') }}</a>
                                </li>
                                <li><a
                                        href="{{ route('data-protection-policy') }}">{{ __('lang.data_protection_policy') }}</a>
                                </li>
                                <li><a
                                        href="{{ route('privacy-policy') }}">{{ __('lang.privacy_policy') }}</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-md-4">
                    <h4>Registered Office Address:</h4>
                    <!-- <p> LFK SINGAPORE,8 @
                        Tradehub 21, 8
                        Boon Lay Way, #02-14,
                        Singapore 609964.
                    </p> -->
                    <p>
                    9 Kaki Bukit Road 2, 
                    #01-17, Gordon Warehouse Building
                    Singapore 417842
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <p class="" style="margin-top:20px;">
                    Copyright &copy;2022, Designed &amp; Developed by
                    <a href="https://www.cssoffice.sg/" class="text-info">CSS OFFICE SOLUTIONS PTE LTD</a>
                </p>
            </div>
            <div class="col-md-4 text-right">
            </div>
        </div>
    </div>
</footer>

<!--
    Essential Scripts
    =====================================-->

<!-- Main jQuery -->
<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.1 -->
<!-- <script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.min.js') }}"></script> -->

<script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/slick.min.js"></script>
<!-- Bootstrap Touchpin -->
<script src="{{ asset('frontend/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
<!-- Instagram Feed Js -->
<script src="{{ asset('frontend/plugins/instafeed/instafeed.min.js') }}"></script>
<!-- Video Lightbox Plugin -->
<script src="{{ asset('frontend/plugins/ekko-lightbox/dist/ekko-lightbox.min.js') }}"></script>
<!-- Count Down Js -->
<script src="{{ asset('frontend/plugins/syo-timer/build/jquery.syotimer.min.js') }}"></script>

<!-- slick Carousel -->
<script src="{{ asset('frontend/plugins/slick/slick.min.js') }}"></script>
<script src="{{ asset('frontend/plugins/slick/slick-animation.min.js') }}"></script>

<!-- Google Mapl -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCC72vZw-6tGqFyRhhg5CkF2fqfILn2Tsw"></script>
<script type="text/javascript" src="{{ asset('frontend/plugins/google-map/gmap.js') }}"></script>

<!-- Main Js File -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
    integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('frontend/js/action.js') }}"></script>

<script src="{{ asset('frontend/js/script.js') }}"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>

<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script src="{{ asset('frontend/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    // AOS.init({
    //   duration: 1200,
    // })

    AOS.init({
        duration: 1400,
    })

    function errorMsg(msg) {
        toastr.error(msg);
    }

    function successMsg(msg) {
        toastr.success(msg);
    }

    // toastr.success("success");

    // $(document).ready(function() {
    if ("{{ !empty(session('success')) }}") {
        // successMsg("{{ session('success') }}"
        toastr.success("{{ session('success') }}");
    }
    if ("{{ !empty(session('error')) }}") {
        // errorMsg("{{ session('error') }}")
        toastr.error("{{ session('error') }}");
    }
    // });

    $(document).ready(function() {
        if ("{{ !empty(session('msg')) }}") {
            errorMsg("{{ session('msg') }}")
        }
    })

    function single_error(error) {
        if (error.status == 422) {
            var err = error.responseJSON.errors;
            var message = "";
            $.each(err, function(index, value) {
                message += value + '<br>';
            });
            errorMsg(message)
        }
        if (error.status == 401) {
            window.location.href = "{{ route('login-with-us') }}";
            errorMsg('Please Login ');
        }
    }

    if("{{ !empty(session('back_message')) }}"){
        errorMsg("{{ session('back_message') }}")
    }
</script>

<script>
    function googleTranslateElementInit() {

        new google.translate.TranslateElement({

            pageLanguage: 'en',

            autoDisplay: 'true',

            includedLanguages: 'en,zh-CN',

            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL

        }, 'google_translate_element');

    }
</script>
<script src='//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit'></script>

<script>
    $(document).ready(function() {
        $('#userProfileViewOrderTable').DataTable();
        $('#userOrderSelfTable').DataTable();
        // $('#cartPageTable').DataTable();
    });
</script>

<script>
    AOS.init({
        duration: 1200,
    })
</script>
<script>
    // faq
    const btns = document.querySelectorAll(".acc-btn");

    // fn
    function accordion() {
        this.classList.toggle("is-open");
        const content = this.nextElementSibling;
        if (content.style.maxHeight) content.style.maxHeight = null;
        else content.style.maxHeight = content.scrollHeight + "px";
    }

    // event
    btns.forEach((el) => el.addEventListener("click", accordion));
</script>

</body>

</html>
