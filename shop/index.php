<?php
include("../config.php");
require("../functions/general.php");

session_start();

if ($_SESSION) {
    if ($_SESSION["role"] == "admin") {
        header("location: /NeoMall/admin/index.php");
    }

    if ($_SESSION["role"] == "partner") {
        header("location: /NeoMall/brand-partner/index.php");
    }
}

$data = getAllCategories();
$categories = $data['categories'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet" />
    <title>Shop | NeoMall</title>
    <base href="/NeoMall/">
</head>

<body style="background-color: #eee;">
    <?php include("../layout/header.php") ?>

    <div class="container mt-5">
        <div class="mb-3">
            <h2 class="text-dark text-center">Our Products</h2>
        </div>
        <!-- Pills navs -->
        <ul class="nav nav-pills mb-3 mx-auto justify-content-center" role="tablist">
            <li class="nav-item" role="presentation">
                <button data-mdb-pill-init class="nav-link active" id="tab-all" type="button" href="#all" role="tab" aria-controls="all" aria-selected="true">All</button>
            </li>
            <?php foreach ($categories as $category) { ?>
                <li class="nav-item" role="presentation">
                    <button data-mdb-pill-init class="nav-link" id="tab-<?= $category['name'] ?>"
                        type="button" href="#<?= $category['name'] ?>" role="tab" aria-controls="<?= $category['name'] ?>"
                        aria-selected="false"><?= $category['name'] ?></button>
                </li>
            <?php } ?>
        </ul>
        <!-- Pills navs -->

        <!-- Pills content -->
        <div class="tab-content">
            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="tab-all">
                <div class="row mt-3">
                    <?php getAllProducts() ?>
                </div>
            </div>
            <?php foreach ($categories as $category) { ?>
                <div class="tab-pane fade" id="<?= $category['name'] ?>" role="tabpanel" aria-labelledby="tab-<?= $category['name'] ?>">
                    <div class="row mt-3">
                        <?php getAllProducts($category['id']) ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- Pills content -->
    </div>

    <?php include("../layout/footer.php") ?>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>