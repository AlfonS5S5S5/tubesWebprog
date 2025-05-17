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
    <title>Add New Game</title>
    <link rel="stylesheet" type="text/css" href="../../css/addGame.css">
</head>
<body>
    <div class="form-container">
        <h2>Add New Game</h2>
        <form action="../../../BackEnd/Admin/addGame.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="game_name">Game Name:</label>
                <input type="text" id="game_name" name="game_name" required>
            </div>

            <div class="form-group">
                <label for="game_genre">Game Genre:</label>
                <select id="game_genre" name="game_genre" required>
                    <option value="">Select Genre</option>
                    <option value="Action">Action</option>
                    <option value="Adventure">Adventure</option>
                    <option value="RPG">RPG</option>
                    <option value="Strategy">Strategy</option>
                    <option value="Sports">Sports</option>
                    <option value="Simulation">Simulation</option>
                    <option value="Horror">Horror</option>
                    <option value="Racing">Racing</option>
                    <option value="FPS">FPS</option>
                </select>
            </div>

            <div class="form-group">
                <label for="game_developer">Game Developer:</label>
                <input type="text" id="game_developer" name="game_developer" required>
            </div>

            <div class="form-group">
                <label for="game_release_date">Release Date:</label>
                <input type="date" id="game_release_date" name="game_release_date" required>
            </div>

            <div class="form-group">
                <label for="game_price">Game Price (Rupiah):</label>
                <input type="number" id="game_price" name="game_price" required>
            </div>

            <div class="form-group">
                <label for="game_supported_os">Supported OS:</label>
                <select id="game_supported_os" name="game_supported_os" required>
                    <option value="">Select OS</option>
                    <option value="Windows 10">Windows 10</option>
                    <option value="Windows 11">Windows 11</option>
                </select>
            </div>

            <div class="form-group">
                <label for="game_type">Game Type:</label>
                <select id="game_type" name="game_type" required>
                    <option value="">Select Type</option>
                    <option value="Multiplayer">Multiplayer</option>
                    <option value="SinglePlayer">SinglePlayer</option>
                </select>
            </div>

            <div class="form-group">
                <label for="game_picture">Game Picture:</label>
                <input type="file" id="game_picture" name="game_picture" accept="image/*" required>
            </div>

            <div class="button-group">
                <button type="submit" name="submit">Add Game</button>
                <button type="button" onclick="window.location.href='admin.php'">Back to Dashboard</button>
            </div>
        </form>
    </div>
</body>
</html>