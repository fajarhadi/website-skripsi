<?php

if (isset($_GET['status'])){
        
    $myfile = fopen("data.txt", "w") or die("Unable to open file!");
    if ($_GET['status'] == 0){
        $txt = "Tidak Ada sampah!";
        echo "Tidak Ada sampah!";
    }else{
        $txt = "Ada sampah!";
        echo "Ada sampah!";
    }
    fwrite($myfile, $txt);
    fclose($myfile);

}
                
?>