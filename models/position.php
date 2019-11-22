<?php

namespace models;

use lib\basemodel;
use models\datamodel;
use models\routemodel;
use models\alertmodel;

class position extends basemodel {
    
    public $id;
    public $biker;
    public $latRaw;
    public $longRaw;
    public $latKal;
    public $longKal;
    public $tipe;
    public $imuRaw;
    public $imuKal;
    public $errorCov;
    public $date;

    public function __construct($id, $biker, $latRaw, $longRaw, $latKal, $longKal, $tipe, $imuRaw, $imuKal, $errorCov, $date) {
        $this->id = $id;
        $this->biker = $biker;
        $this->latRaw = $latRaw;
        $this->longRaw = $longRaw;
        $this->latKal = $latKal;
        $this->longKal = $longKal;
        $this->tipe = $tipe;
        $this->imuRaw = $imuRaw;
        $this->imuKal = $imuKal;
        $this->errorCov = $errorCov;
        $this->date = $date;
    }
    
    public function getPositions($bikeId){
        $query = self::getDB()->prepare("SELECT * FROM iot_position WHERE bikeId=".$bikeId . " ORDER BY date ASC");
        $query->execute();
        $result = array();
        while ($row = $query->fetch()) {
            $result[] = new position($row['id'], $row['bikeId'], $row['latRaw'], $row['longRaw'], $row['latKal'], $row['longKal'], $row['tipe'], $row['imuRaw'], $row['imuKal'], $row['errorCov'], $row['date']);
        }
        
        return $result;
    }
    
    public function insertPosition($bikeId, $latKal, $longKal, $latRaw, $longRaw, $tipe, $imuRaw, $imuKal){
        $positions = self::getPositions($bikeId);
        $prevLat = 0;
        $prevLong = 0;
        $errorCov = 1;
        $radius = datamodel::getData('radius')->value;
        if (count($positions) > 0){
            $prevLat = $positions[count($positions)-1]->latKal;
            $prevLong = $positions[count($positions)-1]->longKal;
            $errorCov = $positions[count($positions)-1]->errorCov;
        }
        
        // $kalmanGain = $errorCov / (float) ($errorCov + $radius);
        // $latKal = (float) $prevLat + $kalmanGain * ($latRaw - $prevLat);
        // $longKal = (float) $prevLong + $kalmanGain * ($longRaw - $prevLong);
        // $newErrorCov = (1 - $kalmanGain) * $errorCov;
        // $latKal = $latRaw;
        // $longKal = $longRaw;
        $newErrorCov = 0;
        
        $query = self::getDB()->prepare("INSERT INTO iot_position VALUES(null, ".$bikeId.", '".$latRaw."', '".$longRaw."', '".$latKal."', '".$longKal."', '".$tipe."', '".$imuRaw."', '".$imuKal."', '".$newErrorCov."', NOW())");
        $query->execute();
        
        //self::checkPosition($bikeId, $latKal, $longKal);
    }
    
    public function getLastPosition($bikeId){
        $query = self::getDB()->prepare("SELECT * FROM iot_position WHERE bikeId=".$bikeId. " ORDER BY id DESC LIMIT 1");
        $query->execute();

        while ($row = $query->fetch()) {
            $result = new position($row['id'], $row['bikeId'], $row['latRaw'], $row['longRaw'], $row['latKal'], $row['longKal'], $row['tipe'], $row['imuRaw'], $row['imuKal'], $row['errorCov'], $row['date']);
        }
        
        return $result;
    }
    
    public function clearPosition(){
        $query = self::getDB()->prepare("DELETE FROM iot_position");
        $query->execute();
    }
    
    public function checkPosition($bikeId, $latKal, $longKal){
        $rad = -1;
        if (count(self::getPositions($bikeId)) > 1){
            if (self::isRadiusFive(1) <= 10){
                $rad = 1;
                //alertmodel::createAlert($bikeId, ("Sepeda " . $bikeId . " diam di tempat!"), $latKal, $longKal, 0, 0);
            }
        }
        
        $tesRoute = self::isOnRoute(1);
        if ($tesRoute != "aman"){
            //alertmodel::createAlert($bikeId, ("Sepeda " . $bikeId . " keluar jalur!"), $latKal, $longKal, 0, 0);
        }
        
        if ($rad == 1 && $tesRoute != "aman"){
            //alertmodel::createAlert($bikeId, ("URGENT: Sepeda " . $bikeId . " diam di luar jalur! Harap Segera Ditangani!"), $latKal, $longKal, 0, 0);
        }
    }
    
