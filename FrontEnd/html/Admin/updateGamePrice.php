<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Member/Login.html");
    exit();
}

require_once __DIR__ . "/../../../BackEnd/connection.php";

$sql = "SELECT * FROM game";
$result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Game Price</title>
    <link rel="stylesheet" type="text/css" href="../../css/updatePrice.css">
</head>

</html>

<body>
    <table>
        <tr>
            <th>Game ID</th>
            <th>Game Name</th>
            <th>Genre</th>
            <th>Developer</th>
            <th>Release Date</th>
            <th>Price</th>
            <th>Supported OS</th>
            <th>Type</th>
            <th>Image</th>
            <th>Edit Price</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['game_id'] . "</td>";
            echo "<td>" . $row['game_name'] . "</td>";
            echo "<td>" . $row['game_genre'] . "</td>";
            echo "<td>" . $row['game_developer'] . "</td>";
            echo "<td>" . $row['game_release_date'] . "</td>";
            echo "<td>Rp " . number_format($row['game_price'], 0, ',', '.') . "</td>";
            echo "<td>" . $row['game_supported_os'] . "</td>";
            echo "<td>" . $row['game_type'] . "</td>";
            echo "<td><img src='../../../Assets/" . $row['game_picture'] . "' alt='" . $row['game_name'] . "'></td>";
            echo "<td>
                        <form action='../../../BackEnd/Admin/updatePrice.php' method='POST'>
                            <input type='hidden' name='game_id' value='" . $row['game_id'] . "'>
                            <input type='hidden' name='current_price' value='" . $row['game_price'] . "'>
                            <input type='submit' value='Edit Price' class='edit-btn'>
                        </form>
                    </td>";
            echo "</tr>";
        }
        ?>
    </table>
    <a href="admin.php" class="back-btn">Back to Dashboard</a>
</body>

</html>