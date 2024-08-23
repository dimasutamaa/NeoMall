<?php
include("../config.php");
require("../functions/partner.php");

session_start();

$logo = $current_password = $new_password = $confirm_password = "";
$logoErr = $currentPassErr = $newPasswordErr = $confirmPassErr = "";

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
    if (isset($_POST["update"])) {
        $data = change_logo($_FILES, $partner_id, $partner);

        $logo = $data['logo'];
        $logoErr = $data['logoErr'];
    }

    if (isset($_POST["change_password"])) {
        $data = change_password($_POST, $partner_id);

        $current_password = $data['current_password'];
        $new_password = $data['new_password'];
        $confirm_password = $data['confirm_password'];

        $currentPassErr = $data['currentPassErr'];
        $newPasswordErr = $data['newPasswordErr'];
        $confirmPassErr = $data['confirmPassErr'];

        if (!empty($currentPassErr) || !empty($newPasswordErr) || !empty($confirmPassErr)) {
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    var myModal = new bootstrap.Modal(document.getElementById("changePasswordModal"), {
                        backdrop: "static"
                    });
                    myModal.show();
                });
            </script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                <button type="button" class="btn btn-warning float-end" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    Change Password
                </button>
                <button type="submit" class="btn btn-primary" id="update" name="update">Update</button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="changePasswordModalLabel">Change Password</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <span class="text-danger">*</span>
                            <input type="password" class="form-control" id="current_password" name="current_password" value="<?= $current_password ?>">
                            <div id="currentPassErr" class="form-text text-danger"><?= $currentPassErr ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <span class="text-danger">*</span>
                            <input type="password" class="form-control" id="new_password" name="new_password" value="<?= $new_password ?>">
                            <div id="newPasswordErr" class="form-text text-danger"><?= $newPasswordErr ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <span class="text-danger">*</span>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            <div id="confirmPassErr" class="form-text text-danger"><?= $confirmPassErr ?></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="change_password" name="change_password" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>