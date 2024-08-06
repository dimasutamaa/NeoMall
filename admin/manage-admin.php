<?php
include("../config.php");

session_start();

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
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

    <div class="container mt-5">
        <div>
            <a class="btn btn-primary mb-4" href="/NeoMall/admin/register-admin.php">Add Admin</a>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <a href="#">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="../assets/images/user-icon.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px" />
                            <h5 class="my-3">John Smith</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-12">
                <a href="#">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="../assets/images/user-icon.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px" />
                            <h5 class="my-3">John Smith</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-12">
                <a href="#">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="../assets/images/user-icon.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px" />
                            <h5 class="my-3">John Smith</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-12">
                <a href="#">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="../assets/images/user-icon.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px" />
                            <h5 class="my-3">John Smith</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-12">
                <a href="#">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src="../assets/images/user-icon.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px" />
                            <h5 class="my-3">John Smith</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>