<?php

namespace lib;

abstract class basemodel {
    public static function getDB() {
        return new \PDO("mysql:host=localhost;dbname=rahiemyi_iot_dua", "rahiemyi_iot", "%K=^nuqxzb,P");
    }
}