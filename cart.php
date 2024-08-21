<?php
include("config.php");
require("functions/general.php");
require("functions/customer.php");

session_start();

if ($_SESSION) {
    if ($_SESSION["role"] == "admin") {
        header("location: /NeoMall/admin/index.php");
    }

    if ($_SESSION["role"] == "partner") {
        header("location: /NeoMall/brand-partner/index.php");
    }
}

$data = get_cart();

$items = $data['items'];
$total = $data['total'];

if (isset($_GET['id'])) {
    $data = delete_cart_item($_GET['id']);

    if ($data['affectedRows'] > 0) {
        $_SESSION['alert'] = $data['alert'];
        header("location: /NeoMall/cart.php");
        exit();
    } else {
        $_SESSION['alert'] = $data['alert'];
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
    <title>Cart | NeoMall</title>
    <base href="/NeoMall/">
</head>

<body style="background-color: #eee;">
    <?php include("layout/header.php") ?>

    <section class="h-100 h-custom">
        <div class="container py-5 h-100">
            <div><?= getAlertMessage() ?></div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-8">
                                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post"></form>
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h1 class="fw-bold mb-0">Shopping Cart</h1>
                                            <h6 class="mb-0 text-muted"><?= count($items) ?> items</h6>
                                        </div>
                                        <hr class="my-4">

                                        <?php
                                        if (!empty($items)) {
                                            foreach ($items as $item) { ?>
                                                <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                    <div class="col-md-2 col-lg-2 col-xl-2">
                                                        <img src="<?= str_replace('../', '', $item["picture"]) ?>"
                                                            class="rounded-3" height="170" width="130" alt="Picture">
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 col-xl-3">
                                                        <h6 class="text-muted"><?= getCategoryById($item['category_id']) ?></h6>
                                                        <h6 class="mb-0"><?= $item['name'] ?></h6>
                                                    </div>
                                                    <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2"
                                                            onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                            <i class="fas fa-minus"></i>
                                                        </button>

                                                        <input id="quantity" min="0" name="quantity" value="<?= $item['quantity'] ?>" type="number"
                                                            class="form-control form-control-sm" />

                                                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2"
                                                            onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                        <h6 class="mb-0">Rp<?= $item['price'] * $item['quantity'] ?></h6>
                                                    </div>
                                                    <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                        <a href="cart.php?id=<?= $item['id'] ?>" class="text-muted"><i class="fas fa-times"></i></a>
                                                    </div>
                                                </div>

                                                <hr class="my-4">
                                            <?php }
                                        } else { ?>
                                            <h2 class="m-5 p-5 text-center">Your cart is empty.</h2>
                                        <?php } ?>

                                        <div class="pt-5">
                                            <h6 class="mb-0">
                                                <a href="shop/index.php" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 bg-body-tertiary" style="border-radius: 15px;">
                                    <div class="p-5">
                                        <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                        <hr class="my-4">

                                        <?php
                                        foreach ($items as $item) { ?>
                                            <div class="d-flex justify-content-between mb-4 fw-medium" style="font-size: 19px;">
                                                <span><?= $item['name'] ?></span>
                                                <span><?= $item['quantity'] ?> x Rp<?= $item['price'] ?></span>
                                            </div>
                                        <?php } ?>

                                        <?php if (!empty($items)) { ?>
                                            <hr class="my-4">
                                        <?php } ?>

                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="text-uppercase">Total</h5>
                                            <h5>Rp<?= $total ?></h5>
                                        </div>

                                        <button type="submit" class="btn btn-dark btn-block btn-lg <?= (empty($items)) ? 'disabled' : '' ?>">Checkout</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include("layout/footer.php") ?>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>