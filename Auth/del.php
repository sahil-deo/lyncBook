<?php

include '../db/database.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $pdo->query("DELETE from post where id = {$_POST['postid']}");

    header("Location: {$_POST['returnuri']}");
}
