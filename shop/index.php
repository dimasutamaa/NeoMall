<?php
include("../config.php");
require("../functions/general.php");
require("../functions/customer.php");

session_start();

if ($_SESSION) {
    if ($_SESSION["role"] == "admin") {
        header("location: /NeoMall/admin/index.php");
    }

    if ($_SESSION["role"] == "partner") {
        header("location: /NeoMall/brand-partner/index.php");
    }
}

$results = [];

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $data = search($search);
    $results = $data['products'];
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
        <?php if ($results) { ?>
            <p>Search Results for: <?= htmlspecialchars($_GET['search']) ?></p>
            <div class="row">
                <?php foreach ($results as $product) { ?>
                    <div class="col-lg-3 col-md-12 mb-4">
                        <div class="card">
                            <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light" data-mdb-ripple-color="light">
                                <img src="<?= str_replace('../', '', $product["picture"]) ?>" style="width: 310px; height:350px" />
                                <a href="shop/product-details.php?id=<?= $product["id"] ?>">
                                    <div class="hover-overlay">
                                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                    </div>
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="shop/product-details.php?id=<?= $product["id"] ?>" class="text-reset">
                                    <h5 class="card-title mb-3"><?= $product["name"] ?></h5>
                                </a>
                                <p>
                                    <span class="text-reset"><?= getBrandPartnerById($product["partner_id"]) ?></span>
                                    <span> | </span>
                                    <span class="text-reset"><?= $product["category_name"] ?></span>
                                </p>
                                <h6 class="mb-3">Rp<?= $product["price"] ?></h6>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
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
        <?php } ?>
    </div>

    <?php include("../layout/footer.php") ?>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>