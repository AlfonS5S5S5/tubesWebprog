<?php
session_start();
require_once __DIR__ . '/../connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../FrontEnd/html/Member/Login.html');
    exit();
}

if (isset($_POST['accept'])) {
    $user_id = $_POST['user_id'];
    
    mysqli_query($conn, "UPDATE users SET user_role = 'CREATOR' WHERE user_id = '$user_id'");

    echo "<script>
            alert('User role has been changed to CREATOR successfully!');
            window.location.href='../../FrontEnd/html/Admin/changeUserRole.php';
        </script>";
}
mysqli_close($conn);
?>