<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Member/Login.html");
    exit();
}

require_once __DIR__ . "/../../../BackEnd/connection.php";

$sql = "SELECT * FROM block WHERE block_status = 'PENDING' ORDER BY block_id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Block Reports</title>
    <link rel="stylesheet" type="text/css" href="../../css/blockUser.css">
</head>
<body>
    <div class="container">
        <h1>Manage Block Reports</h1>
        <table>
            <tr>
                <th>Report ID</th>
                <th>User ID</th>
                <th>Block Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Get user information
                    $user_id = $row['user_id'];
                    $query = "SELECT user_name FROM users WHERE user_id = '$user_id'";
                    $result = mysqli_query($conn, $query);
                    $data = mysqli_fetch_assoc($result);
                    $username = $data ? $data['user_name'] : 'Unknown User';
                    
                    echo "<tr>";
                    echo "<td>" . $row['block_id'] . "</td>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['block_reason'] . "</td>";
                    echo "<td class='" . strtolower($row['block_status']) . "'>" . $row['block_status'] . "</td>";
                    echo "<td>";
                    echo "<form action='../../../BackEnd/Admin/manageBlock.php' method='POST'>
                            <input type='hidden' name='block_id' value='" . $row['block_id'] . "'>
                            <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                            <input type='submit' name='accept' value='Accepted' class='block-btn'>
                        </form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No pending block reports found</td></tr>";
            }
            ?>
        </table>
        
        <h2>Blocked Users</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
            <?php
            $blocked_sql = "SELECT user_id, user_name FROM users WHERE user_block_status = 'BLOCKED'";
            $blocked_result = mysqli_query($conn, $blocked_sql);
            
            if (mysqli_num_rows($blocked_result) > 0) {
                while ($row = mysqli_fetch_assoc($blocked_result)) {
                    echo "<tr>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['user_name'] . "</td>";
                    echo "<td>";
                    echo "<form action='../../../BackEnd/Admin/manageBlock.php' method='POST'>
                            <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                            <input type='submit' name='unblock' value='Unblock User' class='unblock-btn'>
                        </form>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No blocked users found</td></tr>";
            }
            ?>
        </table>
        <a href="admin.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>