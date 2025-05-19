<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../connection.php";
require_once __DIR__ . "/../getData.php";

if (!isset($_POST['submit_purchase']) || !isset($_POST['game_id']) || !isset($_POST['user_id'])) {
    header("Location: ../../../FrontEnd/html/Member/HomePage.php");
    exit();
}

$userId = $_POST['user_id'];
$gameId = $_POST['game_id'];

$currentBalance = getCurrentBalance($conn, $userId);

$query = "SELECT game_price FROM game WHERE game_id = '$gameId'";
$result = mysqli_query($conn, $query);
$game = mysqli_fetch_assoc($result);

if (!$game) {
    echo "Game Not Found";
    header("Location: /../../FrontEnd/html/Member/HomePage.php");
    exit();
}

if ($currentBalance < $game['game_price']) {
    echo "Insufficient balance. Please top up your wallet.";
    header("Location: ../../FrontEnd/html/Member/Topup.php");
    exit();
}

$afterPurchase = $currentBalance - $game['game_price'];
$updateBalance = "UPDATE users SET user_wallet = $afterPurchase WHERE user_id = $userId";
$addtoLibrary = "INSERT INTO library (user_id, game_id, library_buy_game_price) VALUES ('$userId', '$gameId', $game[game_price])";
$deleteWishlist = "DELETE FROM wishlist WHERE user_id = '$userId' AND game_id = '$gameId'";
$selectWishlist = "SELECT * FROM wishlist WHERE user_id = '$userId' AND game_id = '$gameId'";


if (mysqli_query($conn, $updateBalance) && mysqli_query($conn, $addtoLibrary)) {
    echo "<script>alert('Purchase successful!'); window.location.href = '../../FrontEnd/html/Member/Library.php';</script>";

    if (mysqli_num_rows(mysqli_query($conn, $selectWishlist)) > 0) {
        mysqli_query($conn, $deleteWishlist);
    }
   exit();
}
