<?php
    session_start();
    session_destroy();
    session_start();
    $_SESSION['flash'] = "Anda berhasil logout!";
    header('Location: sampul');
    die();
?>