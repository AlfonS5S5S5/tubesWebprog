<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Member/Login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../../css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Admin Dashboard</h1>
        
        <a href="addGame.php" class="admin-option">Add New Game</a>
        <a href="deleteGame.php" class="admin-option">Delete Game</a>
        <a href="updateGamePrice.php" class="admin-option">Update Game Price</a>
        <a href="blockUser.php" class="admin-option">Manage Users</a>
        
        <a href="../../../BackEnd/logout.php" style="color: red; text-decoration: none; display: block; text-align: center; margin-top: 20px;">Logout</a>
    </div>
</body>
</html>