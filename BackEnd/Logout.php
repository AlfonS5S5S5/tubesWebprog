<?php
    session_start();
    session_destroy();
    header('Location: ../FrontEnd/html/Member/HomePage.php');
    exit();
?>