<?php

include ('db/database.php');
include ('inc/header.php');
include ('inc/navbar.php');
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: Auth/login.php');
}


$username = $_SESSION['username'];
$data = $pdo->query("SELECT * from users where username = '{$username}'");
$result = $data->fetchAll(PDO::FETCH_ASSOC);

$book = $result[0]['book'];

?>
<link rel="stylesheet" href="CSS/profile-style.css">

<body>


    <div class="main">
        <a class="title">Hello <?php echo $_SESSION['username'] ?></a>
        <a class="text">What are you reading nowadays? </a>
        <form action="" method="post">
            <input type="text" name="book" id="book" value="<?php echo $book; ?>">
            <button class="org-btn" name="booksavebtn" type="submit">Save</button>
        </form>

        <div class="change">
            <a class="text" style="padding: 20px;">Change Banner</a><br>

            <form action="" method="post" class="form">
                <div>
                    <label for="bg1"><img
                            src="https://t4.ftcdn.net/jpg/03/92/25/09/360_F_392250914_2Od8jNRBPgpMu8W29vCh4hiu5EUXbgGU.jpg">
                    </label>
                    <input type="radio" name="bg" id="bg1"
                        value="https://t4.ftcdn.net/jpg/03/92/25/09/360_F_392250914_2Od8jNRBPgpMu8W29vCh4hiu5EUXbgGU.jpg">
                </div>
                <div>
                    <label for="bg2">
                        <img src="https://brianlagunas.com/wp-content/uploads/2013/05/cool-bg.jpg">
                    </label>
                    <input type="radio" name="bg" id="bg2"
                        value="https://brianlagunas.com/wp-content/uploads/2013/05/cool-bg.jpg">
                </div>
                <div>
                    <label for="bg3">
                        <img
                            src="https://images.ctfassets.net/isq5xwjfoz2m/1Jt7uHVInb9cS8enDicXmw/5ca3d07fe514cda0abcef91de2206ac6/AdobeStock_592604320__1_.png">
                    </label>
                    <input type="radio" name="bg" id="bg3"
                        value="https://images.ctfassets.net/isq5xwjfoz2m/1Jt7uHVInb9cS8enDicXmw/5ca3d07fe514cda0abcef91de2206ac6/AdobeStock_592604320__1_.png">
                </div>
                <div style="padding: 20px;  justify-content: center;">
                    <button style="margin:0px; width: 80px;" class="org-btn" name="bgsavebtn" type="submit">
                        Save</button>
                </div>
            </form>
        </div>
        <button class="org-btn" style="width: 100px; font-size: 1em; padding: 10px 20px; margin: 10px;"
            onclick="window.location.href='auth/logout.php'">
            Logout
        </button>
    </div>



</body>

</html>

<?php

//Getting the current reading book from the user
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['booksavebtn'])) {
        $book = $_POST['book'];
        $pdo->query("UPDATE `users` set `book` = '{$book}' where `username` = '{$username}' ");
        header('Location: profile.php');
    }

    if (isset($_POST['bgsavebtn'])) {
        $bg = $_POST['bg'];
        $pdo->query("UPDATE `users` SET `bg` = '{$bg}' where `username` = '{$username}'");
        header('Location: profile.php');
    }



}


?>