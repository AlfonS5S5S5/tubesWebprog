<?php
require_once __DIR__ . "/../../../BackEnd/connection.php";
require_once __DIR__ . "/../../../BackEnd/getData.php";
require_once __DIR__ . "/../../../BackEnd/Member/themeBG.php";

include_once 'header.php';
$isLoggedIn = isset($_SESSION['user_id']);
$showLoginButton = !$isLoggedIn;

$games = getGames($conn);
$gamesPerPage = 4;
$currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 0;
$totalPages = ceil(count($games) / $gamesPerPage);
$backgroundImage = getMusimBG();

if ($currentPage < 0) {
    $currentPage = $totalPages - 1;
} elseif ($currentPage >= $totalPages) {
    $currentPage = 0;
}

$currentGames = array_slice($games, $currentPage * $gamesPerPage, $gamesPerPage);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Steam</title>
    <link rel="stylesheet" href="../../css/home.css">
</head>

<body>
    <div class="background">
        <img src="../../../Assets/Background/<?php echo $backgroundImage; ?>" alt="Musim Background" class="background"
            id="musim-BG">
    </div>

    <main class="store-content">
        <div class="game-container" id="game-section">
            <div class="game-carousel">
                <?php foreach ($currentGames as $game): ?>
                    <div class="game-item">
                        <?php if ($isLoggedIn): ?>
                            <form action="GameDetails.php" method="POST">
                                <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                                <button type="submit" name="submit_detail" class="wishlist-btn">Game Details</button>
                            </form>
                        <?php endif; ?>

                        <img src="../../../Assets/<?php echo htmlspecialchars($game['game_image']); ?>"
                            alt="<?php echo htmlspecialchars($game['game_name']); ?>" class="game-image"
                            onerror="this.src='../../../Assets/default-game.jpg'">

                        <div class="game-content">
                            <div class="game-info">
                                <h2><?php echo htmlspecialchars($game['game_name']); ?></h2>
                                <div class="price">Rp <?php echo number_format($game['game_price'], 0, ',', '.'); ?></div>
                                <?php if ($isLoggedIn): ?>
                                    <div class="wishlist-overlay">
                                        <form action="../../../BackEnd/Member/addToWishlist.php" method="POST">
                                            <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                                            <button type="submit" name="submit_wishlist" class="wishlist-btn">Add to
                                                Wishlist</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pagination">
                <?php if ($currentPage > 0): ?>
                    <a href="?page=<?php echo ($currentPage - 1); ?>" class="page-nav">&laquo; Previous</a>
                <?php endif; ?>

                <?php for ($i = 0; $i < $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>"
                        class="page-number <?php echo $i === $currentPage ? 'active' : ''; ?>">
                        <?php echo ($i + 1); ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages - 1): ?>
                    <a href="?page=<?php echo ($currentPage + 1); ?>" class="page-nav">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include_once 'footer.html'; ?>

</body>

</html>