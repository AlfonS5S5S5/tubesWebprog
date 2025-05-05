<?php
require_once '../connection.php';

$query = "SELECT * FROM users WHERE user_name = '" . $_POST['username'] . "' AND user_password = '" . $_POST['password'] . "'";
$result = mysqli_query($conn, $query);
$found = false;
session_start();
$role = "";
while ($row = mysqli_fetch_array($result)) {
    echo $row['user_name'];
    if ($row['user_name'] == $_POST['username'] && $row['user_password'] == $_POST['password']) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['user_name'];
        $_SESSION['password'] = $row['user_password'];
        $role = $row['user_role'];
        $found = true;
        break;
    }
}
if ($found) {
    // echo "<script>alert('Login Berhasil, welcome $_SESSION[username]'); window.location.href = '../../FrontEnd/html/Member/HomePage.php';</script>";
    echo "<script>alert('Login Gagal'); window.location.href = '../../FrontEnd/html/Member/Login.html';</script>";

    $role === "MEMBER" ? header("Location: ../../FrontEnd/html/Member/HomePage.php") : header("Location: ../../FrontEnd/html/Admin/admin.html");
    exit();
} else {
    session_destroy();
    echo "<script>alert('Login Gagal'); window.location.href = '../../FrontEnd/html/Member/Login.html';</script>";
}
