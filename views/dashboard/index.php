<?php
    $routes = $this->getRoute();
?>
<div id="map" style="width:100%; height:100%"></div>
<script>
    var map;
    var startMarker;
    
    function initMap() {
        var start = {lat: <?php echo $routes[0]->latitude ?>, lng: <?php echo $routes[0]->longitude ?>};
        
        map = new google.maps.Map(document.getElementById('map'), {
            center: start,
            zoom: 18
        });

        startMarker = new google.maps.Marker({
            position: start,
            animation: google.maps.Animation.DROP,
            map: map,
            title: 'Starting Location'
        });
        
        var startInfo = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h1 id="firstHeading" class="firstHeading">Starting Location</h1>'+
            '<div id="bodyContent">'+
                '<p><b>Latitude:</b> <?php echo $routes[0]->latitude ?>' +
                '<p><b>Longitude:</b> <?php echo $routes[0]->longitude ?></p>'+
            '</div>'+
            '</div>';

        var startWindow = new google.maps.InfoWindow({
            content: startInfo
        });
        
        startMarker.addListener('click', function() {
          startWindow.open(map, startMarker);
        });
        
        <?php
        if (count($this->getPositions(1)) > 0 ){
            $lastPost = $this->getLastPosition(1);
            
            echo "
            
            var bike1 = {lat: ".$lastPost->latKal.", lng: ".$lastPost->longKal."};
            
            var imageBike = '".$this->baseUrl."public/images/bike.png';
            var bikeMarker = new google.maps.Marker({
                position: bike1,
                animation: google.maps.Animation.DROP,
                map: map,
                icon: imageBike,
                title: 'Bike 1'
            });

            var bikeInfo = '<div id=\"content\">'+
                '<div id=\"siteNotice\">'+
                '</div>'+
                '<h1 id=\"firstHeading\" class=\"firstHeading\">Bike 1</h1>'+
                '<div id=\"bodyContent\">'+
                    '<p><b>Latitude:</b> ".$lastPost->latKal."' +
                    '<p><b>Longitude:</b> ".$lastPost->longKal."' +
                    '<p><p><a href=\"https://www.google.com/maps?saddr=My+Location&daddr=.".$lastPost->latKal.",".$lastPost->longKal."\" target=\"_blank\">Go To Bike</a></p>'+
                '</div>'+
                '</div>';

            var bikeWindow = new google.maps.InfoWindow({
                content: bikeInfo
            });

            bikeMarker.addListener('click', function() {
              bikeWindow.open(map, bikeMarker);
            });";
        }
        ?>
        
        var routeCoordinates = [
        <?php 
        for ($i = 0; $i < count($routes); $i++){
            echo "{lat: ".$routes[$i]->latitude.", lng: ".$routes[$i]->longitude."}";
            if ($i != count($routes)){
                echo ",\n";
            }
        }
        echo "{lat: ".$routes[0]->latitude.", lng: ".$routes[0]->longitude."}";
        ?>
        ];
                     
        var routePath = new google.maps.Polyline({
            path: routeCoordinates,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        routePath.setMap(map);
        
        // function lastpos(){
        //     var xmlhttp = new XMLHttpRequest();
        //     var url = "<?php echo $this->baseUrl ?>api/lastpos;
        //     xmlhttp.open("GET", url, true);
        //     xmlhttp.setRequestHeader("Content-Type", "text/plain;charset=UTF-8");
        //     xmlhttp.setRequestHeader("Access-Control-Allow-Origin", "*");
        //     xmlhttp.send();
        //     xmlhttp.onreadystatechange = function() {
        //         if (this.status == 200) {
        //             var daftar = JSON.parse(this.responseText);
                    
        //         }
        //     };
        // }
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdWUJcF7iwxg4ThyEpUMxE4ox2p9_MRO8&callback=initMap"
async defer></script>