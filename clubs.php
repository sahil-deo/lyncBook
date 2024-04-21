<?php
include ('db/database.php');
include ('inc/header.php');
include ('inc/navbar.php');
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: Auth/login.php');
}

?>
<link rel="stylesheet" href="CSS/inside-style.css">

<body>

    <main class="main">
        <div class="search">
            <h2 style="color: white; text-align: center;">Your Clubs</h2>
        </div>

        <!---------------------
        SEARCHES THE DATA BASE FOR THE SEARCH TERM FROM THE ABOVE FORM!!!!!!!!!!!!!!!!
        --------------------->
        <?php

        $username = $_SESSION['username'];
        $clubData = $pdo->query("SELECT * from clubs where users LIKE '%{$username}%';");
        $clubResults = $clubData->fetchAll(PDO::FETCH_ASSOC);


        if ($clubResults == NULL) {
            echo "<p style='text-align: center; color: white;'>No Clubs Found, Join one Now!</p><br>";
        } else {
            foreach ($clubResults as $result) {

                $name = $result['name'];
                echo '<div class="clubs">';
                echo "<div class='club' onclick='window.location.href=`club.php?search={$name}`'>";
                echo "<a>Name: {$name}</a>";
                echo "<a>Genre: {$result['genre']}</a>";
                echo "<a>Description: {$result['description']}</a>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>

        <button class="org-btn"
            style="font-size: 1em; width: 100px; align-self: center; padding: 10px 20px; margin: 10px;"
            onclick="window.location.href='auth/logout.php'">
            Logout
        </button>
    </main>

</body>

</html>