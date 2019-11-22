<?php
if(@$_POST['route']){
    for ($i = 0; $i <= 3; $i++) {
        $this->updateRoute($i, $_POST['lat'.$i], $_POST['lng'.$i]);
    }
    $_SESSION['flash'] = "Update route success!";
}
?>
<div style="padding: 20px;">
    <b>SET ROUTE</b><br><br>
    
    <form name="route" action="" method="post">
        <?php
        $routes = $this->getRoute();
        $i = 0;
        foreach($routes as $route){
            echo ($i+1) . ". Latitude <input type='text' value='" . $route->latitude . "' name='lat".$i."' required/> - Longitude <input type='text' value='" . $route->longitude . "' name='lng".$i."' required/><br>";
            $i++;
        }
        ?>
        <br><input type="submit" id="inputSubmit" value="Submit" name="route"/>
    </form>
</div>