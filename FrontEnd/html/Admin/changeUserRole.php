<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Member/Login.html");
    exit();
}

require_once __DIR__ . "/../../../BackEnd/connection.php";

$sql = "SELECT * FROM users WHERE user_role = 'MEMBER'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage User</title>
    <link rel="stylesheet" type="text/css" href="../../css/blockUser.css">
</head>

<body>
    <div class="container">
        <h1>Manage User</h1>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>User Blocked Status</th>
                <th>User Role</th>
            </tr>
            <?php
            if (mysqli_num_rows($result) > 0) {
                $user_rows = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $user_rows[] = $row;
                }

                foreach ($user_rows as $row) {
                    $user_id = $row['user_id'];
                    $user_query = "SELECT user_name, user_role FROM users WHERE user_id = '$user_id'";
                    $user_result = mysqli_query($conn, $user_query);
                    $user_data = mysqli_fetch_assoc($user_result);
                    $username = $user_data ? $user_data['user_name'] : 'Unknown User';

                    $user_role = $user_data ? $user_data['user_role'] : '';
                    if ($user_role !== 'ADMIN') {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['user_name'] . "</td>";
                        echo "<td>" . $row['user_role'] . "</td>";
                        echo "<td>";
                        echo "<form action='../../../BackEnd/Admin/changeUserRole.php' method='POST'>
                        <input type='hidden' name='user_id' value='" . $row['user_id'] . "'>
                        <input type='submit' name='accept' value='Change' class='block-btn'>
                    </form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='5'>No Available Member found</td></tr>";
            }
            ?>
        </table>

        <a href="admin.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>

</html>