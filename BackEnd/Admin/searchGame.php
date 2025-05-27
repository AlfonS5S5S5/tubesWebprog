<?php
require_once __DIR__ . "../../connection.php";

if (isset($_GET['q'])) {
    $searchGame = $_GET['q'];
    if($searchGame == ""){
        $sql = "SELECT * FROM game";
    }
    $sql = "SELECT * FROM game WHERE game_name LIKE '$searchGame%'";
    $result = mysqli_query($conn, $sql);
    ?>
    <form method="POST" action="../../../BackEnd/Admin/deleteGame.php">
        <table>
            <tr>
                <th>Game ID</th>
                <th>Game Name</th>
                <th>Genre</th>
                <th>Developer</th>
                <th>Release Date</th>
                <th>Price</th>
                <th>Supported OS</th>
                <th>Type</th>
                <th>Image</th>
                <th>CheckBox</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['game_id']; ?></td>
                    <td><?php echo $row['game_name']; ?></td>
                    <td><?php echo $row['game_genre']; ?></td>
                    <td><?php echo $row['game_developer']; ?></td>
                    <td><?php echo $row['game_release_date']; ?></td>
                    <td>Rp <?php echo number_format($row['game_price'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['game_supported_os']; ?></td>
                    <td><?php echo $row['game_type']; ?></td>
                    <td><img src='../../../Assets/<?php echo $row['game_picture']; ?>' alt='<?php echo $row['game_name']; ?>'></td>
                    <td><input type='checkbox' name='selected_games[]' value='<?php echo $row['game_id']; ?>'></td>
                </tr>
            <?php } ?>
        </table>
        <input type="submit" name="delete" value="Delete Selected Games" class="submit-btn">
    </form>
<?php
}
