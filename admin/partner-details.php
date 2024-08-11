<?php
include("../config.php");
require("../functions/admin.php");

session_start();

$username = $email = $phone = $logo = "";
$usernameErr = $emailErr = $phoneErr = $logoErr = "";

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $result = mysqli_query($conn, "SELECT * FROM partners WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = update_partner($_POST, $id, $row, $_FILES);

        $username = $data['username'];
        $email = $data['email'];
        $phone = $data['phone'];
        $logo = $data['logo'];

        $usernameErr = $data['usernameErr'];
        $emailErr = $data['emailErr'];
        $phoneErr = $data['phoneErr'];
        $logoErr = $data['logoErr'];
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
    <title>Admin | NeoMall</title>
</head>

<body style="background-color: #eee;">
    <?php include("../layout/header.php") ?>

    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id ?>" method="POST" enctype="multipart/form-data">
        <div class="container container-sm mt-5 bg-white p-5 rounded-6" style="width: 880px;">
            <div class="mb-2">
                <div class="row mb-4">
                    <div class="col-3">
                        <img src="<?= $row['logo'] ?>" alt="" height="150px" class="border-end border-secondary border-4 pe-2">
                    </div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="fs-4 my-5">
                                <?= $row['username'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Partner Name</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="username" name="username" class="form-control" value="<?= $row['username'] ?>" />
                        </div>
                        <div id="usernameErr" class="form-text text-danger"><?= $usernameErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Email</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <div data-mdb-input-init class="form-outline">
                            <input type="email" id="email" name="email" class="form-control" value="<?= $row['email'] ?>" />
                        </div>
                        <div id="emailErr" class="form-text text-danger"><?= $emailErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Phone</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="phone" name="phone" class="form-control" value="<?= $row['phone'] ?>" />
                        </div>
                        <div id="phoneErr" class="form-text text-danger"><?= $phoneErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Logo</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <input class="form-control form-control-lg" id="fileToUpload" name="fileToUpload" type="file" />
                        <div id="logoErr" class="form-text text-danger"><?= $logoErr ?></div>

                        <?php if (!empty($row['logo'])): ?>
                            <div class="mt-2">
                                <p>Current Logo: <?= basename($row['logo']) ?></a></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <a class="btn btn-primary" href="/NeoMall/admin/index.php">Cancel</a>
                <a class="btn btn-danger float-end" onclick="if (confirm('Are you sure want to delete this partner?')) {
                    window.location.href='/NeoMall/admin/delete-partner.php?id=<?= $id ?>' }">Delete</a>
                <button type="submit" class="btn btn-primary" id="register" name="register">Update</button>
            </div>
        </div>
    </form>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>