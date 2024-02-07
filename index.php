<?php
// include auth_session.php file on all user panel pages
include("auth_session.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAQR STORE</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <script src="https://kit.fontawesome.com/aa7454d09f.js" crossorigin="anonymous"></script>
    <script src="js/script.js" type="module"></script>
    <link rel="shortcut icon" href="img/fav.png" />
    <link href="https://goSellJSLib.b-cdn.net/v2.0.0/css/gosell.css" rel="stylesheet" />
</head>

<body>
    <script type="text/javascript" src="https://goSellJSLib.b-cdn.net/v2.0.0/js/gosell.js"></script>

    <body>
        <div id="alertMessage" class="alert">
            You can only add up to 3 items to the cart.
        </div>
        <!-- Header -->
        <header>
            <div class="leftItem">
                <nav class="nav">
                    <?php
                    if (isset($_SESSION['username'])) {
                        // User is logged in
                        echo '<div class="welcome-hover"><p style="font-weight:bold; color: #0079ff;" class="welcome-text">Account</p>';
                        echo '<div class="logout-box"><a href="logout.php">Logout</a> <br> <a href="change_password.php">Password</a></div></div>';
                    } else {
                        // User is not logged in
                        echo '<a href="login.php" class="navLink" style="font-weight:bold; color: #0079ff;">Login/Register</a>';
                    }
                    ?>
                    <a href="discord.gg/saqr" class="navLink">Discord</a>
                    <a href="contact.php" class="navLink">Tickets</a>
                </nav>
            </div>
            <div class="rightItem" id="shoppingCart">
                <span class="totalItem" id="totalItem"></span>
                <i class="fa-solid fa-cart-shopping navLink"></i>
            </div>
        </header>
        <main class="main">
            <img src="img/logo.png" alt="">
            <h3>FiveM Scripts & Files</h3>
        </main>
        <!-- Item Cards -->

        <div class="itemContainer" id="itemContainer"></div>
        <div class="cartContainer" id="cartContainer">
            <div id="closeCart">
                <h3 class="closeCart">Close</h3>
            </div>
            <h1 id="cartTitle">No Item</h1>

            <!-- each cart Container -->
            <div id="eachCartItemContainer"></div>

            <div id="totalPriceContainer">
                <p>Total Price <span id="totalPrice"></span>$</p>
            </div>
            <div id="paymentContainer" style="display: none;">
                <div id="root"></div>
                <?php
                if (isset($_SESSION['username'])) {
                    // User is logged in, display "Pay Now" button
                    echo '<button id="payNowButton" onclick="goSell.openPaymentPage()">Pay Now</button>';
                } else {
                    // User is not logged in, display "Login to Pay" button
                    echo '<button onclick="window.location.href=\'login.php\';" id="loginToPayButton">Login to Pay</button>';
                }
                ?>
                <div id="icons" class="icons">
                    <i class="fa-brands fa-cc-visa"></i>
                    <i class="fa-brands fa-cc-mastercard"></i>
                    <i class="fa-brands fa-paypal"></i>
                    <i class="fa-brands fa-cc-apple-pay"></i>
                    <i class="fa-brands fa-google-pay"></i>
                </div>
            </div>
        </div>
        <section class="footer">
            <div class="footer-row">
                <div class="footer-col">
                    <h4>Info</h4>
                    <ul class="links">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Discord</a></li>
                        <li><a href="#">Ticekts</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Services</h4>
                    <ul class="links">
                        <li><a href="#">Scripts</a></li>
                        <li><a href="#">Files</a></li>
                        <li><a href="#">Custom</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Others</h4>
                    <ul class="links">
                        <li><a href="#">Terms</a></li>
                        <li><a href="#">Partner</a></li>
                        <li><a href="adminlogin.php">Admin</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Discord</h4>
                    <p>
                        Join our Discord for the latest news, updates, and exclusive offers!
                    </p>
                    <form action="#">
                        <input type="text" placeholder="discord.gg/saqr" disabled>
                        <button type="submit">Join</button>
                    </form>
                    <div class="icons">
                        <i class="fa-brands fa-cc-visa"></i>
                        <i class="fa-brands fa-cc-mastercard"></i>
                        <i class="fa-brands fa-paypal"></i>
                        <i class="fa-brands fa-cc-apple-pay"></i>
                        <i class="fa-brands fa-google-pay"></i>
                    </div>
                </div>
            </div>
        </section>
    </body>

</html>