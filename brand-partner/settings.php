<?php
include("../config.php");
require("../functions/partner.php");

session_start();

$logo = "";
$logoErr = "";

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "admin") {
    header("location: /NeoMall/admin/index.php");
}

$partner_id = $_SESSION["id"];
$query = mysqli_query($conn, "SELECT * FROM partners WHERE id = '$partner_id'");
$partner = mysqli_fetch_assoc($query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = settings($_FILES, $partner_id, $partner);

    $logo = $data['logo'];
    $logoErr = $data['logoErr'];
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

    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" enctype="multipart/form-data">
        <div class="container container-sm mt-5 bg-white p-5 rounded-6" style="width: 880px;">
            <div class="mb-2">
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Logo</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <?php if (!empty($partner['logo'])): ?>
                            <div class="mt-2">
                                <img src="<?= $partner['logo'] ?>" alt="Current Picture" width="150px" height="150px" class="border m-0">
                                <p>Current Logo: <?= basename($partner['logo']) ?></a></p>
                            </div>
                        <?php endif ?>

                        <input class="form-control form-control-lg" id="fileToUpload" name="fileToUpload" type="file" />
                        <div id="logoErr" class="form-text text-danger"><?= $logoErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Partner Name</p>
                    </div>
                    <div class="col-md-10">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="username" name="username" class="form-control" value="<?= $partner['username'] ?>" readonly />
                        </div>
                    </div>
                </div>
                <a class="btn btn-primary" href="/NeoMall/brand-partner/index.php">Cancel</a>
                <a class="btn btn-warning float-end" href="#">Change Password</a>
                <button type="submit" class="btn btn-primary" id="update" name="update">Update</button>
            </div>
        </div>
    </form>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>