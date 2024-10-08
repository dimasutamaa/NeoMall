<?php
include("../config.php");
require("../functions/general.php");

session_start();

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "admin") {
    header("location: /NeoMall/admin/index.php");
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

    <div class="container mt-5">
        <div><?= getAlertMessage() ?></div>

        <div class="row d-flex justify-content-center">
            <div class="col col-md-9 col-lg-7 col-xl-6">
                <div class="card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img src="<?= $_SESSION["logo"] ?>" alt="logo" class="img-fluid" style="width: 180px; border-radius: 10px;">
                            </div>
                            <div class="flex-grow-1 ms-3 my-5">
                                <h5 class="mb-1"><?= $_SESSION["username"] ?></h5>
                                <div class="d-flex pt-1 mt-3">
                                    <a href="/NeoMall/brand-partner/add-product.php" class="btn btn-primary me-1 flex-grow-1">New Product</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <h3>Products</h3>
        </div>

        <div class="row mt-3">
            <?php
            $partner_id = $_SESSION['id'];
            $query = mysqli_query($conn, "SELECT * FROM products WHERE partner_id = '$partner_id'");
            while ($data = mysqli_fetch_assoc($query)) { ?>
                <div class="col-lg-3 col-md-12 mb-4">
                    <div class="card">
                        <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light" data-mdb-ripple-color="light">
                            <img src="<?= $data["picture"] ?>" style="width: 310px; height:350px" />
                            <a href="product-details.php?id=<?= $data["id"] ?>">
                                <div class="hover-overlay">
                                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                </div>
                            </a>
                        </div>
                        <div class="card-body">
                            <a href="product-details.php?id=<?= $data["id"] ?>" class="text-reset">
                                <h5 class="card-title mb-3"><?= $data["name"] ?></h5>
                            </a>
                            <p class="text-reset"><?= getCategoryById($data["category_id"]) ?></p>
                            <h6 class="mb-3">Rp<?= $data["price"] ?></h6>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>