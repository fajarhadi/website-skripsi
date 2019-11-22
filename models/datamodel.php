<?php

namespace models;

use lib\basemodel;

class datamodel extends basemodel {
    public $id;
    public $name;
    public $value;

    public function __construct($id, $name, $value) {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    public static function getData($name) {
        $query = self::getDB()->prepare("SELECT * FROM `iot_data` WHERE name='".$name."'");
        $query->execute();

        while ($row = $query->fetch()) {
            $result = new datamodel($row["id"], $row["name"], $row["value"]);
        }

        return $result;
    }
    
    public function setData($name, $value){
        $query = self::getDB()->prepare("UPDATE iot_data SET value='" . $value . "' WHERE name='" . $name . "'");
        $query->execute();
    }
    
}
