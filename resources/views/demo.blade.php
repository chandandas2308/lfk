<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Leaflet Routing Machine Example</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <style>
        .map {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .demo {
            background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAApCAYAAADAk4LOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAN1wAADdcBQiibeAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAUlSURBVFjDrZdLiBxVFIb/e289uqt6kkx6zIiIoKgLRReKuMhCcaOIAUEIiCCE4CIPggZ8kBjooPgM0TiYEUUjqBGchZqAQlyYRTA+kJiJQiJGMjN5zYzT3dP1rrr3HBeTjDGTSfc8Dvyruud89Z9z6kIJdBj31763MivsJXKuZYF6dak5++2mh7NOcsXVHq6sHbhOK/24kOJJMO4AE1vKygwZhxlKSHGKiD+RSu09vOXB43OCrHz96y6T2lsh+OmKXzFdlbLne2UopSAupBhjECcZgjDMgiiSxPhcK/nCr1sfOtcWcm/tq9uEsL4rl0vdK67pKVu2jUwTMk0wBBAzpBCQAnAtiZIlwWQwPlHPglZQAFj1Y23VwVkh92zbd59U+Kanp+p2L12mooKQ5AbcpuclS6LiKoRhxOfHzhXMcs3PtVV7Z0DufXH/LSzpSG9vr1/p6kIz0dDUrvx/IYXAsrJCkWc4e/Z0Zpgf+KX26A/TkNtrXziesY9Xq8tvWNZdVfVYg7hzwKVv3O3ZiKMWj46OTrq5fdOh1x5pSADwjdzo2nbv0u6qqkca2jCIMGcZAuqRhu8vEX7ZK2V2WgMAcXdtvyeKbPS662+osCohzMycHVweniNREoShoZO5KYobpciSh23bFq7rIUgNiLFghRkBlg2v7GlpiccsCHrcryzxUk3zmsNskeYGvt/lxVH4hMWEu9xSWaQFYQ7L1B6iGZ5bBoy+zWKiHiltFHpqeIsVhWaosg1iqlgg4wAAEYEXsV3EmNppJmExMFYUxfVSuIs6E0sI5FkBBhLJzH9laQxLSjBj0WQJgSJPweDTkknvS4JGbCuxKOt7UY4lEQfNnAu9TzLxN2nUdAQTLAEw8YIlAVgAkmDCSBL75eCutSeY+GTUqqNkqUVxUbIl4qgJo4vWzecrhyQAMJldYf1MXLLl1EIsYBZgoGwpRI2zMTPtGBhYbSQAlJF9lieRzNMIriVBzPOWawvoIkYaNC0u9IcAIAHgp75NLQl8ENbPZJ6jgAU48RyFqHEuZyE+Pda/vjENAQBD5s209Y+kPJlyM4+r3lUS0AWSyVEhpHnjYu1pyO+7N4ywwPvhxHDiuwo8j1b5rkQwMZIziYHBXetPzIAAgIV8exZOSMoieI6aU5vKtgR0jqw1JtiYbZfW/R/kSN+mcWbxdtwYjn1XTd9B7cQAfNdCWB/OhBR7jvWv/3tWCAAoO3ktjyZZJ0HHbsq2AooERVQXzPKly2vOgPz29jNNBr+e1IcSz5YAM4hmFzPDtyWS+lDK4N2DfU+dbgsBAFHyd+oszE3agt/GjWcrUBEjj5sQBb96pXpXhAzueDJi4u1p41TsuQpCiFln4bkKeXMoJeadg++tG+sYAgBBXOo3RRrruAnfkWDmGfIdCeQhiiQgQbxjtlqzQk59vCZlNluL5lDiORLyMjcA4DsKeXM4AfDKxa97ThAAqPaMfaR1Nq6jOiqOAhOm5TsKJg1QZGGRedY7V6tzVcjBWk1D0JZ8cigt2RJSimkXnqOgW8MxQLUTb6wN5g0BgGPV0c9BekTH41xx5YXrQ8FkTRgdpxU7ea9djbYQ1GokmJ43wUhWtgRcS04tQjAcw9CWw29tThYOAXD03XVfMps/TTTOy30blDZgiqxFK6p7OsnvCDJ1UD9LyUjORoPDkUQyPfdHbXW+qJCjfRsOwOAoNY4z6Xz01rHq3k5zO4ZMHTabYSIhJD87MLB64f8Ys8WdG/tfBljMJedfwY+s/2P4Pv8AAAAASUVORK5CYII=') !important;
            margin-left: -12px !important;
            margin-top: -41px !important;
            width: 25px !important;
            height: 41px !important;
            /* transform: translate3d(737px, 82px, 0px) !\; */
            /* z-index: 82 !important; */
        }
    </style>
</head>

<body>
    <div id="map" class="map"></div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.2.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script>
        // var map = L.map('map');

        // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     attribution: 'Map data © contributors, '
        // }).addTo(map);

        // L.Routing.control({
        //     waypoints: [
        //         L.latLng(57.74, 11.94),
        //         L.latLng(57.6792, 11.949),
        //         L.latLng(57.5792, 11.849)
        //     ],

        //     routeWhileDragging: true,
        //         draggableWaypoints: false,
        //         addWaypoints: false
        // }).addTo(map);

        var map = L.map('map', {
            center: [1.3378111, 103.8973617],
            zoom: 13
        });

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.Routing.control({
            waypoints: [
                L.latLng(1.38098653958626, 103.743144225093),
                L.latLng(1.32330123788358, 103.769853488209),
                // L.Routing.waypoint(null,"417842"),
                // L.Routing.waypoint(null, "198 Dominion road, Mount Roskill, Auckland")
            ],
            createMarker: function(i, wp, nWps) {
                if (i === 0 || i === nWps - 1) {
                    return L.marker(wp.latLng, {
                        icon: L.divIcon({
                            // iconSize: "auto",
                            className: 'demo',
                            html: '<span class=" " style="font-size: 11px; color: white; width: 25px; line-height: 41px; text-align: center; margin-left: 0px; margin-top: -7px; pointer-events: none; display: inline-block;">A</span>'
                        })
                    }).bindPopup('I\'m waypoint ' + i);
                }
                // else {
                //     return L.marker(wp.latLng, {
                //         icon: myViaIcon
                //     });
                // }
            }
        }).addTo(map);

        function Cloud() {
            let search_data = [
                "289 CHOA CHU KANG AVENUE 3 HDB PUBLIC SHELTERS SINGAPORE 680289",
                "281 CHOA CHU KANG AVENUE 3 KEAT HONG TEMBUSU SINGAPORE 680281"
            ];
            $.ajax({
                url: `https://developers.onemap.sg/commonapi/search?searchVal=${search_data}&returnGeom=Y&getAddrDetails=Y&pageNum=1`,
                success: function(result) {
                    //Set result to a variable for writing
                    var TrueResult = JSON.stringify(result);
                    // document.write(TrueResult);
                    console.log(TrueResult);
                }
            });
        }

        Cloud();
    </script>
</body>

</html>

{{-- let d = L.Routing.control({
    waypoints:[
        L.latLng(1.33795121637657, 103.897319256096),
        L.latLng(1.39165394542409, 103.746220667925),
        L.latLng(1.38098653958626, 103.743144225093),
        L.latLng(1.3808318992022, 103.74293968344),
        L.latLng(1.38032442970476, 103.74259978067),
        L.latLng(1.37927183528093, 103.74066488084),
    ],
    createMarker: function(i, wp, nWps) {
        if (i === 0 || i === nWps - 1) {
            return L.marker(wp.latLng, {
                icon: L.divIcon({
                    // iconSize: "auto",
                    className: 'demo',
                    html: '<span class=" " style="font-size: 11px; color: white; width: 25px; line-height: 41px; text-align: center; margin-left: 0px; margin-top: -7px; pointer-events: none; display: inline-block;">A</span>'
                })
            });
        }
        // else {
        //     return L.marker(wp.latLng, {
        //         icon: myViaIcon
        //     });
        // }
    }
}).addTo(map); --}}






{{-- 
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<style>
    .map {
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .demo {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAApCAYAAADAk4LOAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAN1wAADdcBQiibeAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAUlSURBVFjDrZdLiBxVFIb/e289uqt6kkx6zIiIoKgLRReKuMhCcaOIAUEIiCCE4CIPggZ8kBjooPgM0TiYEUUjqBGchZqAQlyYRTA+kJiJQiJGMjN5zYzT3dP1rrr3HBeTjDGTSfc8Dvyruud89Z9z6kIJdBj31763MivsJXKuZYF6dak5++2mh7NOcsXVHq6sHbhOK/24kOJJMO4AE1vKygwZhxlKSHGKiD+RSu09vOXB43OCrHz96y6T2lsh+OmKXzFdlbLne2UopSAupBhjECcZgjDMgiiSxPhcK/nCr1sfOtcWcm/tq9uEsL4rl0vdK67pKVu2jUwTMk0wBBAzpBCQAnAtiZIlwWQwPlHPglZQAFj1Y23VwVkh92zbd59U+Kanp+p2L12mooKQ5AbcpuclS6LiKoRhxOfHzhXMcs3PtVV7Z0DufXH/LSzpSG9vr1/p6kIz0dDUrvx/IYXAsrJCkWc4e/Z0Zpgf+KX26A/TkNtrXziesY9Xq8tvWNZdVfVYg7hzwKVv3O3ZiKMWj46OTrq5fdOh1x5pSADwjdzo2nbv0u6qqkca2jCIMGcZAuqRhu8vEX7ZK2V2WgMAcXdtvyeKbPS662+osCohzMycHVweniNREoShoZO5KYobpciSh23bFq7rIUgNiLFghRkBlg2v7GlpiccsCHrcryzxUk3zmsNskeYGvt/lxVH4hMWEu9xSWaQFYQ7L1B6iGZ5bBoy+zWKiHiltFHpqeIsVhWaosg1iqlgg4wAAEYEXsV3EmNppJmExMFYUxfVSuIs6E0sI5FkBBhLJzH9laQxLSjBj0WQJgSJPweDTkknvS4JGbCuxKOt7UY4lEQfNnAu9TzLxN2nUdAQTLAEw8YIlAVgAkmDCSBL75eCutSeY+GTUqqNkqUVxUbIl4qgJo4vWzecrhyQAMJldYf1MXLLl1EIsYBZgoGwpRI2zMTPtGBhYbSQAlJF9lieRzNMIriVBzPOWawvoIkYaNC0u9IcAIAHgp75NLQl8ENbPZJ6jgAU48RyFqHEuZyE+Pda/vjENAQBD5s209Y+kPJlyM4+r3lUS0AWSyVEhpHnjYu1pyO+7N4ywwPvhxHDiuwo8j1b5rkQwMZIziYHBXetPzIAAgIV8exZOSMoieI6aU5vKtgR0jqw1JtiYbZfW/R/kSN+mcWbxdtwYjn1XTd9B7cQAfNdCWB/OhBR7jvWv/3tWCAAoO3ktjyZZJ0HHbsq2AooERVQXzPKly2vOgPz29jNNBr+e1IcSz5YAM4hmFzPDtyWS+lDK4N2DfU+dbgsBAFHyd+oszE3agt/GjWcrUBEjj5sQBb96pXpXhAzueDJi4u1p41TsuQpCiFln4bkKeXMoJeadg++tG+sYAgBBXOo3RRrruAnfkWDmGfIdCeQhiiQgQbxjtlqzQk59vCZlNluL5lDiORLyMjcA4DsKeXM4AfDKxa97ThAAqPaMfaR1Nq6jOiqOAhOm5TsKJg1QZGGRedY7V6tzVcjBWk1D0JZ8cigt2RJSimkXnqOgW8MxQLUTb6wN5g0BgGPV0c9BekTH41xx5YXrQ8FkTRgdpxU7ea9djbYQ1GokmJ43wUhWtgRcS04tQjAcw9CWw29tThYOAXD03XVfMps/TTTOy30blDZgiqxFK6p7OsnvCDJ1UD9LyUjORoPDkUQyPfdHbXW+qJCjfRsOwOAoNY4z6Xz01rHq3k5zO4ZMHTabYSIhJD87MLB64f8Ys8WdG/tfBljMJedfwY+s/2P4Pv8AAAAASUVORK5CYII=') !important;
        margin-left: -12px !important;
        margin-top: -41px !important;
        width: 25px !important;
        height: 41px !important;
        /* transform: translate3d(737px, 82px, 0px) !\; */
        /* z-index: 82 !important; */
    }
</style>
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
                            <input type="text" name="delivery_date" id="delivery_date1"
                                class="form-control delivery_date1" placeholder="dd-mm-yyyy" autocomplete="off">
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
                        {{-- <div id="route_map"></div> --}}
                        <div id="map" class="map"></div>
                    </div>
                    {{-- <div id="directions-panel" class="p-2"></div> --}}
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script>
        $(function() {
            $("#sortable").sortable({
                items: "li:not('.unsortable')"
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
                        url: "{{ route('SA-DriversList') }}",
                        method: "GET",
                        data: {
                            delivery_date: date,
                        },
                        beforeSend: function() {
                            $('#driver_id').append(`<option value="">Fetching...</option>`);
                        },
                        success: function(response) {
                            $('#driver_id').html('');
                            $('#driver_id').append(`<option value="">Select</option>`);
                            $.each(response.drivers, function(key, value) {
                                $('#driver_id').append(
                                    `<option value="${value.driver_id}">${value.driver_name}&nbsp;&nbsp;{\Total Orders : ${value.total_order} \}</option>`
                                );
                            })

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
                                9 KAKI BUKIT ROAD 2 GORDON WAREHOUSE BUILDING 
                            </li>
            `);

            $.ajax({
                url: "{{ route('SA-DriversDeliveries') }}",
                method: "GET",
                data: {
                    driver_id: driver_id,
                    date: $('#delivery_date1').val()
                },
                success: function(response) {
                    $.each(response.deliveries, function(k, v) {
                        $('#sortable').append(`
                            <li class="ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>${ v.delivery_address }</li>
                        `);
                    })



                }
            });

        });

        // console.log(addresses);

        $('#submit').click(function() {
            var addresses = [];

            $('#sortable > li').each(function() {
                addresses.push($(this).text());
            });
            console.log(addresses);
            var waypoint = [{
                lat: 1.33795121637657,
                lng: 103.897319256096
            }];
            if (addresses.length > 2) {
                for (let i = 1; i < addresses.length; i++) {
                    $.ajax({
                        // async: false,
                        url: `https://developers.onemap.sg/commonapi/search?searchVal=${addresses[i]}&returnGeom=Y&getAddrDetails=Y&pageNum=1`,
                        success: function(result) {
                            $.each(result.results, function(k, v) {
                                if (v.ADDRESS == addresses[i])
                                    waypoint.push(L.latLng(v.LATITUDE, v.LONGTITUDE));
                            });
                            // console.log(waypoint)
                            L.Routing.control({
                                waypoints: waypoint,
                                createMarker: function(i, wp, nWps) {
                                    return L.marker(wp.latLng, {
                                        icon: L.divIcon({
                                            className: 'demo',
                                            html: `<span style="font-size: 11px; color: white; width: 25px; line-height: 41px; text-align: center; margin-left: 0px; margin-top: -7px; pointer-events: none; display: inline-block;">${(i+10).toString(36)}</span>`
                                        })
                                    }).bindPopup(addresses[i]);
                                },
                                // routeWhileDragging: false,
                                draggableWaypoints: false,
                                addWaypoints: false
                            }).addTo(map);

                            save_route_with_lat_lng(result)


                        }
                    });
                }

            }
        })

        function save_route_with_lat_lng(result) {
            $.ajax({
                url: "{{ route('SA-StoreDeliveryRoute') }}",
                method: "POST",
                data: result,
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
        }



        var map = L.map('map', {
            center: [1.3378111, 103.8973617],
            zoom: 13
        });

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    </script> --}}
