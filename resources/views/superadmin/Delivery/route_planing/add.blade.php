@extends('superadmin.layouts.master')
@section('title','Assign Route | LFK')
@section('body')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<style>
    .map_css {
        position: initial !important;
        overflow: auto !important;
    }

    #sortable {
        list-style-type: none;
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
<div class="main-panel">
    <div class="content-wrapper pb-0 bg-white">
        <!-- user management header -->
        <div class="page-header flex-wrap px-5">
            <h3 class="mb-0">
                Assign Route
            </h3>
        </div>
        <!-- <form id="assignRoutePlaningForm"> -->

        <div class="bg-white">
            <div class="row">
                <div class="col-md-12 row">
                    <!-- Driver -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="delivery_date1">Delivery Date</label>
                            <input type="text" name="delivery_date" id="delivery_date1" class="form-control delivery_date1" placeholder="dd-mm-yyyy">
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
                        <ul id="sortable">
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>125 JALAN SULTAN SINGAPORE 199011</li>
                    
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>555 Choa Chu Kang North 6, 新加坡 680555</li>
                    
                        <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>27A W Coast Park, Singapore 127721</li>
                        </ul>
                    </div>

                    <div class="col-md-12">
                        <input type="button" id="submit" class="btn-sm btn-primary" value="Check">
                    </div>

                </div>
                <div class="col-md-12 mt-2">
                    <div id="fix_section" style="width:100%; height:426px; position:relative; overflow: hidden;">
                        <div id="route_map"></div>
                    </div>
                    <!-- <div id="directions-panel"></div> -->
                </div>
            </div>
        </div>

        <!-- <div class="">
        <button type="reset" class="btn btn-secondary">Clear</button>
        <button type="submit" id="submit1" class="btn btn-primary">Save</button>
    </div> -->
    </div>
    <!-- </form> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4ZAnRQVqooGNvRLwtmXX-8RyEvHdwoQ4&callback=initMap&v=weekly" defer></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        
        $(function() {
            // $("#sortable").sortable();
        });

        $(document).ready(function() {
            $('.delivery_date1').datepicker({
                dateFormat: "dd/mm/yy",
                onSelect: function(date) {
                    // $('#sortable').html('');
                    var prev_driver, new_driver, arr = [],
                    arr1 = [];

                    $('#driver_id').html('');
                    $('#driver_id').append(`<option value="">Select</option>`);
                    @foreach($drivers1 as $key => $value)
                    if ("{{$value->delivery_date}}" == date) {
                        prev_driver = new_driver;
                        new_driver = "{{$value->id}}";

                        if (prev_driver != new_driver) {
                            arr.push("{{$value->id}}");
                        }
                    }

                    @endforeach

                    arr1 = arr.filter((item, index) => arr.indexOf(item) === index);

                    updateDriver();

                    function updateDriver() {
                        $.each(arr1, function(key, value) {

                            @foreach($drivers as $key => $value)
                            if ("{{$value->id}}" == value) {
                                $('#driver_id').append(`
                                    <option value="{{$value->id}}">{{ $value->driver_name }}</option>
                                `);
                            }
                            @endforeach

                        });

                    }
                }
            });
        });

        setTimeout(() => {
            $('#route_map').addClass('map_css');
        }, 3000);

        $('#driver_id').on('change', function() {
            var driver_id = $(this).val();

            // $('#sortable').html('');

            @foreach($deliveries as $key => $value)
            if ("{{$value->delivery_man_user_id}}" == driver_id) {
                $('#sortable').append(`
                <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{ $value->delivery_address }}</li>
            `);
            }
            @endforeach

        });

        function initMap() {
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer();

            const map = new google.maps.Map(document.getElementById("route_map"), {

                zoom: 13,
                center: {
                    lat: 1.3521,
                    lng: 103.8198
                },
            });

            directionsRenderer.setMap(map);
            document.getElementById("submit").addEventListener("click", () => {
                calculateAndDisplayRoute1(directionsService, directionsRenderer);
            });
        }

        function calculateAndDisplayRoute1(directionsService, directionsRenderer) {
            const waypts = [{
                location: "Geylang Bahru Singapore",
                stopover: true,
            }];

            var addresses = [];
            
            $('#sortable > li').each(function(){
                addresses.push($(this).text());
            });

            for (let i = 1; i < addresses.length-2; i++) {
                    waypts.push({
                        location: addresses[i],
                        stopover: true,
                    });   
            }

            directionsService
                .route({
                    origin: addresses[0],
                    destination: addresses[addresses.length-1],
                    waypoints: waypts,
                    optimizeWaypoints: true,
                    travelMode: google.maps.TravelMode.DRIVING,
                })
                .then((response) => {
                    directionsRenderer.setDirections(response);

                    const route = response.routes[0];
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
                .catch((e) => console.log("Directions request failed due to " + status));
        }

        window.initMap = initMap;
    </script>
    @endsection