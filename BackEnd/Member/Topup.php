<?php
session_start();
require_once "../connection.php";

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../FrontEnd/html/Member/Login.html');
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $amount = intval($_POST['amount']);
    $payment_method = $_POST['payment_method'];
    
    if (empty($amount) || $amount <= 0) {
        $_SESSION['error'] = "Please enter a valid amount";
        header('Location: ../../FrontEnd/html/Member/Topup.php');
        exit();
    }

    if (empty($payment_method)) {
        $_SESSION['error'] = "Please select a payment method";
        header('Location: ../../FrontEnd/html/Member/Topup.php');
        exit();
    }

    $update_query = "UPDATE users SET user_wallet = user_wallet + $amount WHERE user_id = $user_id";
    $result = mysqli_query($conn, $update_query);
        
    if ($result) {
        $balance_query = "SELECT user_wallet FROM users WHERE user_id = $user_id";
        $balance_result = mysqli_query($conn, $balance_query);
        $user = mysqli_fetch_assoc($balance_result);
        
        $_SESSION['balance'] = $user['user_wallet'];
        $_SESSION['message'] = "Top up successful! Amount: Rp. " . number_format($amount, 0, ',', '.');
    } else {
        $_SESSION['error'] = "Failed to update wallet balance";
    }
    
    header('Location: ../../FrontEnd/html/Member/Topup.php');
    exit();
}
?>