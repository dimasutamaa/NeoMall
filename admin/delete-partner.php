<?php
include("../config.php");

session_start();

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

if ($_SESSION["role"] == "admin") {
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
}
