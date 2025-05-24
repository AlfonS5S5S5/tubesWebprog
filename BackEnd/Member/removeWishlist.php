<?php
require_once __DIR__ . "/../connection.php";

if (isset($_POST['remove_wishlist'])) {
    $gameID = $_POST['game_id'];
    $userID = $_POST['user_id'];
   
    $query = "DELETE FROM wishlist WHERE game_id = $gameID AND user_id = $userID";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Game berhasil dihapus dari wishlist'); window.location.href = '../../FrontEnd/html/Member/Wishlist.php';</script>";
    } else {
        echo "<script>alert('Gagal hapus dari wishlist'); window.location.href = '../html/Member/Wishlist.php';</script>";
    }
}
?>