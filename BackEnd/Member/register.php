<?php
    require_once '../connection.php';

    $query = "SELECT * FROM users WHERE user_name = '".$_POST['username']."'";
    $result = mysqli_query($conn, $query);
    $found = false;
    while($row = mysqli_fetch_array($result)){
        if($row['user_name'] == $_POST['username']) {
            $found= true;
            break;
        }
    }
    if(!$found) {
        $query = "INSERT INTO users (user_name, user_password) VALUES ('".$_POST['username']."', '".$_POST['password']."')";
        mysqli_query($conn, $query);
        echo "<script>alert('Register Berhasil'); window.location.href = '../../FrontEnd/html/Member/Login.html';</script>";
    } else {
        echo "<script>alert('Username sudah terdaftar'); window.location.href = '../../FrontEnd/html/Member/Register.html'';</script>";
    }
?>