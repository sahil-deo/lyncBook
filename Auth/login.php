<?php
include ('../inc/header.php');
include ('../db/database.php');

if (isset($_SESSION['username']) && isset($_SESSION['loggedin'])) {
    header('Location: ../homepage.php');
    exit();
}

?>
<link rel="stylesheet" href="../CSS/auth-styles.css">

<body>
    <div class="navbar">
        <a href="../index.php"><ion-icon id='logo' name="book-outline"></ion-icon>Lync Books</a>
    </div>
    <div class="main">
        <div class="form" id="form">
            <form action="" method="post">

                <h1>Login</h1>
                <hr>
                <label for="username">
                    Username
                </label>
                <input type="text" name="username" id="username">

                <label>
                    Password
                    <ion-icon class="eye" name="eye-off-outline" id="eye-close" onclick="ShowPassword()"></ion-icon>
                    <ion-icon class="eye" name="eye-outline" id="eye-open" onclick="HidePassword()"></ion-icon>
                </label>
                <input type="password" name="password" id="password">

                <input type="submit" value="Login">
                <a id="log-reg" href="register.php">New User? Register.</a>
            </form>
        </div>
    </div>

    <script src="../JS/form.js"></script>

</body>

</html>


<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $_SERVER['REQUEST_METHOD'] == 'GET';
    die;
}

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

if ($username == '' || $password == '') {
    die;
}

$data = $pdo->query("select * from users where username = '{$username}';");
$result = $data->FetchALL(PDO::FETCH_ASSOC);

if ($result == NULL) {
    echo "<script> alert ('User does not exist') </script> ";
    die;
}
$passhash = password_hash($password, PASSWORD_BCRYPT);
if (!password_verify($password, $result[0]['password'])) {
    echo "<script> alert ('Incorrect Password') </script> ";
}
if (password_verify($password, $result[0]['password'])) {

    $_SESSION["username"] = $username;
    $_SESSION["loggedin"] = true;

    header("Location: ../homepage.php");
}

?>