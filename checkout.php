<?php
include("config.php");
require("functions/general.php");
require("functions/customer.php");

session_start();

$first_name = $last_name = $address = $email = $phone = $additional_information = "";
$firstNameErr = $lastNameErr = $addressErr = $emailErr = $phoneErr = $shippingErr = "";

if ($_SESSION["role"] == "admin") {
    header("location: /NeoMall/admin/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

if (!$_SESSION["isLogin"]) {
    header("location: /NeoMall/index.php");
}

$cart = get_cart();
$total = $cart['total'];

if (empty($cart['items'])) {
    header("location: /NeoMall/index.php");
}

$shipping_price = 0;
$grand_total = 0;

$customer_id = $_SESSION['id'];

$query = mysqli_query($conn, "SELECT * FROM customer_addresses WHERE customer_id = $customer_id");
$row = mysqli_fetch_assoc($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = checkout($_POST, $cart);

    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $address = $data['address'];
    $email = $data['email'];
    $phone = $data['phone'];
    $additional_information = $data['additional_information'];

    $firstNameErr = $data['firstNameErr'];
    $lastNameErr = $data['lastNameErr'];
    $addressErr = $data['addressErr'];
    $emailErr = $data['emailErr'];
    $phoneErr = $data['phoneErr'];
    $shippingErr = $data['shippingErr'];

    if ($data['affectedRows'] > 0) {
        $_SESSION['alert'] = $data['alert'];
        header("location: /NeoMall/user/history.php");
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
    <title>Checkout | NeoMall</title>
    <base href="/NeoMall/">
</head>

<body style="background-color: #eee;">
    <?php include("layout/header.php") ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="cart.php">Cart</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>

        <section>
            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                <div class="row">
                    <!-- Shipping Address -->
                    <div class="col-md-8 mb-4">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h4 class="mb-0">Shipping Address</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col">
                                        <div>
                                            <label for="first_name" class="form-label m-0">First name</label>
                                            <span class="text-danger">*</span>
                                            <?php $checkFirstName = (empty($row['first_name'])) ? $first_name : $row['first_name'] ?>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $checkFirstName ?>">
                                            <div id="firstNameErr" class="form-text text-danger"><?= $firstNameErr ?></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div>
                                            <label for="last_name" class="form-label m-0">Last name</label>
                                            <?php $checkLastName = (empty($row['last_name'])) ? $last_name : $row['last_name'] ?>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $checkLastName ?>">
                                            <div id="lastNameErr" class="form-text text-danger"><?= $lastNameErr ?></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="address" class="form-label m-0">Address</label>
                                    <span class="text-danger">*</span>
                                    <?php $checkAddress = (empty($row['address'])) ? $address : $row['address'] ?>
                                    <input type="text" class="form-control" id="address" name="address" value="<?= $checkAddress ?>">
                                    <div id="addressErr" class="form-text text-danger"><?= $addressErr ?></div>
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label m-0">Email</label>
                                    <span class="text-danger">*</span>
                                    <?php $checkEmail = (empty($row['email'])) ? $email : $row['email'] ?>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= $checkEmail ?>">
                                    <div id="emailErr" class="form-text text-danger"><?= $emailErr ?></div>
                                </div>

                                <div class="mb-4">
                                    <label for="phone" class="form-label m-0">Phone</label>
                                    <span class="text-danger">*</span>
                                    <?php $checkPhone = (empty($row['phone'])) ? $phone : $row['phone'] ?>
                                    <input type="text" class="form-control" id="phone" name="phone" value="<?= $checkPhone ?>">
                                    <div id="phoneErr" class="form-text text-danger"><?= $phoneErr ?></div>
                                </div>

                                <div class="mb-4">
                                    <label for="additional_information" class="form-label m-0">Additional information</label>
                                    <?php $checkAdditionalInfo = (empty($row['additional_information'])) ? $additional_information : $row['additional_information'] ?>
                                    <textarea class="form-control" id="additional_information" name="additional_information" rows="3"><?= $checkAdditionalInfo ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Shipping Address -->

                    <div class="col-md-4 mb-4">
                        <!-- Summary -->
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h4 class="mb-0">Summary</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <h5>Products</h5>
                                    <h5>Rp<?= $total ?></h5>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-3">Shipping</h5>
                                    <h5 class="shipping-price">Rp<?= $shipping_price ?></h5>
                                </div>

                                <div class="mb-4 pb-2">
                                    <select class="form-select border border-secondary" name="shipping" id="shipping" onchange="updateShippingPrice()">
                                        <option value="" selected disabled>Shipping Method</option>
                                        <?php
                                        $query = mysqli_query($conn, "SELECT * FROM shippings");
                                        while ($shipping = mysqli_fetch_assoc($query)) { ?>
                                            <option value="<?= $shipping['id'] ?>" data-id="<?= $shipping['id'] ?>" data-price="<?= $shipping['price'] ?>">
                                                <?= $shipping['type'] ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <div class="text-danger mt-2"><?= $shippingErr ?></div>
                                </div>

                                <hr class="my-4">

                                <div class="d-flex justify-content-between">
                                    <h5>Grand Total</h5>
                                    <h5 class="total-price">Rp<?= $grand_total ?></h5>
                                </div>
                            </div>
                        </div>
                        <!-- Summary -->

                        <!-- Payment -->
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0">Payment</h5>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment" id="qris" value="QRIS" checked />
                                    <label class="form-check-label" for="qris">QRIS</label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment" id="ovo" value="OVO" />
                                    <label class="form-check-label" for="ovo">OVO</label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment" id="gopay" value="GoPay" />
                                    <label class="form-check-label" for="gopay">GoPay</label>
                                </div>

                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="radio" name="payment" id="debit" value="Debit" />
                                    <label class="form-check-label" for="debit">Debit Card</label>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg btn-block">Pay Now</button>
                            </div>
                        </div>
                        <!-- Payment -->
                    </div>
                </div>
            </form>
        </section>
    </div>
    <?php include("layout/footer.php") ?>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

<script>
    function updateShippingPrice() {
        const shippingSelect = document.getElementById('shipping');
        const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
        const shippingPrice = selectedOption.getAttribute('data-price');

        document.querySelector('h5.shipping-price').textContent = 'Rp' + shippingPrice;

        const total = <?= $total ?>;
        document.querySelector('h5.total-price').textContent = 'Rp' + (parseInt(total) + parseInt(shippingPrice));
    }
</script>

</html>