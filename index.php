<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends-Board</title>
    <link rel="stylesheet" href="homepage.css?v=1">
    <script src="homepage.js"defer ></script>
</head>
<body>
    <header>
        <a class="logo" href="index.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="m640-480 80 80v80H520v240l-40 40-40-40v-240H240v-80l80-80v-280h-40v-80h400v80h-40v280Zm-286 80h252l-46-46v-314H400v314l-46 46Zm126 0Z"/></svg>Friends-Board</a>
        <nav>
            <ul class="navlinks">
                <li><a href="searchgroups/search_groups.php">Search Groups</a></li>
                <li><a href="yourgroups/yourgroups.php">Your Groups</a></li>
                <li><a href="account/account.php">Account</a></li>
            </ul>
        </nav>
        <?php if (isset($_SESSION['username'])): ?>
            <div class="account">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                    <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z"/>
                </svg>
                <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>
                <a href="login/logout.php"><button>Logout</button></a>
            </div>
        <?php endif; ?>
    </header>
<div class="frontpage">
    <div class="intro">
        <a class="intro-discover">Where plans meet people.</a><br>
        <a class="intro-meet">Make new friends,</a><br>
        <a class="intro-and">discover local events,</a>
        <a class="intro-or">and plan your next adventure—all in one place.</a>
    </div>
    <div class="links">
    <a href="searchgroups/search_groups.php">Search Groups</a>
    <a href="yourgroups/yourgroups.php">Your Groups</a>
    <a href="account/account.php">Account</a>
    </div>
    <img src="images/pexels-koolshooters-8974501.jpg" alt="https://www.pexels.com/" class="image">
</div>
</body>
</html>
