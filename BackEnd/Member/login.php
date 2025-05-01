<?php
require_once '../connection.php';

$query = "SELECT * FROM users WHERE user_name = '" . $_POST['username'] . "' AND user_password = '" . $_POST['password'] . "'";
$result = mysqli_query($conn, $query);
$found = false;
while ($row = mysqli_fetch_array($result)) {
    echo $row['user_name'];
    if ($row['user_name'] == $_POST['username'] && $row['user_password'] == $_POST['password']) {
        session_start();
        $_SESSION['username'] = $row['user_name'];
        $_SESSION['password'] = $row['user_password'];
        $found = true;
    }
}
if ($found) {
    echo "<script>alert('Login Berhasil'); window.location.href = '../home.html';</script>";
} else {
    echo "<script>alert('Login Gagal'); window.location.href = '../../FrontEnd/html/Member/Login.html';</script>";
}
