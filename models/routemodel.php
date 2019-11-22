<?php

namespace models;

use lib\basemodel;

class routemodel extends basemodel {
    
    public $id;
    public $latitude;
    public $longitude;
    public $coordsOrder;

    public function __construct($id, $latitude, $longitude, $coordsOrder) {
        $this->id = $id;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->coordsOrder = $coordsOrder;
    }
    
    public function getRoute(){
        $query = self::getDB()->prepare("SELECT * FROM iot_route ORDER BY coordsOrder ASC");
        $query->execute();
        
        $route = array();
        while ($row = $query->fetch()) {
            array_push($route, new routemodel($row["id"], $row["lat"], $row["lng"], $row["coordsOrder"]));
        }
        
        return $route;
    }
    
    public function updateRoute($order, $latitude, $longitude){
        $query = self::getDB()->prepare("UPDATE iot_route SET lat='" . $latitude . "', lng='" . $longitude . "' WHERE coordsOrder=" . $order);
        $query->execute();
    }
}
?>