<div style="padding: 20px;">
    <b>ALERT HISTORY</b><br><br>

    <table style="width:75%">
        <tr style="background:#666;color: #fff;">
            <th rowspan="1">No.</th>
            <th colspan="1">Bike ID</th>
            <th colspan="1">Alert</th>
            <th rowspan="1">Date and Time</th>
            <th rowspan="1">Detail</th>
        </tr>
        
        <?php
        $alerts = $this->getAlerts();
        $i = 1;
        foreach($alerts as $alert){
            echo 
                "<tr>
                    <td align='center'>".$i."</td>
                    <td align='center'>".$alert->bike."</td>
                    <td align='left'>".$alert->name."</td>
                    <td align='center'>".$alert->date."</td>
                    <td align='center'><a href='" . $this->baseUrl . "dashboard/alertdetail/".$alert->id."' style='font-weight: bold; color:#000; text-decoration: none;'>Detail Alert</a></td>
                </tr>";
            $i++;
        }
        ?>
        
    </table>
</div>