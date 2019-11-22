<?php

// config database
$servername = "127.0.0.1";
$username = "rahiemyi_iot";
$password = "%K=^nuqxzb,P";
$dbname = "rahiemyi_iot_gps";

if (isset($_GET['id']) && isset($_GET['lat']) && isset($_GET['lng'])){
        
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $latRaw = $_GET['lat'];
    $longRaw = $_GET['lng'];
    
    $sqlGetPoss = "SELECT * FROM iot_position WHERE id=".$_GET['id']." ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sqlGetPoss);
    $positions = mysqli_fetch_assoc($result);
    
    $prevLat = 0;
    $prevLong = 0;
    $errorCov = 1;
    
    $sqlGetRad = "SELECT * FROM iot_data WHERE name='radius'";
    $resultRad = mysqli_query($conn, $sqlGetRad);
    $radius = mysqli_fetch_assoc($resultRad)['value'];
    
    if ($positions != NULL) {
        $prevLat = $positions['latRaw'];
        $prevLong = $positions['longRaw'];
        $errorCov = $positions['errorCov'];
    }

    $kalmanGain = $errorCov / (float) ($errorCov + $radius);
    $latKal = (float) $prevLat + $kalmanGain * ($latRaw - $prevLat);
    $longKal = (float) $prevLong + $kalmanGain * ($longRaw - $prevLong);
    $newErrorCov = (1 - $kalmanGain) * $errorCov;

    $sql = "INSERT INTO iot_position VALUES (null, ".$_GET['id'].", '".$_GET["lat"]."', '".$_GET['lng']."', '".$latKal."', '".$longKal."', '".$newErrorCov."', NOW())";
    $result = array();
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('statuscode'=>200, 'message'=>'Insert Position Success!'));
    }else{
        http_response_code(500);
        echo json_encode(array('statuscode'=>500, 'message'=>'Insert Position Failed!'));
    }

    mysqli_close($conn);

}
                
?>