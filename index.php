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
            <a class="btn-block btn btn-sm btn-success mb-5" href="add.php"> Add new data</a>

            <?php
            require_once "config.php";
            $get_data = query("SELECT * FROM location");
            foreach ($get_data as $data) { ?>
                <div class="row clearfix">
                    <div class="col-12 mb-3">
                        <div class="card card-box">
                            <div class="card-body">
                                <div class="card-box pd-20 height-150-p mt-2">
                                    <div class="row align-items-center">
                                        <div id="map" style="width:100%;height:500px;"></div>
                                    </div>
                                </div>
                                <h5 class="card-title weight-500"><?= $data["name_location"]; ?></h5>
                                <li>Distance : <?= $data["distance"]; ?></li>
                                <li>Latitude : <?= $data["latitude"]; ?></li>
                                <li>Longitude : <?= $data["longitude"]; ?></li>
                                <p class="text-right mt-5"><a href="edit.php?id=<?= $data["id"]; ?>" class="btn btn-sm btn-success">Edit data</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>


        </div>
        <script src="gmaps-measuretool.umd.js"></script>
        <script>
            var map, measureTool;

            function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 50,
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
                    //      measureTool.removeListener('measure_change');
                    document.getElementById('txt-result-length').value = (
                        e.result.length / 1000
                    ).toFixed(3);
                    document.getElementById('txt-result-area').value = (
                        e.result.area / 1000
                    ).toFixed(3);
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
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1KIAIhzC3OLRijw6iT7IlT85XxUYWwoI&libraries=geometry&callback=initMap" async defer></script>
</body>
<script src="https://jaringtani.phatria.co.id/assets/styles/script.min.js"></script>
<script src="https://jaringtani.phatria.co.id/assets/styles/core.js"></script>

</html>