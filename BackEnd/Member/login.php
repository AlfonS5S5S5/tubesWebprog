<?php
require_once '../connection.php';

$query = "SELECT * FROM users WHERE user_name = '" . $_POST['username'] . "' AND user_password = '" . md5($_POST['password']) . "'";
$result = mysqli_query($conn, $query);

$found = false;
session_start();
$role = "";
$blockStatus = "";


while ($row = mysqli_fetch_array($result)) {
   
    if ($row['user_name'] == $_POST['username'] && $row['user_password'] == md5($_POST['password'])) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['user_name'];
        $role = $row['user_role'];
        $blockStatus = $row['user_block_status'];
        $found = true;
        break;
        
    }
}

if ($found) {
    if ($blockStatus === "BLOCKED") {
        echo "<script>alert('Akun Anda diblokir'); window.location.href = '../../FrontEnd/html/Member/Login.html';</script>";
    } else {
        $role === "MEMBER" ? header("Location: ../../FrontEnd/html/Member/HomePage.php") : header("Location: ../../FrontEnd/html/Admin/admin.php");
    }
    exit();
} else {
   echo "<script>alert('Login Gagal'); window.location.href = '../../FrontEnd/html/Member/Login.html';</script>";
}
?>