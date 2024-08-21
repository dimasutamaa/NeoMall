<?php
include("../config.php");
require("../functions/admin.php");

session_start();

$type = $price = "";
$typeErr = $priceErr = "";

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

$shipping_id = isset($_GET['id']) ? $_GET['id'] : '';

if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $query = mysqli_query($conn, "SELECT * FROM shippings WHERE id = $shipping_id");
    $row = mysqli_fetch_assoc($query);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = edit_shipping($_POST, $shipping_id);

        $type = $data['type'];
        $price = $data['price'];

        $typeErr = $data['typeErr'];
        $priceErr = $data['priceErr'];
    }
} else if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $result = mysqli_query($conn, "DELETE FROM shippings WHERE id = $shipping_id");

    if ($result) {
        header("location: /NeoMall/admin/manage-shipping.php");
    } else {
        echo "Failed to delete";
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = add_shipping($_POST);

    $type = $data['type'];
    $price = $data['price'];

    $typeErr = $data['typeErr'];
    $priceErr = $data['priceErr'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet" />
    <title>Admin | NeoMall</title>
</head>

<body style="background-color: #eee;">
    <?php include("../layout/header.php") ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-4 mb-4">
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . checkAction($_GET) ?>" method="POST">
                    <div class="card">
                        <div class="card-header py-3 mb-3">
                            <h5 class="mb-0">Create Shipping</h5>
                        </div>
                        <div class="mx-3 mb-2">
                            <label for="type" class="form-label m-0">Type</label>
                            <span class="text-danger">*</span>
                            <?php $checkType = isset($row['type']) ? $row['type'] : $type ?>
                            <input type="text" class="form-control" id="type" name="type" value="<?= $checkType ?>">
                            <div id="typeErr" class="form-text text-danger"><?= $typeErr ?></div>
                        </div>
                        <div class="mx-3 mb-2">
                            <label for="price" class="form-label m-0">Price</label>
                            <span class="text-danger">*</span>
                            <?php $checkPrice = isset($row['price']) ? $row['price'] : $price ?>
                            <input type="text" class="form-control" id="price" name="price" value="<?= $checkPrice ?>">
                            <div id="priceErr" class="form-text text-danger"><?= $priceErr ?></div>
                        </div>
                        <div class="m-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Shippings</h5>
                    </div>
                    <div class="card-body">
                        <table class="table mb-4">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="pe-5">Type</th>
                                    <th scope="col" class="pe-5">Price</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM shippings");
                                while ($shipping = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <th scope="row"><?= $shipping['id'] ?></th>
                                        <td class="pe-5"><?= $shipping['type'] ?></td>
                                        <td class="pe-5">Rp<?= $shipping['price'] ?></td>
                                        <td>
                                            <a href="manage-shipping.php?action=edit&id=<?= $shipping['id'] ?>" id="edit">
                                                <i class="ms-1 me-2 fa-solid fa-pen-to-square fa-lg" style="color: #2cdd61;"></i>
                                            </a>
                                            <a onclick="if (confirm('Are you sure want to delete this shipping?')) {
                                                window.location.href='manage-shipping.php?action=delete&id=<?= $shipping['id'] ?>' }" id="delete">
                                                <i class="fa-solid fa-lg fa-trash" style="color: #ff0000;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>