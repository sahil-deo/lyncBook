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

                <h1>Register</h1>
                <hr>
                <label for="username">Username</label>
                <input type="text" name="username" id="username">

                <label>
                    Password
                    <ion-icon class="eye" name="eye-off-outline" id="eye-close" onclick="ShowPassword()"></ion-icon>
                    <ion-icon class="eye" name="eye-outline" id="eye-open" onclick="HidePassword()"></ion-icon>
                </label>
                <input type="password" name="password" id="password">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" name="confirm-password" id="confirm-password">

                <input type="submit" value="Register">
                <a id="log-reg" href="login.php">Registered? Login in.</a>
            </form>
        </div>
    </div>

    <script src="../JS/form.js"></script>

</body>

</html>


<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $_SERVER['REQUEST_METHOD'] == 'GET';
    print_r($_SESSION);
    die;
}

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$confirm_password = htmlspecialchars($_POST['confirm-password']);

if ($username == '' || $password == '' || $password != $confirm_password) {
    print_r($_SESSION);
    die;
}


$data = $pdo->query("select * from users where username = '{$username}';");
$result = $data->FetchALL(PDO::FETCH_ASSOC);

if ($result != NULL) {
    echo "<script> alert ('user already exist') </script> ";
    print_r($_SESSION);

    die;
}

$passhash = password_hash($password, PASSWORD_DEFAULT);

$query = $pdo->prepare("insert into users (username, password) Values (?, ?);");
$query->execute([$username, $passhash]);


$_SESSION["username"] = $username;
$_SESSION["loggedin"] = true;

header("Location: ../homepage.php");

?>