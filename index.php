<?php include_once ('inc/header.php');

if (isset($_SESSION['loggedin'])) {
    Header("Location: homepage.php");
}

?>



<link rel="stylesheet" href="CSS/auth-styles.css">




<body>
    <div class="navbar">
        <a><ion-icon id='logo' name="book-outline"></ion-icon>Lync Books</a>
        <button class="org-btn" onclick="window.location.href='Auth/login.php'">Login</button>
        <button class="org-btn" onclick="window.location.href='Auth/register.php'">Register</button>
    </div>
    <div class="main">
        <div class="hero">
            <div class="hero-text">
                <h1>Find your book community</h1>
                <h2>Dive into a world of clubs tailored to your interests. Create, join, and explore diverse communities
                    on
                    our platform. From book clubs to gaming groups, find your tribe and start connecting today!</h2>
                <button id="joinButton" onclick="window.location.href='Auth/register.php'">Join Now</button>
            </div>
            <div class=" hero-image">
                <img id="hero-image" src="Images/book-reader.png" alt="People Reading Books">
            </div>
        </div>

</body>

</html>