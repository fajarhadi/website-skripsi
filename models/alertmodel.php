<?php

namespace models;

use lib\basemodel;

class alertmodel extends basemodel {
    public $id;
    public $bike;
    public $name;
    public $lat;
    public $lng;
    public $status;
    public $official;
    public $date;

    public function __construct($id, $bike, $name, $lat, $lng, $status, $official, $date){
        $this->id = $id;
        $this->bike = $bike;
        $this->name = $name;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->status = $status;
        $this->official = $official;
        $this->date = $date;
    }

    public static function getAlerts() {
        $query = self::getDB()->prepare("SELECT * FROM `iot_alert` ORDER BY id DESC");
        $query->execute();

        $result = array();
        while ($row = $query->fetch()) {
            $result[] = new alertmodel($row["id"], $row["bike"], $row["name"], $row["lat"], $row["lng"], $row["status"], $row["official"], $row["date"]);
        }

        return $result;
    }

    public static function getAlert($id) {
        $query = self::getDB()->prepare("SELECT * FROM `iot_alert` WHERE id=" . $id);
        $query->execute();

        while ($row = $query->fetch()) {
            $result = new alertmodel($row["id"], $row["bike"], $row["name"], $row["lat"], $row["lng"], $row["status"], $row["official"], $row["date"]);
        }

        return $result;
    }

    public static function getLastAlert($bikeId) {
        if ($bikeId == -1){
            $query = self::getDB()->prepare("SELECT * FROM `iot_alert` ORDER BY id DESC LIMIT 1");
        }else{
            $query = self::getDB()->prepare("SELECT * FROM `iot_alert` WHERE bikeId=".$bikeId." ORDER BY id DESC LIMIT 1");
        }
        $query->execute();

        while ($row = $query->fetch()) {
            $result = new alertmodel($row["id"], $row["bike"], $row["name"], $row["lat"], $row["lng"], $row["status"], $row["official"], $row["date"]);
        }

        return $result;
    }
    
    public function clearAlert(){
        $query = self::getDB()->prepare("DELETE FROM iot_alert");
        $query->execute();
    }
    
    public function setAlert($id, $status, $official){
        $query = self::getDB()->prepare("UPDATE iot_alert SET status='" . $status . "', official='" . $official . "' WHERE id='" . $id . "'");
        $query->execute();
    }
    
    public function createAlert($bike, $name, $lat, $lng, $status, $official){
        $query = self::getDB()->prepare("INSERT INTO `iot_alert` VALUES (null, " . $bike . ", '" . $name . "', '" . $lat . "', '" . $lng . "', " . $status . ", " . $official . ", NOW())");
        $query->execute();
    }
    
}

?>