<?php
include("../config.php");
require("../functions/admin.php");

session_start();

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

$results = [];

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $data = search($search);
    $results = $data['username'];
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
        <?php if ($results) { ?>
            <p>Search Results for: <?= htmlspecialchars($_GET['search']) ?></p>
            <div class="card">
                <div class="card-body">
                    <table class="table table-responsive align-middle mb-0 bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php foreach ($results as $account) { ?>
                            <tbody>
                                <tr>
                                    <td><?= $account['id'] ?></td>
                                    <td><?= $account['username'] ?></td>
                                    <td><?= $account['role'] ?></td>
                                    <td><a href="<?= $account['role'] == 'admin' ? 'admin' : 'partner' ?>-details.php?id=<?= $account["id"] ?>">Details</a></td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="mb-3">
                <h3>Brand Partners</h3>
                <a href="/NeoMall/admin/register-partner.php" class="btn btn-primary">Add Partner</a>
            </div>
            <div class="row">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM partners");
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <div class="col-lg-3 col-md-12">
                        <a href="partner-details.php?id=<?= $data["id"] ?>">
                            <div class="card mb-4">
                                <div class="card-body text-center">
                                    <img src="<?= $data['logo'] ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px">
                                    <h5 class="my-3"><?= $data['username'] ?></h5>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>