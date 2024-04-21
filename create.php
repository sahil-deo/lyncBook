<?php

include ('db/database.php');
include ('inc/header.php');
include ('inc/navbar.php');
if (!isset($_SESSION['username']) || !isset($_SESSION['loggedin'])) {
    header('Location: Auth/login.php');
}

?>
<link rel="stylesheet" href="CSS/create-style.css">

<body>

    <div class="main">
        <div class="create">
            <p class="title">Create New Club</p>
            <form action="" method="post" class="form" id="form">
                <input type="text" name="clubname" id="clubname" placeholder="Enter club Name">
                <input type="text" name="clubgenre" id="clubgenre" placeholder="Enter club Genre (space separated)">
                <textarea name="clubdescription" id="clubdescription"
                    placeholder="Enter club description (max 500 characters)" form="form" maxlength="500"
                    rows="10"></textarea>
                <button type="submit">Create Club</button>
            </form>
        </div>
    </div>
</body>

</html>


<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit;
}


$name = $_POST['clubname'];
$genre = $_POST['clubgenre'];
$description = $_POST['clubdescription'];
$username = $_SESSION['username'];

$checkData = $pdo->query("select name from clubs where name LIKE '$name%';");
$checkResult = $checkData->fetchAll(PDO::FETCH_ASSOC);

if ($checkResult != NULL) {
    echo "<script>alert('club with name {$name} already exist');</script>";
}

$query = "insert into clubs (name, genre, users, description) values ('{$name}', '{$genre}', '{$username}', '{$description}');";
$stmt = $pdo->prepare($query);
$result = $stmt->execute();

echo $result;


?>