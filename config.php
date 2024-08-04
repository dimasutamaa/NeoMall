<?php

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_database = "neomall_online_shop";

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_database);

if (mysqli_connect_errno()) {
    echo "Failed to connect";
    die();
}
