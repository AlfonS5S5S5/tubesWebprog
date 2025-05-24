<?php
session_start();
require_once __DIR__ . '/../connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../FrontEnd/html/Member/Login.html');
    exit();
}

if (isset($_POST['accept'])) {
    $block_id = $_POST['block_id'];
    $user_id = $_POST['user_id'];
    
    // ubah semua status jadi accepted buat id tertentu
    mysqli_query($conn, "UPDATE block SET block_status = 'ACCEPTED' WHERE user_id = '$user_id' AND block_id != '$block_id'");

    // block
    mysqli_query($conn, "UPDATE users SET user_block_status = 'BLOCKED' WHERE user_id = '$user_id'");

    // hapus report nya
    mysqli_query($conn, "DELETE FROM block WHERE block_id = '$block_id'");

    echo "<script>
            alert('User has been blocked successfully!');
            window.location.href='../../FrontEnd/html/Admin/blockUser.php';
        </script>";
}

// Unblock a user
if (isset($_POST['unblock'])) {
    $user_id = $_POST['user_id'];
    
    mysqli_query($conn, "UPDATE users SET user_block_status = 'UNBLOCKED' WHERE user_id = '$user_id'");
    
    echo "<script>
            alert('User has been unblocked successfully!');
            window.location.href='../../FrontEnd/html/Admin/blockUser.php';
        </script>";
}

if (!isset($_POST['accept']) && !isset($_POST['unblock'])) {
    header("Location: ../../FrontEnd/html/Admin/blockUser.php");
    exit();
}

mysqli_close($conn);
?>