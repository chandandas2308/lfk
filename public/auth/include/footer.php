<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript" src="js/lightbox-plus-jquery.js"></script>
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            margin: 10,
            loop: true,
            nav: true,
            navText: [
                '<i class="fa fa-angle-left"></i>',
                '<i class="fa fa-angle-right"></i>'
            ],
            dots: true,
            autoplay: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 3,
                    nav: true,
                    loop: true
                }
            }
        });
    })
</script>
</body>


</html>