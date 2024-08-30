<?php
include("../config.php");
require("../functions/partner.php");

session_start();

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "admin") {
    header("location: /NeoMall/admin/index.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $data = getOrderDetail($id);
    $order = $data['order'];

    if($order['partner_id'] != $_SESSION['id']){
        $_SESSION['alert'] = flash('Ouch!', 'You do not have permission to access the page.', 'warning');
        header("location: /NeoMall/brand-partner/index.php");
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        update_status($_POST, $id);
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
    <title>Brand Partner | NeoMall</title>
</head>

<body style="background-color: #eee;">
    <?php include("../layout/header.php") ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <?php
                $prevPage = 'http://localhost/NeoMall/brand-partner/completed-orders.php';
                if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == $prevPage) {
                    echo '<li class="breadcrumb-item"><a href="completed-orders.php">Completed Orders</a></li>';
                } ?>
                <li class="breadcrumb-item active" aria-current="page">Order Details</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-9 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="container mb-3 mt-2">
                            <div class="row d-flex align-items-baseline">
                                <div class="col-xl-9">
                                    <p style="font-size: 20px;"><strong>Order ID: #<?= $order['order_id'] ?></strong></p>
                                </div>
                                <hr>
                            </div>

                            <div class="row">
                                <div class="col-xl-8">
                                    <ul class="list-unstyled">
                                        <li class="text-muted"><span style="color:#5d9fc5 ;"><?= $order['first_name'] . ' ' . $order['last_name'] ?></span></li>
                                        <li class="text-muted"><?= $order['address'] ?></li>
                                        <li class="text-muted"><i class="fas fa-phone"></i> <?= $order['phone'] ?></li>
                                        <li class="text-muted"><i class="fas fa-envelope"></i> <?= $order['email'] ?></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row my-2 mx-1 justify-content-center">
                                <table class="table table-striped table-bordered">
                                    <thead style="background-color:#84B0CA ;" class="text-white">
                                        <tr>
                                            <th scope="col">Product ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Size</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">#<?= $order['product_id'] ?></th>
                                            <td><?= $order['name'] ?></td>
                                            <td><?= $order['size'] ?></td>
                                            <td><?= $order['quantity'] ?></td>
                                            <td>Rp<?= $order['price'] ?></td>
                                            <td>Rp<?= $order['total'] ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-xl-8">
                                    <?php $additionalInfo = $order['additional_info'] ? $order['additional_info'] : 'No additional informations' ?>
                                    <p class="ms-3"><?= $additionalInfo ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id ?>" method="POST">
                                <?php $isCompleted = ($order['status'] == 'completed') ? 'disabled' : '' ?>
                                <div class="col">
                                    <p style="font-size: 20px;">Order Status</p>
                                    <select class="form-select border border-secondary" <?= $isCompleted ?> name="status" id="status">
                                        <option value="new" <?= ($order['status'] == 'new') ? 'selected' : '' ?>>New</option>
                                        <option value="inProgress" <?= ($order['status'] == 'inProgress') ? 'selected' : '' ?>>In Progress</option>
                                        <option value="completed" <?= ($order['status'] == 'completed') ? 'selected' : '' ?>>Completed</option>
                                    </select>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary text-uppercase" <?= $isCompleted ?>>Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>