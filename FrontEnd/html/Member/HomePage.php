<?php
require_once __DIR__ . "/../../../BackEnd/connection.php";
require_once __DIR__ . "/../../../BackEnd/getData.php";
require_once __DIR__ . "/../../../BackEnd/Member/themeBG.php";

include_once 'header.php';

function checkLibrary($conn, $userId, $gameId)
{
    $query = "SELECT * FROM library WHERE user_id = '$userId' AND game_id = '$gameId'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

function checkWishlist($conn, $userId, $gameId)
{
    $query = "SELECT * FROM wishlist WHERE user_id = '$userId' AND game_id = '$gameId'";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result) > 0;
}

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

    <?php if ($isLoggedIn): ?>
    <div class="search-wrapper">
        <div class=search-container>
            <div class="search-box">
                <img src="../../../Assets/icon/search-icon.png" alt="Search" class="search-icon">
                <input type="text" id="searchInput" onkeyup="searchGames(this.value)" placeholder="Search games......"
                    autocomplete="off">
            </div>
            <div id="searchResults" class="search-results"></div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function searchGames(str) {
            if (str.length === 0) {
                document.getElementById("searchResults").style.display = "none";
                return;
            }

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    var resultsDiv = document.getElementById("searchResults");
                    resultsDiv.innerHTML = "";

                    var gameEntries = this.responseText.split('\n');

                    if (gameEntries.length > 0) {
                        gameEntries.forEach(function (entry) {
                            if (entry.trim() !== '') {
                                // Parse the game data from the string
                                var gameData = entry.match(/ID: (.*?), Name: (.*?), Image: (.*?), Price: (.*?)$/);

                                if (gameData) {
                                    var gameDiv = document.createElement('div');
                                    gameDiv.className = 'search-result-item';
                                    // Create a form for each game result
                                    gameDiv.innerHTML = `
                                        <form action="GameDetails.php" method="POST" style="width: 100%;">
                                            <input type="hidden" name="game_id" value="${gameData[1]}">
                                            <button type="submit" name="submit_detail" style="display:none;"></button>
                                            <div class="search-result-content" onclick="this.closest('form').querySelector('button').click();">
                                                <img src="../../../Assets/${gameData[3]}" onerror="this.src='../../../Assets/default-game.jpg'">
                                                <div class="search-result-info">
                                                    <div class="search-result-name">${gameData[2]}</div>
                                                    <div class="search-result-price">Rp ${Number(gameData[4]).toLocaleString()}</div>
                                                </div>
                                            </div>
                                        </form>
                                    `;
                                    resultsDiv.appendChild(gameDiv);
                                }
                            }
                        });
                        resultsDiv.style.display = "block";
                    } else {
                        resultsDiv.style.display = "none";
                    }
                }
            };
            xmlhttp.open("GET", "../../../BackEnd/searchGames.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>

    <main class="store-content">
        <div class="game-container" id="game-section">
            <div class="game-carousel">
                <?php foreach ($currentGames as $game): ?>
                    <div class="game-item">
                        <div class="game-content">
                            <!-- bila sudah login akan menampilkan ini -->
                            <?php if ($isLoggedIn): ?>
                                <form action="GameDetails.php" method="POST" style="width: 100%;">
                                    <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                                    <button type="submit" name="submit_detail" style="display:none;"></button>
                                    <div onclick="this.closest('form').querySelector('button').click();" style="cursor: pointer;">
                                        <img src="../../../Assets/<?php echo htmlspecialchars($game['game_image']); ?>"
                                            alt="<?php echo htmlspecialchars($game['game_name']); ?>" class="game-image"
                                            onerror="this.src='../../../Assets/default-game.jpg'">
                                    </div>
                                </form>
                            <!-- bila belum login (guest) akan terlihat gambar nya saja -->
                            <?php else: ?>
                                <img src="../../../Assets/<?php echo htmlspecialchars($game['game_image']); ?>"
                                alt="<?php echo htmlspecialchars($game['game_name']); ?>" class="game-image"
                                onerror="this.src='../../../Assets/default-game.jpg'">
                            <?php endif; ?>

                            <!-- menampilkan semua dibawah gambar yaitu nama, harga, button wishlist atau Tulisan In Library -->
                            <div class="game-info">
                                <h2><?php echo htmlspecialchars($game['game_name']); ?></h2>
                                <div class="price">Rp <?php echo number_format($game['game_price'], 0, ',', '.'); ?></div>
                                <?php if ($isLoggedIn): ?>
                                    <?php if (!checkLibrary($conn, $_SESSION['user_id'], $game['game_id'])): ?>
                                        <div class="wishlist-overlay">
                                            <?php if (!checkWishlist($conn, $_SESSION['user_id'], $game['game_id'])): ?>
                                                <form action="../../../BackEnd/Member/addToWishlist.php" method="POST">
                                                    <input type="hidden" name="game_id" value="<?php echo $game['game_id']; ?>">
                                                    <button type="submit" name="submit_wishlist" class="wishlist-btn">Add to
                                                        Wishlist</button>
                                                </form>
                                            <?php else: ?>
                                                <div class="owned">Already in wishlist</div>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="owned">In Library</div>
                                    <?php endif; ?>
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