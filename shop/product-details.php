<?php
include("../config.php");
require("../functions/general.php");
require("../functions/customer.php");

session_start();

$quantityErr = "";

if ($_SESSION) {
    if ($_SESSION["role"] == "admin") {
        header("location: /NeoMall/admin/index.php");
    }

    if ($_SESSION["role"] == "partner") {
        header("location: /NeoMall/brand-partner/index.php");
    }
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id'");
    $product = mysqli_fetch_assoc($query);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_SESSION['id'])) {
            $customer_id = $_SESSION['id'];

            $data = add_to_cart($_POST, $product_id, $customer_id);

            $quantityErr = $data['quantityErr'];

            if ($data['affectedRows'] > 0) {
                $_SESSION['alert'] = $data['alert'];
                header("location: /NeoMall/shop/product-details.php?id=$product_id");
                exit();
            } else {
                $_SESSION['alert'] = $data['alert'];
            }
        } else {
            header("location: ../account/login.php");
        }
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
        <div><?= getAlertMessage() ?></div>
        <div class="py-5">
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $product_id ?>" method="POST">
                <div class="row gx-1">
                    <div class="col-lg-6">
                        <div class="mb-3 d-flex justify-content-center">
                            <img style="width: 560px; height: 630px; margin: auto;" class="rounded-4 fit" src="<?= str_replace('../', '', $product['picture']) ?>" />
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ps-lg-3">
                            <h4 class="title text-dark"><?= $product['name'] ?></h4>

                            <div class="mb-3">
                                <span class="h5">Rp<?= $product['price'] ?> </span>
                                <span class="text-muted">/per item</span>
                            </div>

                            <p><?= $product['description'] ?></p>

                            <div class="row">
                                <dt class="col-3">Category</dt>
                                <dd class="col-9"><?= getCategoryById($product['category_id']) ?></dd>

                                <dt class="col-3">Brand</dt>
                                <dd class="col-9"><?= getBrandPartnerById($product['partner_id']) ?></dd>
                            </div>

                            <hr />

                            <div class="row mb-4">
                                <div class="col-md-4 col-6">
                                    <label class="mb-2">Size</label>
                                    <select class="form-select border border-secondary" name="size" id="size" style="height: 35px;">
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-6">
                                    <label class="mb-2 d-block">Quantity</label>
                                    <div class="input-group quantity-selector" style="width: 100px;">
                                        <input type="number" name="quantity" id="quantity" class="form-control text-center border border-secondary py-3" min="1" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <span class="text-danger"><?= $quantityErr ?></span>
                            </div>

                            <button type="submit" class="btn btn-primary shadow-0"><i class="me-1 fa fa-shopping-basket"></i>Add to cart</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include("../layout/footer.php") ?>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>