    public function isRadiusFive($bikeId){
        $earthRadius = 6371000;
        $query = self::getDB()->prepare("SELECT * FROM iot_position WHERE bikeId=".$bikeId. " ORDER BY id DESC LIMIT 2");
        $query->execute();

        $result = array();
        while ($row = $query->fetch()) {
            $result[] = new position($row['id'], $row['bikeId'], $row['latRaw'], $row['longRaw'], $row['latKal'], $row['longKal'], $row['tipe'], $row['imuRaw'], $row['imuKal'], $row['errorCov'], $row['date']);
        }
        
        if (count($result) > 1){
            $latFrom = deg2rad($result[0]->latKal);
            $lonFrom = deg2rad($result[0]->longKal);
            $latTo = deg2rad($result[1]->latKal);
            $lonTo = deg2rad($result[1]->longKal);

            $lonDelta = $lonTo - $lonFrom;
            $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
            $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

            $angle = atan2(sqrt($a), $b);
            
            $jarak = $angle * $earthRadius;
        }else{
            $jarak = -1;
        }
        
        
        return $jarak;
    }
    
    public function isOnRoute($bikeId){
        $last = self::getLastPosition($bikeId);
        $routes = routemodel::getRoute();
        $same = "no";
        $check = array();
        $message = "Bike " . $bikeId . " keluar jalur!";
        
        for ($i = 0; $i < 3; $i++){
            if ($routes[$i]->latitude == $routes[$i+1]->latitude){
                $same = "lat";
                if ($routes[$i]->longitude > $routes[$i+1]->longitude){
                    $min = $routes[$i+1]->longitude;
                    $max = $routes[$i]->longitude;
                }else{
                    $min = $routes[$i]->longitude;
                    $max = $routes[$i+1]->longitude;
                }
            }else if ($routes[$i]->longitude == $routes[$i+1]->longitude){
                $same = "lng";
                if ($routes[$i]->latitude > $routes[$i+1]->latitude){
                    $min = $routes[$i+1]->latitude;
                    $max = $routes[$i]->latitude;
                }else{
                    $min = $routes[$i]->latitude;
                    $max = $routes[$i+1]->latitude;
                }
            }
        
            if ($same == "lat"){
                if ($last->longKal >= ($min-0.000078) && $last->longKal <= ($max+0.000078) &&
                    $last->latKal >= ($routes[$i]->latitude-0.000078) && $last->latKal <= ($routes[$i]->latitude+0.000078)) {
                    $message = "aman";
                }
            }else if ($same == "lng"){
                if ($last->latKal >= ($min-0.000078) && $last->latKal <= ($max+0.000078) &&
                    $last->longKal >= ($routes[$i]->longitude-0.000078) && $last->longKal <= ($routes[$i]->longitude+0.000078)){
                    $message = "aman";
                }
            }
        }
        
        if ($routes[3]->latitude == $routes[0]->latitude){
            $same = "lat";
            if ($routes[3]->longitude > $routes[0]->longitude){
                $min = $routes[0]->longitude;
                $max = $routes[3]->longitude;
            }else{
                $min = $routes[3]->longitude;
                $max = $routes[0]->longitude;
            }
        }else if ($routes[3]->longitude == $routes[0]->longitude){
            $same = "lng";
            if ($routes[3]->latitude > $routes[0]->latitude){
                $min = $routes[0]->latitude;
                $max = $routes[3]->latitude;
            }else{
                $min = $routes[3]->latitude;
                $max = $routes[0]->latitude;
            }
        }
        
        if ($same == "lat"){
            if ($last->longKal >= ($min-0.000078) && $last->longKal <= ($max+0.000078) &&
                $last->latKal >= ($routes[3]->latitude-0.000078) && $last->latKal <= ($routes[3]->latitude+0.000078)) {
                $message = "aman";
            }
        }else if ($same == "lng"){
            if ($last->latKal >= ($min-0.000078) && $last->latKal <= ($max+0.000078) &&
                $last->longKal >= ($routes[3]->longitude-0.000078) && $last->longKal <= ($routes[3]->longitude+0.000078)){
                $message = "aman";
            }
        }
        
        return $message;
    }
}
?>