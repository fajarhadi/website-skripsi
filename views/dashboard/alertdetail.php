<div style="padding: 20px;">
    <b>ALERT DETAIL</b><br><br>
        
    <?php
    $alert = $this->getAlert($_GET['id']);
    echo "<b>Bike ID:</b> " . $alert->bike . "<br>
    <b>Date:</b> " . $alert->date . "<br>
    <b>Alert Name:</b> " . $alert->name . "<br>
    <b>Latitude:</b> " . $alert->lat . "<br>
    <b>Longitude:</b> " . $alert->lng . "<br>
    <b><a href=\"https://www.google.com/maps?saddr=My+Location&daddr=<?php echo $alert->lat ?>,<?php echo $alert->lng ?>\" target=\"_blank\">Go To Incident Location</a></b><br>
    <b>Status:</b> Belum Ditangani<br>
    <b>Official:</b> admin<br><br>";
    ?>
    
    <div id="map" style="height:600px; width:100%"></div>
    <script>
        var map;
        var startMarker;

        function initMap() {
            var start = {lat: <?php echo $alert->lat ?>, lng: <?php echo $alert->lng ?>};

            map = new google.maps.Map(document.getElementById('map'), {
                center: start,
                zoom: 18
            });

            startMarker = new google.maps.Marker({
                position: start,
                animation: google.maps.Animation.DROP,
                map: map,
                title: 'Incident Location'
            });

            var startInfo = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">Incident Location</h1>'+
            '<div id="bodyContent">'+
                '<p><b>Latitude:</b> <?php echo $alert->lat ?>' +
                '<p><b>Longitude:</b> <?php echo $alert->lng ?></p>'+
                
                '<p><b><a href=\"https://www.google.com/maps?saddr=My+Location&daddr=<?php echo $alert->lat ?>,<?php echo $alert->lng ?>" target="_blank">Go To Location</a></b></p>'+
            '</div>'+
            '</div>';

            var startWindow = new google.maps.InfoWindow({
                content: startInfo
            });

            startMarker.addListener('click', function() {
              startWindow.open(map, startMarker);
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdWUJcF7iwxg4ThyEpUMxE4ox2p9_MRO8&callback=initMap"
    async defer></script>