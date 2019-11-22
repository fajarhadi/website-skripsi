<?php
if(@$_POST['noise']){
    $this->setNoiseRate($_POST['noiserate']);
    $_SESSION['flash'] = "Update setting success!";
}else if(@$_POST['dwlokasi']){
    $fileUrl = "public/output/biker1.csv";
    $myfile = fopen($fileUrl, "w") or die("Unable to open file!");
    $bikers = $this->getPositions(1);
    $i = 1;
    $txt = "sep=;\n";
    foreach($bikers as $biker){
        if ($biker->tipe == 0){
            $tipe = "No accident";
        }elseif ($biker->tipe == 1){
            $tipe = "Tabrakan";
        }elseif ($biker->tipe == 2){
            $tipe = "Jatuh";
        }elseif ($biker->tipe == 3){
            $tipe = "Kecelakaan kecepatan tinggi";
        }
        $txt .= $i.";".$biker->latRaw.";".$biker->longRaw.";".$biker->latKal.";".$biker->longKal.";".$tipe.";".$biker->date."\n";
        $i++;
    }
    $fileUrl = $this->baseUrl."public/output/biker1.csv";
    fwrite($myfile, $txt);
    fclose($myfile);
    header('Location: ' . $fileUrl);
    $_SESSION['flash'] = "Download Data Lokasi (CSV)!";
}else if(@$_POST['lokasi']){
    $this->clearPosition();
    $_SESSION['flash'] = "Hapus lokasi success!";
}else if(@$_POST['alert']){
    $this->clearAlert();
    $_SESSION['flash'] = "Hapus alert success!";
}
?>
<div style="padding: 20px;">
    <b>SET NOISE RATE</b><br><br>
    
    <form name="noise" action="" method="post">
        <?php
        $noiseRate = $this->getNoiseRate();
        echo "Noise Rate: <input type='text' value='" . $noiseRate . "' name='noiserate' required/>";
        ?>
        <br><input type="submit" id="inputSubmit" value="Submit" name="noise"/>
    </form><br><br>
    
    <b>DOWNLOAD DATA LOKASI (CSV)</b>
    
    <form name="dwlokasi" method="post" action="">
        <br><input type="submit" id="inputSubmit" value="Download Data Lokasi" name="dwlokasi"/>
    </form><br><br>
    
    <b>HAPUS SEMUA DATA LOKASI</b>
    
    <form name="lokasi" method="post" onsubmit="return confirm('Yakin hapus semua data lokasi?');">
        <br><input type="submit" id="inputSubmit" value="Hapus Data Lokasi" name="lokasi"/>
    </form><br><br>
    
    <b>HAPUS SEMUA DATA ALERT</b>
    
    <form name="alert" method="post" onsubmit="return confirm('Yakin hapus semua data alert?');">
        <br><input type="submit" id="inputSubmit" value="Hapus Data Alert" name="alert"/>
    </form>
</div>