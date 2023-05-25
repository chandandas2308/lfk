@extends('frontend.layouts.master')
@section('title', 'LFK | Contact Us')
@section('body')

    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="/">{{ __('lang.home') }}</a></li>
                        <li class="active">{{ __('lang.contact_us') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="" style="margin-bottom: 40px;">
        <div class="title text-center">
            <h2>{{ __('lang.get_in_touch') }}</h2>
        </div>
        <div class="contact-section">
            <div class="container">
                <div class="row">
                    <div class="contact-details col-md-12">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.7307654169663!2d103.8951676500185!3d1.3378164619826145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da17ee80a90b9d%3A0x1f434b465b1de4ec!2sGordon%20Warehouse%20Building!5e0!3m2!1sen!2sin!4v1677002109676!5m2!1sen!2sin"
                            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <ul class="contact-short-info">
                            <li>
                                <i class="fa fa-home"></i>
                                <span>
                                    <!-- 8 @ Tradehub 21, 8 Boon Lay Way, #02-14, Singapore 609964. -->
                                    9 Kaki Bukit Road 2, #01-17, Gordon Warehouse Building Singapore 417842
                                </span>
                            </li>
                            <li>
                                <i class="fa fa-whatsapp"></i>
                                <span>Whatsapp:<a href="https://wa.me/6588393132?text=" target="_blank" style="color: #0068f6;"> +65 8839 3132</a></span>
                            </li>
                            <li>
                                <i class="fa fa-envelope"></i>
                                <span>Email: admin@lfk.sg</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

@section('javascript')
    <script>
        $(document).ready(function() {
            if ("{{ !empty(session('success')) }}") {
                successMsg("{{ session('success') }}");
            }
            if ("{{ !empty(session('error')) }}") {
                errorMsg("{{ session('error') }}")
            }
        })
    </script>
@endsection
@endsection
