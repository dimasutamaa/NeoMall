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

$data = getOrders();
$orders = $data['orders'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet" />
    <title>History | NeoMall</title>
    <base href="/NeoMall/">
</head>

<body style="background-color: #eee;">
    <?php include("../layout/header.php") ?>

    <div class="container mt-5">
        <div><?= getAlertMessage() ?></div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">History</li>
            </ol>
        </nav>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="p-3">My Orders</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive align-middle mb-0 bg-white">
                            <thead class="bg-light">
                                <tr>
                                    <th>Orders</th>
                                    <th>Total</th>
                                    <th>Shipping</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order) { ?>
                                    <tr>
                                        <td>#<?= $order['id'] ?></td>
                                        <td>Rp<?= number_format($order['grand_total']) ?></td>
                                        <td><?= $order['shipping_type'] ?></td>
                                        <td><?= date_format(date_create($order['created_at']), 'd M Y') ?></td>
                                        <td><a href="user/order-details.php?id=<?= $order['id'] ?>">Details</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>