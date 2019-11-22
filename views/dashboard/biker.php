<div style="padding: 20px;">
    <b>BIKER POSITION HISTORY</b><br><br>

    <table style="width:75%">
        <tr style="background:#666;color: #fff;">
            <th rowspan="2">No.</th>
            <th colspan="3">Raw Data</th>
            <th colspan="3">Kalman</th>
            <th rowspan="2">Type</th>
            <th rowspan="2">Date and Time</th>
        </tr>
        <tr style="background:#666;color: #fff;">
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Imu</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Imu</th>
        </tr>
        
        <?php
        $bikers = $this->getPositions(1);
        $i = 1;
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
            echo 
                "<tr>
                    <td align='center'>".$i."</td>
                    <td align='right'>".$biker->latRaw."</td>
                    <td align='right'>".$biker->longRaw."</td>
                    <td align='right'>".$biker->imuRaw."</td>
                    <td align='right'>".$biker->latKal."</td>
                    <td align='right'>".$biker->longKal."</td>
                    <td align='right'>".$biker->imuKal."</td>
                    <td align='center'>".$tipe."</td>
                    <td align='center'>".$biker->date."</td>
                </tr>";
            $i++;
        }
        ?>
        
    </table>
</div>