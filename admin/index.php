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

    <div class="container mt-5" style="width: 800px;">
        <div class="d-flex justify-content-between align-items-start">
            <h3 class="mt-2">Brand Partners</h3>
            <a href="/NeoMall/admin/register-partner.php" class="btn btn-primary">Add Partner</a>
        </div>
        <?php
        $query = mysqli_query($conn, "SELECT * FROM partners");
        while ($data = mysqli_fetch_assoc($query)) { ?>
            <div class="bg-light rounded-3 shadow-sm py-3 px-1 mb-3 bg-body-tertiary rounded">
                <div class="row">
                    <div class="col-3">
                        <img src="<?= $data['logo'] ?>" alt="" height="150px" class="border-end border-secondary border-4 pe-2">
                    </div>
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="fs-4 my-5">
                                <?= $data['username'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>