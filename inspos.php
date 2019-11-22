<?php

// config database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "iot_gps";

if (isset($_GET['id']) && isset($_GET['lat']) && isset($_GET['lng'])){
        
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO iot_position VALUES (null, ".$_GET['id'].", '".$_GET["lat"]."', '".$_GET['lng']."', NOW())";
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