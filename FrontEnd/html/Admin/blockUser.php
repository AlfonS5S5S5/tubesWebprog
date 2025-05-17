<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Member/Login.html");
    exit();
}

require_once __DIR__ . "/../../../BackEnd/connection.php";

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="../../css/blockUser.css">
</head>
<body>
    <div class="container">
        <h1>Manage Users</h1>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Wallet</th>
                <th>Block Status</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['user_role'] !== 'ADMIN') { // Only show non-admin users
                    echo "<tr>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['user_name'] . "</td>";
                    echo "<td>Rp " . number_format($row['user_wallet'], 0, ',', '.') . "</td>";
                    echo "<td class='" . strtolower(string: $row['user_block_status']) . "'>" . $row['user_block_status'] . "</td>";
                    echo "<td>" . $row['user_role'] . "</td>";
                    echo "<td>";
                    if ($row['user_block_status'] == 'UNBLOCKED') {
                        echo "<form action='../../../BackEnd/Admin/manageBlock.php' method='POST'>
                                <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                                <select name='block_reason' required>
                                    <option value=''>Select Reason</option>
                                    <option value='Death Threat'>Death Threat</option>
                                    <option value='Racist'>Racist</option>
                                    <option value='Harrashment'>Harrashment</option>
                                    <option value='Bad Violance'>Bad Violance</option>
                                    <option value='Hate Speech'>Hate Speech</option>
                                </select>
                                <input type='submit' name='block' value='Block User' class='block-btn'>
                            </form>";
                    } else {
                        echo "<form action='../../../BackEnd/Admin/manageBlock.php' method='POST'>
                                <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                                <input type='submit' name='unblock' value='Unblock User' class='unblock-btn'>
                            </form>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
        <a href="admin.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>