<?php
include("../config.php");

session_start();

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "admin") {
    header("location: /NeoMall/admin/index.php");
}

if ($_SESSION["role"] == "partner") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
        $data = mysqli_fetch_assoc($query);

        unlink($data['picture']);

        $result = mysqli_query($conn, "DELETE FROM products WHERE id = $id");

        if ($result) {
            header("location: /NeoMall/brand-partner/manage-product.php");
        } else {
            echo "Failed to delete";
        }
    }
}
