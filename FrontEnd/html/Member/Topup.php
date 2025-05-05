<?php
    include_once 'header.php';
    require_once __DIR__ . "/../../../BackEnd/connection.php";
    require_once __DIR__ . "/../../../BackEnd/getData.php";

    updateUserSession($conn, $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam Wallet Top Up</title>
    <link rel="stylesheet" href="../../../FrontEnd/css/Topup.css">
</head>
<body>
    <main class="content">
        <div class="wallet-container">
            <h1>Add funds to your Steam Wallet</h1>
            
            <div class="balance-info">
                <h2>Current Balance: Rp. <?php echo number_format($_SESSION['balance'], 0, ',', '.'); ?></h2>
                <?php if(isset($_SESSION['message'])): ?>
                    <div class="message success" id="successMessage">
                        <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
    
            <form id="topupForm" action="../../../BackEnd/Member/Topup.php" method="POST">
            <div class="amount-selection">
                <h3>Select the amount to add:</h3>
                <div class="amount-grid">
                    <button type="button" class="amount-btn" data-amount="45000">Rp. 45.000</button>
                    <button type="button" class="amount-btn" data-amount="90000">Rp. 90.000</button>
                    <button type="button" class="amount-btn" data-amount="225000">Rp. 225.000</button>
                    <button type="button" class="amount-btn" data-amount="450000">Rp. 450.000</button>
                    <button type="button" class="amount-btn" data-amount="900000">Rp. 900.000</button>
                </div>

                <div class="custom-amount">
                    <h3>Or enter custom amount:</h3>
                    <div class="custom-input-wrapper">
                        <span class="currency-prefix">Rp.</span>
                        <input type="number"
                            id="custom_amount"
                            placeholder="Enter amount"
                            min="10"
                            max="1000"
                            step="1">
                    </div>
                </div>

                <input type="hidden" name="amount" id="selected_amount" required>
            </div>
    
                <div class="payment-methods">
                    <h3>Select payment method:</h3>
                    <div class="payment-options">
                        <div class="payment-option">
                            <input type="radio" name="payment_method" id="dana" value="Dana">
                            <label for="dana">Dana</label>
                        </div>
                    </div>
                </div>
                <button type="submit" id="purchase-btn" class="purchase-btn">Purchase</button>
            </form>
        </div>
    </main>

    <?php
        include_once 'footer.html';
    ?>

    <script>
        const amountButtons = document.querySelectorAll('.amount-btn');
        const selectedAmountInput = document.getElementById('selected_amount');
        const customAmountInput = document.getElementById('custom_amount');

        amountButtons.forEach(button => {
            button.addEventListener('click', () => {
                amountButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                selectedAmountInput.value = button.getAttribute('data-amount');
                customAmountInput.value = '';
            });
        });

        customAmountInput.addEventListener('input', () => {
            amountButtons.forEach(btn => btn.classList.remove('active'));
            selectedAmountInput.value = customAmountInput.value;
        });
    </script>
</body>
</html>