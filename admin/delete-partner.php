<?php
include("../config.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $query = mysqli_query($conn, "SELECT * FROM partners WHERE id = $id");
    $data = mysqli_fetch_assoc($query);

    unlink($data['logo']);

    $result = mysqli_query($conn, "DELETE FROM partners WHERE id = $id");

    if ($result) {
        header("location: /NeoMall/admin/index.php");
    } else {
        echo "Failed to delete";
    }
}
