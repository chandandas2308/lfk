<style>
    .map_css {
        position: initial !important;
        overflow: auto !important;
    }

    #sortable {
        margin: 0;
        padding: 0;
        border: 1px dotted;
        /* width: 60%; */
        cursor: pointer;
    }

    #sortable li {
        margin: 0 3px 3px 3px;
        padding: 0.4em;
        padding-left: 1.5em;
        /* font-size: 1.4em; */
        /* height: 16px; */
    }

    #sortable li span {
        /* position: absolute; */
        margin-left: -1.3em;
    }
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<div class="p-3">
    <div class="content-wrapper pb-0 bg-white">

        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Route Planing
            </h4>
        </div>

        <div class="bg-white">
            <div class="row">
                <div class="col-md-12 row">
                    <!-- Driver -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="delivery_date1">Delivery Date</label>
                            <input type="text" name="delivery_date" id="delivery_date1" class="form-control delivery_date1" placeholder="dd-mm-yyyy" autocomplete="off">
                        </div>
                    </div>
                    <!-- end -->

                    <!-- Driver -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="driver_id">Driver</label>
                            <select name="driver_id" id="driver_id" class="form-control">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    <!-- end -->
                    <div class="col-md-12" style="min-height: 120px;">
                        <ol id="sortable" type="A"></ol>
                    </div>

                    <div class="col-md-12">
                        <input type="button" id="submit" class="btn-sm btn-primary" value="Check">
                    </div>

                </div>
                <div class="col-md-12 mt-2">
                    <div id="fix_section" style="width:100%; height:426px; position:relative; overflow: hidden;">
                        <div id="route_map"></div>
                    </div>
                    <div id="directions-panel" class="p-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4ZAnRQVqooGNvRLwtmXX-8RyEvHdwoQ4&callback=initMap&v=weekly" defer></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#sortable").sortable({
                items : "li:not('.unsortable')"
            });
            $("#sortable").disableSelection();
            
            $('.select_2_input').select2();
        });

        $(document).ready(function() {
            $('.delivery_date1').datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(date) {
                    $('#sortable').html('');
                    var prev_driver, new_driver, arr = [],
                        arr1 = [];

                    $('#driver_id').html('');
                    $('#driver_id').append(`<option value="">Select</option>`);

                    $.ajax({
                        url: "{{route('SA-DriversList')}}",
                        method: "GET",
                        data: {
                            delivery_date: date,
                        },
                        beforeSend : function(){
                            $('#driver_id').append(`<option value="">Fetching...</option>`);
                        },
                        success: function(response) {
                            $('#driver_id').html('');
                            $('#driver_id').append(`<option value="">Select</option>`);
                             $.each(response.drivers, function(key, value) {
                                $('#driver_id').append(`<option value="${value.driver_id}">${value.driver_name}&nbsp;&nbsp;{\Total Orders : ${value.total_order} \}</option>`);
                            })
                            
                            // $.each(response.drivers, function(key, value) {
                            //     prev_driver = new_driver;
                            //     new_driver = value.id;

                            //     if (prev_driver != new_driver) {
                            //         arr.push(value.id);
                            //     }
                            // })

                            // arr1 = arr.filter((item, index) => arr.indexOf(item) === index);

                            // updateDriver();

                            // function updateDriver() {
                            //     $.each(arr1, function(key, value) {

                            //         var count = 0;
                            //         $.each(response.driver_list, function(key, value1) {
                            //             // console.log(value1.id);
                            //             if (value1.id == value) {

                            //                 $.ajax({
                            //                     url: "{{route('SA-DriversCountOrders')}}",
                            //                     method: "GET",
                            //                     data: {
                            //                         delivery_man_user_id: value1.id,
                            //                         date:date
                            //                     },
                            //                     beforeSend : function(){
                            //                         $('#driver_id').append(`<option value="">Fetching...</option>`);
                            //                     },
                            //                     success: function(response) {
                            //                         $('#driver_id').html('');
                            //                         $('#driver_id').append(`<option value="">Select</option>`);

                            //                         count = response.count;

                            //                         $('#driver_id').append(`
                            //                                 <option value="${value1.driver_id}">${value1.driver_name}&nbsp;&nbsp;{\Total Orders : ${count} \}</option>
                            //                             `);
                            //                     }
                            //                 });
                            //             }
                            //         });

                            //     });

                            // }

                        }
                    });

                }
            });
        });

        setTimeout(() => {
            $('#route_map').addClass('map_css');
        }, 3000);

        $('#driver_id').on('change', function() {
            var driver_id = $(this).val();

            $('#sortable').html('');
            $('#sortable').append(`
                            <li class=" unsortable ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                                9 Kaki Bukit Road 2, Gordon Warehouse Building, Singapore 417842, Singapore
                            </li>
            `);

            $.ajax({
                url: "{{route('SA-DriversDeliveries')}}",
                method: "GET",
                data: {
                    driver_id: driver_id,
                    date:$('#delivery_date1').val()
                },
                success: function(response) {
                    $.each(response.deliveries, function(k,v){
                        $('#sortable').append(`
                            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>${ v.delivery_address }</li>
                        `);
                    })
                }
            });

        });

        function initMap() {
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer({
                preserveViewport: true
            });

            const map = new google.maps.Map(document.getElementById("route_map"), {

                zoom: 12,
                center: {
                    // lat: 1.3378111,
                    // lng: 103.8973617
                    lat:1.3521,
                    lng:103.8198
                },
            });

            directionsRenderer.setMap(map);
            document.getElementById("submit").addEventListener("click", () => {
                calculateAndDisplayRoute1(directionsService, directionsRenderer);
            });
        }

        var addresses1 = [];

        function calculateAndDisplayRoute1(directionsService, directionsRenderer) {
            const waypts = [];
            var addresses = [];

            // addresses.push('9 Kaki Bukit Road 2, Gordon Warehouse Building, Singapore 417842, Singapore');

            $('#sortable > li').each(function() {
                addresses.push($(this).text());
            });

            if(addresses.length > 2){
                for (let i = 1; i < addresses.length; i++) {
                    waypts.push({
                        location: addresses[i],
                        stopover: true,
                    });
                }
            }
            console.log(waypts);
            directionsService
                .route({
                    origin: addresses[0],
                    destination: addresses[addresses.length - 1],
                    waypoints: waypts,
                    // optimizeWaypoints: true,
                    optimizeWaypoints: false,
                    travelMode: google.maps.TravelMode.DRIVING,
                })
                .then((response) => {

                    directionsRenderer.setDirections(response);

                    const route = response.routes[0];

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                    });

                    $.ajax({
                        url: "{{route('SA-StoreDeliveryRoute')}}",
                        method: "POST",
                        data: {
                            addresses1: addresses,
                            addresses: response.geocoded_waypoints,
                            driver_id: $('#driver_id').val(),
                            delivery_date: $('#delivery_date1').val(),
                        },
                        beforeSend: function() {
                            $('#saveRoute').val('Loading');
                        },
                        success: function(response) {
                            $('#saveRoute').val('Save Route');
                            if (response.status == "success") {
                                toastr.success(response.message);
                            }
                        },
                        error: function(error) {
                            $.each(error.responseJSON.errors, function(k, v) {
                                toastr.error(v[0]);
                            })
                        }
                    });

                    const summaryPanel = document.getElementById("directions-panel");

                    summaryPanel.innerHTML = "";

                    for (let i = 0; i < route.legs.length; i++) {
                        const routeSegment = i + 1;

                        summaryPanel.innerHTML +=
                            "<b>Route Segment: " + routeSegment + "</b><br>";
                        summaryPanel.innerHTML += route.legs[i].start_address + " to ";
                        summaryPanel.innerHTML += route.legs[i].end_address + "<br>";
                        summaryPanel.innerHTML += route.legs[i].distance.text + "<br><br>";
                    }
                })
                .catch((e) => console.log("Directions request failed due to " + e));
        }

        window.initMap = initMap;
    </script>