<?php
include("config.php");
require("functions/general.php");

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
    <title>NeoMall</title>
    <base href="/NeoMall/">
</head>

<body style="background-color: #eee;">
    <?php include("layout/header.php") ?>

    <div class="container mt-4">
        <!-- Hero -->
        <section>
            <div class="p-5 text-center bg-image rounded-5" style="
                background-image: url('https://placehold.jp/30b1bb/ffffff/1295x500.png?text=Welcome!');
                height: 530px; ">
                <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="text-white">
                            <h1 class="mb-3">Shop Now</h1>
                            <h4 class="mb-3">Discover Your Perfect Match</h4>
                            <a data-mdb-ripple-init class="btn btn-outline-light btn-lg" href="shop/index.php" role="button">Go to Shop</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Hero -->

        <!-- Latest Product -->
        <div class="mt-5">
            <div class="text-dark">
                <a href="shop/index.php" class="text-primary float-end my-1" style="font-size: 18px;">View More &raquo;</a>
                <h2 class="mb-3">Latest Product</h2>
            </div>
            <div class="row mt-3">
                <?php getAllProducts(null, 8) ?>
            </div>
        </div>
        <!-- Latest Product -->
    </div>

    <?php include("layout/footer.php") ?>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>