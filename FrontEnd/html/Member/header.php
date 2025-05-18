<!DOCTYPE html>
<html lang="en">

<head>
    <title>Footer</title>
</head>
<?php
session_start();
?>
<style>
    .steam-header {
        background: #171a21;
        padding: 1rem 2rem;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .steam-header img {
        height: 40px;
        margin-right: 2rem;
    }

    .steam-nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .nav-left {
        display: flex;
        list-style: none;
        gap: 24px;
        align-items: center;
    }

    .nav-left li a {
        color: #c6d4df;
        text-decoration: none;
        font-size: 14px;
        padding: 8px 12px;
        transition: all 0.2s ease;
        border-radius: 2px;
    }

    .nav-left li a:hover {
        color: #ffffff;
        background: rgba(255, 255, 255, 0.1);
    }

    .nav-right {
        list-style: none;
        position: relative;
    }

    .user-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background: #171a21;
        border: 1px solid #2a475e;
        border-radius: 2px;
        min-width: 200px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
        margin-top: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .nav-right:hover .user-dropdown {
        opacity: 1;
        visibility: visible;
    }

    .dropdown-item {
        display: block;
        padding: 10px 15px;
        color: #c6d4df;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .dropdown-divider {
        height: 1px;
        background: #2a475e;
        margin: 5px 0;
    }

    .user-profile {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.1);
        padding: 6px 12px;
        border-radius: 3px;
        transition: background 0.2s ease;
        min-width: fit-content;
    }

    .user-profile:hover {
        background: rgba(255, 255, 255, 0.15);
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 2px;
        object-fit: cover;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 200px;
    }

    .wallet-balance {
        color: #a4d007;
        font-size: 13px;
        font-weight: 500;
        text-align: center;
        flex: 1;
        margin: 0;
    }

    .login-button {
        color: #fff;
        background: #66c0f4;
        padding: 5px 10px;
        border-radius: 2px;
        text-decoration: none;
        margin-left: 10px;
        font-size: 13px;
        transition: background 0.2s;
    }

    .login-button:hover {
        background: #7fd3ff;
    }
</style>

<body>

    <?php

    if (isset($_SESSION['user_id'])) {
        require_once __DIR__ . "/../../../BackEnd/connection.php";
        require_once __DIR__ . "/../../../BackEnd/getData.php";

        updateUserSession($conn, $_SESSION['user_id']);

        $userId = $_SESSION['user_id'];
        $query = "SELECT user_profile_picture FROM users WHERE user_id = $userId";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        $profilePicture = $user['user_profile_picture'] ? "../../../" . $user['user_profile_picture'] : "../../../Assets/profile/default-avatar.png";
    }


    ?>

    <header class="steam-header">
        <img src="../../../Assets/logo/steam-logo.png" alt="Steam Logo">
        <nav class="steam-nav">
            <ul class="nav-left">
                <li><a href="HomePage.php">Home Page</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="Library.php">Library</a></li>
                    <li><a href="WishList.php">Wishlist</a></li>
                    <li><a href="TopUp.php">TopUp</a></li>
                <?php endif; ?>
            </ul>
            <div class="nav-right">
                <div class="user-profile">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="user-info">
                            <img src="<?php echo $profilePicture; ?>"
                                alt="User Profile Picture"
                                class="user-avatar"
                                onerror="this.src='../../../Assets/profile/default-avatar.png'">
                            <span class="wallet-balance">
                                Rp. <?php echo number_format($_SESSION['balance'] ?? 0, 0, ',', '.'); ?>
                            </span>
                        </div>
                        <div class="user-dropdown">
                            <a href="Profile.php" class="dropdown-item">View Profile</a>
                            <div class="dropdown-divider"></div>
                            <a href="../../../BackEnd/logout.php" class="dropdown-item">Logout</a>
                        </div>
                    <?php else: ?>
                        <div class="user-info">
                            <img src="../../../Assets/profile/default-avatar.png"
                                alt="Default Avatar"
                                class="user-avatar">
                            <a href="../../../FrontEnd/html/Member/Login.html" class="login-button">Login</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
</body>

</html>