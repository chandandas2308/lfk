<footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2022 CSS OFFICE SOLUTIONS PTE LTD</span>
  </div>
</footer>
</div>
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{ asset('backend/vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{ asset('backend/vendors/chart.js/Chart.min.js')}}"></script>
<script src="{{ asset('backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('backend/vendors/flot/jquery.flot.js')}}"></script>
<script src="{{ asset('backend/vendors/flot/jquery.flot.resize.js')}}"></script>
<script src="{{ asset('backend/vendors/flot/jquery.flot.categories.js')}}"></script>
<script src="{{ asset('backend/vendors/flot/jquery.flot.fillbetween.js')}}"></script>
<script src="{{ asset('backend/vendors/flot/jquery.flot.stack.js')}}"></script>
<script src="{{ asset('backend/vendors/flot/jquery.flot.pie.js')}}"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('backend/js/off-canvas.js')}}"></script>
<script src="{{ asset('backend/js/hoverable-collapse.js')}}"></script>
<script src="{{ asset('backend/js/misc.js')}}"></script>
<script src="{{ asset('backend/js/bootbox.min.js')}}"></script>

<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('backend/js/dashboard.js')}}"></script>


<!-- jQuery CDN -->
<!-- <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script> -->

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
      integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

        <script>

            AOS.init({
                duration: 1400,
            })

            function errorMsg(msg) {
                toastr.error(msg);
            }
            
            function successMsg(msg) {
                toastr.success(msg);
            }

            function show_error_msg(error) {
                if (error.status == 422) {
                    var err = error.responseJSON.errors;
                    var message = "";
                    $.each(err, function(index, value) {
                        message += value + '<br>';
                    });
                    errorMsg(message)
                }
            }


            $('.close').on('click', function(){
                $('label.error').hide();
                $('input').removeClass('error');
            });

            $('.alert > .close').on('click', function(){
                $(this).parent().hide();
            });
        </script>
        <script>
          document.getElementById("btnPrint").onclick = function () {
    printElement(document.getElementById("printThis"));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}

</script>

    <script type="text/javascript" src="{{ asset('datatables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('datatables/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('datatables/js/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('datatables/js/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('datatables/js/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('datatables/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('datatables/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('datatables/js/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('datatables/js/dataTables.responsive.min.js') }}"></script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <!-- <script type="text/javascript" src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.js"></script> -->
    
    <!-- backend js file -->
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4ZAnRQVqooGNvRLwtmXX-8RyEvHdwoQ4&callback=initMap&v=weekly" defer></script> -->
    @yield('javascript')
</html>