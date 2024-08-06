<?php
include("../config.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $result = mysqli_query($conn, "DELETE FROM admins WHERE id = $id");

    if ($result) {
        header("location: /NeoMall/admin/manage-admin.php");
    } else {
        echo "Failed to delete";
    }
}
