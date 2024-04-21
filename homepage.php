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
        <div style="display: flex">
            <div class="search">

                <!-- -------------------
            SEARCH FORM
            ------------------- -->

                <form action="" method="get" style="display: flex">
                    <input type="text" name="search" id="search" placeholder="Search for Clubs">
                    <button type="submit"><ion-icon id="search-btn" name="search-outline"></ion-icon></button>
                </form>


            </div>

            <!-- -------------------
        CREATE CLUB
        ------------------- -->

            <div class="create">
                <form action="create.php">
                    <button type="submit">Create New Club</button>
                </form>
            </div>
        </div>
    </main>
    <section class="clubs">

        <!---------------------
        SEARCHES THE DATA BASE FOR THE SEARCH TERM FROM THE ABOVE FORM!!!!!!!!!!!!!!!!
        --------------------->
        <?php
        if (!isset($_GET['search']) || $_GET['search'] == '') {
            $data = $pdo->query("select * from clubs");
            $results = $data->fetchAll(PDO::FETCH_ASSOC);

            if ($results == NULL) {
                echo "<p style='padding: 0px 20px;'>No Clubs Found, Create one Now!</p><br>";
            }
            foreach ($results as $result) {

                $name = $result['name'];
                echo "<div class='club' onclick='window.location.href=`club.php?search={$name}`'>";
                echo "<a>Name: {$name}</a>";
                echo "<a>Genre: {$result['genre']}</a>";
                echo "<a>Description: {$result['description']}</a>";
                echo "</div>";
            }
        } else {
            $search = htmlspecialchars($_GET['search']);
            $data = $pdo->query("SELECT * FROM clubs WHERE name LIKE '%{$search}%';");
            $results = $data->fetchAll(PDO::FETCH_ASSOC);

            if ($results == NULL) {
                echo "<p style='padding: 0px 20px;'>No Clubs Found, Create one Now!</p><br>";
            }
            foreach ($results as $result) {

                $name = $result['name'];
                echo "<div class='club' onclick='window.location.href=`club.php?search={$name}`'>";
                echo "<a>Name: {$name}</a>";
                echo "<a>Genre: {$result['genre']}</a>";
                echo "<a>Description: {$result['description']}</a>";
                echo "</div>";
            }
        }
        ?>

    </section>
    <button class="org-btn" style="font-size: 1em; padding: 10px 20px; margin: 10px;"
        onclick="window.location.href='auth/logout.php'">
        Logout
    </button>
</body>

</html>