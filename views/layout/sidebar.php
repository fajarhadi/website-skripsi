<input id="slide-sidebar" type="checkbox" role="button" />
<label id="burger" for="slide-sidebar"><span>  ≡  </span></label>
<div id="sideminibar"></div>
<nav class="bar-block small center" id="sidebar">
    <!-- Avatar image in top left corner -->
    <div id="header">
        <div style="padding: 20px; line-height: 20px;">
            <br>Sistem Pendeteksi Kecelakaan Pada Atlet Sepeda<br>
        </div>
    </div>
    <?php 
        $iconhome = "hover-blue";
        $iconroute = "hover-blue";
        $iconracer = "hover-blue";
        $iconalert = "hover-blue";
        $iconsetting = "hover-blue";
        if ($this->controllerName == "dashboard"){
            $iconhome = "blue";
        }
        if ($this->controllerName == "route"){
            $iconroute = "blue";
        }
        if ($this->controllerName == "racer"){
            $iconracer = "blue";
        }
        if ($this->controllerName == "alert"){
            $iconalert = "blue";
        }
        if ($this->controllerName == "setting"){
            $iconsetting = "blue";
        }
    ?>
    <a href="<?php echo $this->baseUrl ?>" class="button <?php echo $iconhome ?>">
    <p>Dashboard</p>
    </a>
    <a href="<?php echo $this->baseUrl ?>dashboard/route" class="button <?php echo $iconroute ?>">
    <p>Rute</p>
    </a>
    <a href="<?php echo $this->baseUrl ?>dashboard/biker" class="button <?php echo $iconracer ?>">
    <p>Daftar Pesepeda</p>
    </a>
    <a href="<?php echo $this->baseUrl ?>dashboard/alerts" class="button <?php echo $iconalert ?>">
    <p>Alert History</p>
    </a>
    <a href="<?php echo $this->baseUrl ?>dashboard/setting" class="button <?php echo $iconsetting ?>">
    <p>Setting</p>
    </a>
    
    <div id="alert">
        <span><b>LATEST ALERT</b></span><br><br>
        <?php
        if (count($this->getAlerts()) == 0){
            echo "Belum ada alert";
        }else{
            echo $this->getLastAlert(-1)->name . "<br>" . ($this->getLastAlert(-1))->date;
        }
        ?>
    </div>
    
    <script type="text/javascript">
    window.onload = startInterval;
    function startInterval() {
        setInterval("startTime();",30000);
    }

    function startTime() {
        var now = new Date();
        document.getElementById('alert').innerHTML = "<span><b>LATEST ALERT</b></span><br><br> <?php echo $this->getLastAlert(-1)->name . "<br>" . ($this->getLastAlert(-1))->date; ?>";
    }
    </script>
    
</nav>
<?php if (isset($_SESSION['username'])){
?>
<label id="to-logout"><a href="<?php echo $this->baseUrl ?>logout"><span>   X   </span></a></label>
<?php
}else{
    header("Location: ".$this->baseUrl);
}
?>