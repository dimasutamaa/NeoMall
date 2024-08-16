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
        <div class="row mt-3">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC LIMIT 8");
            while ($product = mysqli_fetch_assoc($query)) { ?>
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
                                <a href="shop/brands.php?id=<?= $product["partner_id"] ?>" class="text-reset"><?= getBrandPartnerById($product["partner_id"]) ?></a>
                                <span> | </span>
                                <a href="shop/categories.php?id=<?= $product["category_id"] ?>" class="text-reset"><?= getCategoryById($product["category_id"]) ?></a>
                            </p>
                            <h6 class="mb-3">Rp<?= $product["price"] ?></h6>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include("../layout/footer.php") ?>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>