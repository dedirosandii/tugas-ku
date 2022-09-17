<?php
require 'config.php';

// ambil data di url
$id = $_GET['id'];

// query data mahasiswa berdasarkan id
$data = query("SELECT * FROM location WHERE id = $id")[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tugas ku</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://jaringtani.phatria.co.id/assets/styles/core.css">
    <link rel="stylesheet" href="https://jaringtani.phatria.co.id/assets/styles/style.css">
    <link rel="stylesheet" href="https://jaringtani.phatria.co.id/assets/styles/icon-font.min.css">
</head>

<body>


    <div class="block py-5">
        <!-- d-md-none d-lg-none d-xl-none -->
        <div class="xs-pd-20-10 pd-ltr-20">
            <form action="process-edit.php" enctype="multipart/form-data" method="post">
                <div class="row">

                    <div class="col-sm-12 card-box px-5 py-5">
                        <div class="form-group">
                            <input type="text" name="id" class="form-control" hidden value="<?= $data["id"] ?>" required>
                            <input type="text" name="name_location" class="form-control" required placeholder="Name Location" value="<?= $data["name_location"] ?>" required>
                        </div>
                        <div class="card-box pd-20 height-150-p mt-2">
                            <div class="row align-items-center">
                                <div id="map" style="width:100%;height:540px;"></div>
                            </div>
                        </div>

                        <span onclick="getLocation()" class="btn btn-sm btn-success" id="start"> Start Distance</span>
                        <span id="end" class="btn btn-sm btn-danger"> Delete Distance</span>

                        <div class="form-group mt-2">
                            <input type="text" name="distance" id="txt-result-area" class="form-control" required placeholder="Measurement results" value="<?= $data["distance"] ?>">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input type="text" name="latitude" id="lat" class="form-control" required readonly placeholder="Get latitude automatically" value="<?= $data["latitude"] ?>">
                            </div>
                            <div class="col-6">
                                <input type="text" name="longitude" id="lng" class="form-control" required readonly placeholder="Get longitude automatically" value="<?= $data["longitude"] ?>">
                            </div>
                        </div>


                        <button type=" submit" name="submit" class="btn btn-block btn-sm btn-warning mb-30 mt-3"> Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <script src="gmaps-measuretool.umd.js"></script>
        <script>
            var map, measureTool;

            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 100,
                    scaleControl: true,
                    mapTypeId: google.maps.MapTypeId.SATELLITE
                });
                measureTool = new MeasureTool(map, {
                    contextMenu: false,
                    unit: MeasureTool.UnitTypeId.METRIC, // metric, imperial, or nautical
                });

                measureTool.addListener('measure_start', () => {
                    console.log('started');
                    //      measureTool.removeListener('measure_start')
                });
                measureTool.addListener('measure_end', (e) => {
                    console.log('ended', e.result);
                    //      measureTool.removeListener('measure_end');
                });
                measureTool.addListener('measure_change', (e) => {
                    console.log('changed', e.result);
                    document.getElementById('txt-result-area').value = (
                        e.result.area / 10000
                    ).toFixed(4);
                });

                //set user current location
                var options = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0,
                };

                function success(pos) {
                    var crd = pos.coords;

                    console.log('Your current location:');
                    console.log('lat: ${crd.latitude}');
                    console.log('long: ${crd.longitude}');
                    console.log('accuracy: ${crd.accuracy} meters.');
                    new google.maps.Marker({
                        position: {
                            lat: crd.latitude,
                            lng: crd.longitude
                        },
                        map,
                    });
                    map.setCenter({
                        lat: crd.latitude,
                        lng: crd.longitude
                    });
                }

                function error(err) {
                    console.warn('ERROR(${err.code}): ${err.message}');
                }

                navigator.geolocation.getCurrentPosition(success, error, options);
            }

            let inverted = false;
            document
                .querySelector('#start')
                .addEventListener('click', () => measureTool.start());
            document
                .querySelector('#end')
                .addEventListener('click', () => measureTool.end());
            let myapp = {
                x: document.getElementById("getGeo"),
                lat: document.getElementById("lat"),
                lng: document.getElementById("lng"),
            };

            function getLocation() {

                // console.log(ds);
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition, showError);
                } else {
                    "Geolocation is not supported by this browser.";
                }
            }

            function showPosition(position) {
                document.getElementById("lat").value = position.coords.latitude;
                document.getElementById("lng").value = position.coords.longitude;
                x.innerHTML = "Latitude: " + position.coords.latitude;
                y.innerHTML = "Longitude: " + position.coords.longitude;
            }

            function showError(error) {
                myapp.lat.value = "";
                myapp.lng.value = "";
                myapp.x.innerHTML = "Woops:  " + error.code +
                    "<br>What: " + error.message;
            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1KIAIhzC3OLRijw6iT7IlT85XxUYWwoI&libraries=geometry&callback=initMap" async defer></script>
</body>
<script src="https://jaringtani.phatria.co.id/assets/styles/script.min.js"></script>
<script src="https://jaringtani.phatria.co.id/assets/styles/core.js"></script>

</html>