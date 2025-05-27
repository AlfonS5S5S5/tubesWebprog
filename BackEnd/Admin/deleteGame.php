<?php
session_start();
require_once __DIR__ . '/../connection.php';
    if (!empty($_POST['delete']) && !empty($_POST['selected_games'])) {
        $arrayDel = implode(",", array_map('intval', $_POST['selected_games']));
        $sql = "DELETE FROM game WHERE game_id IN ($arrayDel)";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
            alert('Game Deleted successfully!');
            window.location.href='../../FrontEnd/html/Admin/deleteGame.php';
            </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
?>
