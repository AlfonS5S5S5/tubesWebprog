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
        <img src="../../../Assets/Background/<?php echo $backgroundImage; ?>"
            alt="Musim Background"
            class="background"
            id="musim-BG">
    </div>

    <main class="store-content">
        <div class="game-container" id="game-section">
            <div class="carousel-wrapper">
                <button class="nav-button prev" data-page="<?php echo ($currentPage <= 0) ? ($totalPages - 1) : ($currentPage - 1); ?>">
                    &lt;
                </button>

                <div class="game-carousel">
                    <?php foreach ($currentGames as $game): ?>
                        <div class="game-item">
                            <?php if ($isLoggedIn): ?>
                                <form action="GameDetails.php" method="POST">
                                    <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                                    <button type="submit" name="submit_detail" class="wishlist-btn">Game Details </button>
                                </form>
                            <?php else: ?>
                                <a href="Login.html" class="game-link not-logged"></a>
                            <?php endif; ?>
                                <img src="../../../Assets/<?php echo htmlspecialchars($game['game_image']); ?>"
                                    alt="<?php echo htmlspecialchars($game['game_name']); ?>"
                                    class="game-image"
                                    onerror="this.src='../../../Assets/default-game.jpg'">
                                <div class="game-content">
                                    <div class="game-info">
                                        <h2><?php echo htmlspecialchars($game['game_name']); ?></h2>
                                        <div class="price">Rp <?php echo number_format($game['game_price'], 0, ',', '.'); ?></div>
                                        <?php if ($isLoggedIn): ?>
                                            <div class="wishlist-overlay">
                                                <form action="../../../BackEnd/Member/addToWishlist.php" method="POST">
                                                    <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                                                    <button type="submit_wishlist" class="wishlist-btn">Add to Wishlist</button>
                                                </form>
                                                
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="nav-button next" data-page="<?php echo ($currentPage >= $totalPages - 1) ? 0 : ($currentPage + 1); ?>">
                    &gt;
                </button>
            </div>

            <div class="page-indicators">
                <?php for ($i = 0; $i < $totalPages; $i++): ?>
                    <span class="indicator <?php echo $i === $currentPage ? 'active' : ''; ?>"
                        onclick="window.location.href='?page=<?php echo $i; ?>#game-section'">
                    </span>

                <?php endfor; ?>
            </div>
        </div>
    </main>

    <?php include_once 'footer.html'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.nav-button');

            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.getAttribute('data-page');

                    fetch(`?page=${page}`)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            const newCarousel = doc.querySelector('.game-carousel');
                            document.querySelector('.game-carousel').innerHTML = newCarousel.innerHTML;

                            const newIndicators = doc.querySelector('.page-indicators');
                            document.querySelector('.page-indicators').innerHTML = newIndicators.innerHTML;

                            history.pushState({}, '', `?page=${page}`);

                            const newButtons = doc.querySelectorAll('.nav-button');
                            buttons.forEach((btn, index) => {
                                btn.setAttribute('data-page', newButtons[index].getAttribute('data-page'));
                            });
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
</body>

</html>