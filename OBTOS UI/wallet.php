<!-- <?php
    // require_once '../include/protect.php';
    // require_once '../include/common.php';
?> -->

<!DOCTYPE html>
<html>
    <head>
        <title>The Ultimate Bubble Tea | Store</title>
        <meta name="description" content="This is the description">
        <link rel="stylesheet" href="../include/styles.css" />
        <script src="store.js" async></script>
    </head>
    <body>
        <header class="main-header">
            <nav class="main-nav nav">
                <ul>
                    <li><a href="menu.html">MENU</a></li>
                    <li><a href="locations.html">STORE OUTLETS</a></li>
                    <li><a href="wallet.php">WALLET</a></li>
                    <li><a href="notifications.php">NOTIFICATIONS</a></li>
                </ul>
            </nav>
            <h1 class="store-name store-name-large">The Ultimate Bubble Tea Store</h1>
        </header>
        <div style='float:left; width:60%'>
            <h2>Welcome, <b><?=$name?></b>!</h2>

                <section class="container content-section">
                    <h2 class="section-header">Your E-Wallet</h2>
                        <img class="map-image" src="../Images/wallet.jpg">
                        <h4>Your E-Dollar Balance: <b><u>$<?=$edollar?></u></b></h4>
                        <section class="container content-section">


                        <button class="btn btn-primary shop-item-button" type="button" id='topup'>TOPUP eWallet</button>           

    </body>
</html>
