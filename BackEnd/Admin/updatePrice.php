<?php
session_start();
require_once __DIR__ . '/../connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../FrontEnd/html/Member/Login.html');
    exit();
}

$game_id = isset($_POST['game_id']) ? $_POST['game_id'] : null;
$current_price = isset($_POST['current_price']) ? $_POST['current_price'] : 0;

$sql = "SELECT game_name FROM game WHERE game_id = '$game_id'";
$result = mysqli_query($conn, $sql);
$game = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Price</title>
    <link rel="stylesheet" type="text/css" href="../../FrontEnd/css/updatePriceBackEnd.css">
</head>

<body>
    <div class="form-container">
        <h2>Edit Price for <?php echo $game['game_name']; ?></h2>
        <form action="" method="POST">
            <input type="hidden" name="game_id" value="<?php echo $game_id; ?>">
            <div class="form-group">
                <label for="game_price">Game Price (Rupiah):</label>
                <input type="number" id="game_price" name="game_price"
                        value="<?php echo $current_price; ?>" required>
            </div>

            <div class="button-group">
                <button type="submit" name="submit">Update Price</button>
                <button type="button" onclick="window.location.href='../../FrontEnd/html/Admin/updateGamePrice.php'">Back to List Game</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    if (isset($_POST['submit']) && isset($_POST['game_price']) && isset($_POST['game_id'])) {
    $game_id = $_POST['game_id'];
    $game_price = $_POST['game_price'];

    if ($game_price >= 0) {
        $update = "UPDATE game SET game_price = '$game_price' WHERE game_id = '$game_id'";
        
        if (mysqli_query($conn, $update)) {
            echo "<script>
                    alert('Price updated successfully!');
                    window.location.href='../../FrontEnd/html/Admin/updateGamePrice.php';
                </script>";
        } else {
            echo "<script>alert('Error updating price: " . mysqli_error($conn) . "');
                window.location.href='../../FrontEnd/html/Admin/updateGamePrice.php';
            </script>";
        }
    } else {
        echo "<script>alert('Price cannot be negative!');
            window.location.href='../../FrontEnd/html/Admin/updateGamePrice.php';
        </script>";
    }
}
mysqli_close($conn);
?>