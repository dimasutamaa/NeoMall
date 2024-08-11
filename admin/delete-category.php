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

        $result = mysqli_query($conn, "DELETE FROM categories WHERE id = $id");

        if ($result) {
            header("location: /NeoMall/admin/manage-category.php");
        } else {
            echo "Failed to delete";
        }
    }
}