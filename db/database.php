<?php
$db_server = "mysql:host=localhost; dbname=LyncBooks";
$db_user = "root";
$db_pass = "";


try {
    $pdo = new PDO($db_server, $db_user, $db_pass);
    $isconn = true;

} catch (Exception $e) {
    echo "Cannot Connect to the database due to an internal error: <br>";
    echo $e;
}


?>