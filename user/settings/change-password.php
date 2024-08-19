<?php
include("../../config.php");
require("../../functions/general.php");
require("../../functions/customer.php");

session_start();

$current_password = $new_password = $confirm_password = "";
$currentPassErr = $newPasswordErr = $confirmPassErr = "";

if ($_SESSION["role"] == "admin") {
    header("location: /NeoMall/admin/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

if (!$_SESSION["isLogin"]) {
    header("location: /NeoMall/index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $partner_id = $_SESSION['id'];

    $data = change_password($_POST, $partner_id);

    $current_password = $data['current_password'];
    $new_password = $data['new_password'];
    $confirm_password = $data['confirm_password'];

    $currentPassErr = $data['currentPassErr'];
    $newPasswordErr = $data['newPasswordErr'];
    $confirmPassErr = $data['confirmPassErr'];

    if ($data['affectedRows'] > 0) {
        $_SESSION['alert'] = $data['alert'];
        header("location: /NeoMall/user/settings/change-password.php");
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
    <title>NeoMall</title>
    <base href="/NeoMall/">
</head>

<body style="background-color: #eee;">
    <?php include("../../layout/header.php") ?>

    <div class="container mt-5">
        <div><?= getAlertMessage() ?></div>

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
                        <a class="list-group-item list-group-item-action" href="user/settings/address.php">Address</a>
                        <a class="list-group-item list-group-item-action active" href="user/settings/change-password.php">Change Password</a>
                        <a class="list-group-item list-group-item-action" href="logout.php" role="tab">Logout</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 mb-4">
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        <div class="card mb-4">
                            <div class="card-header py-3">
                                <h5 class="mb-0">Change Password</h5>
                            </div>
                            <div class="card-body">
                                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div>
                                                <label for="current_password" class="form-label m-0">Current Password</label>
                                                <span class="text-danger">*</span>
                                                <input type="password" class="form-control" id="current_password" name="current_password" value="<?= $current_password ?>">
                                                <div id="currentPassErr" class="form-text text-danger"><?= $currentPassErr ?></div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <label for="new_password" class="form-label m-0">New Password</label>
                                                <span class="text-danger">*</span>
                                                <input type="password" class="form-control" id="new_password" name="new_password" value="<?= $new_password ?>">
                                                <div id="newPasswordErr" class="form-text text-danger"><?= $newPasswordErr ?></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="confirm_password" class="form-label m-0">Confirm Password</label>
                                        <span class="text-danger">*</span>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                        <div id="confPasswordErr" class="form-text text-danger"><?= $confirmPassErr ?></div>
                                    </div>

                                    <div class="d-flex justify-content-center mb-2">
                                        <button type="submit" id="change" name="change" class="btn btn-primary">Change</button>
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