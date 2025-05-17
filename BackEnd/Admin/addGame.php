<?php
session_start();
require_once __DIR__ . '/../connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../FrontEnd/html/Member/Login.html');
    exit();
}
if (isset($_POST['submit'])) {
    $game_name = $_POST['game_name'];
    $game_genre = $_POST['game_genre'];
    $game_developer = $_POST['game_developer'];
    $game_release_date = $_POST['game_release_date'];
    $game_price = $_POST['game_price'];
    $game_supported_os = $_POST['game_supported_os'];
    $game_type = $_POST['game_type'];

    //buat gambar nya
    $image = $_FILES['game_picture'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    $dir = __DIR__ . "/../../Assets/";
    $fileName = $image["name"];
    $targetFile = $dir . $fileName;
    $path = $fileName;

    $query = "INSERT INTO game (
        game_name,
        game_genre,
        game_developer,
        game_release_date,
        game_price,
        game_supported_os,
        game_type,
        game_picture
    ) VALUES (
        '$game_name',
        '$game_genre',
        '$game_developer',
        '$game_release_date',
        '$game_price',
        '$game_supported_os',
        '$game_type',
        '$path'
    )";
    if (move_uploaded_file($image["tmp_name"], $targetFile)) {
        if (mysqli_query($conn, $query)) {
            echo "<script>
                    alert('Game added successfully!');
                    window.location.href='../../FrontEnd/html/Admin/admin.php';
                </script>";
        } else {
            echo "<script>
                    alert('Error adding game: " . mysqli_error($conn) . "');
                    window.location.href='../../FrontEnd/html/Admin/addGame.php';
                </script>";
        }
    } else {
        echo "<script>
                alert('Failed to upload image file.');
                window.location.href='../../FrontEnd/html/Admin/addGame.php';
            </script>";
    }
    mysqli_close($conn);
}

?>