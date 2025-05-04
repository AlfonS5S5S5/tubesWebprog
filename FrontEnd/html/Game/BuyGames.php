<!DOCTYPE html>
<html lang="en">

<head>
    <title>Buy Games</title>
    <link rel="stylesheet" type="text/css" href="../../css/BuyGames.css">
</head>

<body>
    <?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        header("Location: ../Member/Login.html");
        exit();
    }

    require_once __DIR__ . "/../../../BackEnd/connection.php";
    require_once __DIR__ . "/../../../BackEnd/getData.php";

    if (!isset($_POST['game_id']) || empty($_POST['game_id'])) {
        header("Location: ../Member/HomePage.php");
        exit();
    }

    $gameId = $_POST['game_id'];
    $games = getGames($conn);
    $game = null;

    foreach ($games as $gem) {
        if ($gem['game_id'] == $gameId) {
            $game = $gem;
            break;
        }
    }

    if (!$game) {
        header("Location: ../Member/HomePage.php");
        exit();
    }

    ?>

    <?php
        include_once '../Member/header.php';
    ?>
    <main class="purchase-container">
        <div class="game-info">
            <div class="game-header">
                <img src="../../../Assets/<?php echo htmlspecialchars($game['game_image']); ?>"
                    alt="<?php echo htmlspecialchars($game['game_name']); ?>" class="game-image"
                    onerror="this.src='../../../Assets/default-game.jpg'">
                <div class="game-title">
                    <h1><?php echo htmlspecialchars($game['game_name']); ?></h1>
                    <p class="developer"><?php echo htmlspecialchars($game['game_developer']); ?></p>
                </div>
            </div>

            <div class="purchase-details">
                <div class="price-info">
                    <h2>Purchase Summary</h2>
                    <div class="price-line">
                        <span>Price:</span>
                        <span>Rp <?php echo number_format($game['game_price'], 0, ',', '.'); ?></span>
                    </div>
                    <div class="price-line total">
                        <span>Total:</span>
                        <span>Rp <?php echo number_format($game['game_price'], 0, ',', '.'); ?></span>
                    </div>
                </div>

                <form action="../../../BackEnd/Game/processPurchase.php" method="POST" class="payment-form">
                    <input type="hidden" name="game_id" value="<?php echo htmlspecialchars($gameId); ?>">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">

                    <div class="agreement">
                        <label>
                            <input type="checkbox" name="agree" required>
                            I agree to the terms of purchase and confirm I am the account holder
                        </label>
                    </div>

                    <button type="submit" name="submit_purchase" class="purchase-button">
                        Purchase for Rp <?php echo number_format($game['game_price'], 0, ',', '.'); ?>
                    </button>
                </form>
            </div>
        </div>
    </main>
    <?php include_once '../Member/footer.html'; ?>
</body>

</html>