<?php
if(@$_POST['login']){
    $username   = $_POST['username'];
    $password	= $_POST['password'];
    if ($username == "eri" && $password == "eri"){
        $_SESSION['username'] = $username;
        $_SESSION['flash'] = "Anda berhasil login!";
        header("Location: ".$this->baseUrl."dashboard");
        die();
    }else{
        $errors = "Username atau Password salah!";
    }
}

if (isset($_SESSION['username'])){
    header("Location: ".$this->baseUrl."dashboard");
    die();
}
?>

<div id="login-block">
    <div id="login-title">
        Login
    </div>
    <div id="login-body">
        <form name="login" action="" method="post">
            Username : <br><input type="text" id="inputText" name="username" required/><br>
            Password :<br><input type="password" id="inputText" name="password" required/><br>
            <br><input type="submit" name="login" id="inputSubmit" value="Login" />
        </form>
        
        <?php
        if (isset($errors)){
            echo "<br><span style='color: red'>Error: " . $errors . "</span>";
        }
        ?>
    </div>
</div>