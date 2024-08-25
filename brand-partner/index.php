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

$data = getCurrentOrders();
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
    <title>Brand Partner | NeoMall</title>
</head>

<body style="background-color: #eee;">
    <?php include("../layout/header.php") ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3 class="p-3">Current Order(s)</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive align-middle mb-0 bg-white">
                    <thead class="bg-light">
                        <tr>
                            <th>Order Id</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td>#<?= $order['order_id'] ?></td>
                                <td>
                                    <p class="fw-bold mb-1"><?= $order['first_name'] . ' ' . $order['last_name'] ?></p>
                                    <p class="text-muted mb-0"><?= $order['email'] ?></p>
                                </td>
                                <td><?= $order['name'] ?></td>
                                <td>
                                    <?php if ($order['status'] == 'new') { ?>
                                        <span class="badge badge-primary rounded-pill d-inline">New</span>
                                    <?php } else if ($order['status'] == 'completed') { ?>
                                        <span class="badge badge-success rounded-pill d-inline">Completed</span>
                                    <?php } else if ($order['status'] == 'inProgress') { ?>
                                        <span class="badge badge-warning rounded-pill d-inline">In Progress</span>
                                    <?php } ?>
                                </td>
                                <td><?= $order['created_at'] ?></td>
                                <td><a href="order-detail.php?id=<?= $order['id'] ?>">Details</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>