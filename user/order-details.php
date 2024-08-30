<?php
include("../config.php");
require("../functions/general.php");
require("../functions/customer.php");

session_start();

if ($_SESSION["role"] == "admin") {
    header("location: /NeoMall/admin/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

if (!$_SESSION["isLogin"]) {
    header("location: /NeoMall/index.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $data = getOrderDetails($id);
    
    $items = $data['items'];
    $order = $data['order'];

    if($order['customer_id'] != $_SESSION['id']){
        $_SESSION['alert'] = flash('Ouch!', 'You do not have permission to access the page.', 'warning');
        header("location: /NeoMall/user/history.php");
        exit();
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
    <title>Details | NeoMall</title>
    <base href="/NeoMall/">
</head>

<body style="background-color: #eee;">
    <?php include("../layout/header.php") ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="user/history.php">History</a></li>
                <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
        </nav>
        <section class="mb-5">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-lg-12 col-xl-10">
                    <div class="card" style="border-radius: 10px;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <p class="lead fw-normal mb-0" style="color: #5d9fc5;">Receipt</p>
                            </div>
                            <?php foreach ($items as $item) { ?>
                                <div class="card shadow-0 border mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="<?= str_replace('../', '', $item["picture"]) ?>"
                                                    class="rounded-3" height="170" width="130" alt="Picture">
                                            </div>
                                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0"><?= $item['name'] ?></p>
                                            </div>
                                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0 small">Size: <?= $item['size'] ?></p>
                                            </div>
                                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0 small">Qty: <?= $item['quantity'] ?></p>
                                            </div>
                                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0 small">Rp<?= number_format($item['total']) ?></p>
                                            </div>
                                        </div>
                                        <hr class="mb-4" style="background-color: #e0e0e0; opacity: 1;">
                                        <div class="row d-flex align-items-center">
                                            <div class="col-md-2">
                                                <p class="text-muted mb-0 small">Item Status</p>
                                            </div>
                                            <div class="col-md-10">
                                                <?php if ($item['status'] == 'new') { ?>
                                                    <span class="badge badge-primary rounded-pill d-inline">Pending</span>
                                                <?php } else if ($item['status'] == 'completed') { ?>
                                                    <span class="badge badge-success rounded-pill d-inline">Completed</span>
                                                <?php } else if ($item['status'] == 'inProgress') { ?>
                                                    <span class="badge badge-warning rounded-pill d-inline">In Progress</span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="mb-2">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <p class="text-muted mb-0 fw-bold me-4">Subtotal</p>
                                    </div>
                                    <div class="col">
                                        <p>Rp<?= number_format($order['sub_total']) ?></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <p class="text-muted mb-0 fw-bold me-4">Shipping</p>
                                    </div>
                                    <div class="col">
                                        <p>Rp<?= number_format($order['shipping_price']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-0 px-4 py-5"
                            style="background-color: #5d9fc5; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                            <h5 class="d-flex align-items-center justify-content-start text-white mb-0">
                                Grand Total: <span class="h2 mb-0 ms-2">Rp<?= number_format($order['grand_total']) ?></span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>