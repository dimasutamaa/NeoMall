<?php
include("../config.php");
require("../functions/partner.php");

session_start();

$name = $price = $description = $picture = $category = "";
$nameErr = $priceErr = $descriptionErr = $pictureErr = $categoryErr = "";

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "admin") {
    header("location: /NeoMall/admin/index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = add_product($_POST, $_FILES, $_SESSION["id"]);

    $name = $data['name'];
    $price = $data['price'];
    $description = $data['description'];
    $picture = $data['picture'];
    $category = $data['category'];

    $nameErr = $data['nameErr'];
    $priceErr = $data['priceErr'];
    $descriptionErr = $data['descriptionErr'];
    $pictureErr = $data['pictureErr'];
    $categoryErr = $data['categoryErr'];
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
    <title>Brand Partner | NeoMall</title>
</head>

<body style="background-color: #eee;">
    <?php include("../layout/header.php") ?>

    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data">
        <div class="container container-sm mt-5 bg-white p-5 rounded-6" style="width: 880px;">
            <div class="mb-2">
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Name</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="name" name="name" class="form-control" value="<?= $name ?>" />
                        </div>
                        <div id="nameErr" class="form-text text-danger"><?= $nameErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Price</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="price" name="price" class="form-control" value="<?= $price ?>" />
                        </div>
                        <div id="priceErr" class="form-text text-danger"><?= $priceErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Description</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="description" name="description" class="form-control" value="<?= $description ?>" />
                        </div>
                        <div id="descriptionErr" class="form-text text-danger"><?= $descriptionErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Category</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <select class="form-select" name="category" id="category" aria-label="Default select example">
                            <option value="">Choose Category</option>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM categories");
                            while ($category = mysqli_fetch_assoc($query)) { ?>
                                <option value="<?= $category["id"] ?>"><?= $category["name"] ?></option>
                            <?php } ?>
                        </select>
                        <div id="categoryErr" class="form-text text-danger"><?= $categoryErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Picture</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <input class="form-control form-control-lg" id="fileToUpload" name="fileToUpload" type="file" />
                        <div id="pictureErr" class="form-text text-danger"><?= $pictureErr ?></div>
                    </div>
                </div>
                <a class="btn btn-primary" href="/NeoMall/brand-partner/manage-product.php">Cancel</a>
                <button type="submit" class="btn btn-primary" id="add" name="add">Add</button>
            </div>
        </div>
    </form>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>