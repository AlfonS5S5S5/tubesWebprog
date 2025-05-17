<?php
session_start();
require_once __DIR__ . '/../connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../FrontEnd/html/Member/Login.html');
    exit();
}

// Block
if (isset($_POST['block'])) {
    $user_id = $_POST['user_id'];
    $block_reason = $_POST['block_reason'];

    $block_sql = "INSERT INTO block (user_id, block_reason, block_status)
                VALUES ('$user_id', '$block_reason', 'ACCEPTED')";

    // Update user block status
    $update_sql = "UPDATE users SET user_block_status = 'BLOCKED'
                WHERE user_id = '$user_id'";

    if (mysqli_query($conn, $block_sql) && mysqli_query($conn, $update_sql)) {
        echo "<script>
                alert('User has been blocked successfully!');
                window.location.href='../../FrontEnd/html/Admin/blockUser.php';
            </script>";
    } else {
        echo "<script>
                alert('Error blocking user: " . mysqli_error($conn) . "');
                window.location.href='../../FrontEnd/html/Admin/blockUser.php';
            </script>";
    }
}

// Unblock
if (isset($_POST['unblock'])) {
    $user_id = $_POST['user_id'];

    $block_sql = "DELETE FROM block WHERE user_id = '$user_id'";

    $update_sql = "UPDATE users SET user_block_status = 'UNBLOCKED'
                WHERE user_id = '$user_id'";

    if (mysqli_query($conn, $block_sql) && mysqli_query($conn, $update_sql)) {
        echo "<script>
                    alert('User Unblocked successfully!');
                    window.location.href='../../FrontEnd/html/Admin/blockUser.php';
                </script>";
    } else {
        echo "<script>
                alert('Error unblocking user: " . mysqli_error($conn) . "');
                window.location.href='../../FrontEnd/html/Admin/blockUser.php';
            </script>";
    }
}

if (!isset($_POST['block']) && !isset($_POST['unblock'])) {
    header("Location: ../../FrontEnd/html/Admin/blockUser.php");
    exit();
}

mysqli_close($conn);
?>