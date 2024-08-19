<?php
include("../../config.php");
require("../../functions/general.php");
require("../../functions/customer.php");

session_start();

$first_name = $last_name = $address = $email = $phone = $additional_information = "";
$firstNameErr = $lastNameErr = $addressErr = $emailErr = $phoneErr = $alert = "";

if ($_SESSION["role"] == "admin") {
    header("location: /NeoMall/admin/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

if (!$_SESSION["isLogin"]) {
    header("location: /NeoMall/index.php");
}

$customer_id = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT * FROM customer_addresses WHERE customer_id = '$customer_id'");
$customer_address = mysqli_fetch_assoc($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = set_address($_POST, $customer_id);

    $alert = $data['alert'];

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
    <?php include("../../layout/header.php") ?>

    <div class="container mt-5">
        <div><?= $alert ?></div>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Settings</li>
            </ol>
        </nav>

        <div class="row justify-content-center">
            <div class="col-lg-3 mb-4">
                <div class="card">
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" href="user/settings/address.php">Address</a>
                        <a class="list-group-item list-group-item-action" href="user/settings/change-password.php">Change Password</a>
                        <a class="list-group-item list-group-item-action" href="logout.php" role="tab">Logout</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 mb-4">
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0">Address</h5>
                            </div>
                            <div class="card-body">
                                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div>
                                                <label for="first_name" class="form-label m-0">First name</label>
                                                <span class="text-danger">*</span>
                                                <?php $checkFirstName = (empty($customer_address['first_name'])) ? $first_name : $customer_address['first_name'] ?>
                                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $checkFirstName ?>">
                                                <div id="firstNameErr" class="form-text text-danger"><?= $firstNameErr ?></div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <label for="last_name" class="form-label m-0">Last name</label>
                                                <?php $checkLastName = (empty($customer_address['last_name'])) ? $last_name : $customer_address['last_name'] ?>
                                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $checkLastName ?>">
                                                <div id="lastNameErr" class="form-text text-danger"><?= $lastNameErr ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="address" class="form-label m-0">Address</label>
                                        <span class="text-danger">*</span>
                                        <?php $checkAddress = (empty($customer_address['address'])) ? $address : $customer_address['address'] ?>
                                        <input type="text" class="form-control" id="address" name="address" value="<?= $checkAddress ?>">
                                        <div id="addressErr" class="form-text text-danger"><?= $addressErr ?></div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="form-label m-0">Email</label>
                                        <span class="text-danger">*</span>
                                        <?php $checkEmail = (empty($customer_address['email'])) ? $email : $customer_address['email'] ?>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= $checkEmail ?>">
                                        <div id="emailErr" class="form-text text-danger"><?= $emailErr ?></div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="phone" class="form-label m-0">Phone</label>
                                        <span class="text-danger">*</span>
                                        <?php $checkPhone = (empty($customer_address['phone'])) ? $phone : $customer_address['phone'] ?>
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $checkPhone ?>">
                                        <div id="phoneErr" class="form-text text-danger"><?= $phoneErr ?></div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="additional_information" class="form-label m-0">Additional information</label>
                                        <?php $checkAdditionalInfo = (empty($customer_address['additional_information'])) ? $additional_information : $customer_address['additional_information'] ?>
                                        <textarea class="form-control" id="additional_information" name="additional_information" rows="3"><?= $checkAdditionalInfo ?></textarea>
                                    </div>

                                    <div class="d-flex justify-content-center mb-2">
                                        <button class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>