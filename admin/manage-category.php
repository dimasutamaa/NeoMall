<?php
include("../config.php");
require("../functions/admin.php");

session_start();

$category_name = $status = "";
$categoryErr = "";

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

$category_id = isset($_GET['id']) ? $_GET['id'] : '';

if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $query = mysqli_query($conn, "SELECT * FROM categories WHERE id = $category_id");
    $row = mysqli_fetch_assoc($query);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = edit_category($_POST, $category_id);

        $status = $data['status'];
        $category_name = $data['category_name'];
        $categoryErr = $data['categoryErr'];
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = add_category($_POST);

    $status = $data['status'];
    $category_name = $data['category_name'];
    $categoryErr = $data['categoryErr'];
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
    <title>Admin | NeoMall</title>
</head>

<body style="background-color: #eee;">
    <?php include("../layout/header.php") ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-4 mb-4">
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . checkAction($_GET) ?>" method="POST">
                    <div class="card">
                        <div class="card-header py-3 mb-3">
                            <h5 class="mb-0">Create Category</h5>
                        </div>
                        <div class="mx-3 mb-2">
                            <label for="category_name" class="form-label m-0">Name</label>
                            <span class="text-danger">*</span>
                            <?php $checkName = isset($row['name']) ? $row['name'] : $category_name ?>
                            <input type="text" class="form-control" id="category_name" name="category_name" value="<?= $checkName ?>">
                            <div id="categoryErr" class="form-text text-danger"><?= $categoryErr ?></div>
                        </div>
                        <div class="mx-3 mb-2">
                            <label for="status" class="form-label m-0">Show on Shop</label>
                            <?php $checkStatus = isset($row['status']) ? $row['status'] : $status ?>
                            <select class="form-select" name="status" id="status">
                                <option value="Yes" <?= $checkStatus == 'Yes' ? 'selected' : '' ?>>Yes</option>
                                <option value="No" <?= $checkStatus == 'No' ? 'selected' : '' ?>>No</option>
                            </select>
                        </div>
                        <div class="m-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card mb-4">
                    <div class="card-header py-3">
                        <h5 class="mb-0">Categories</h5>
                    </div>
                    <div class="card-body">
                        <table class="table mb-4">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="pe-5">Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM categories");
                                while ($category = mysqli_fetch_assoc($query)) { ?>
                                    <tr>
                                        <th scope="row"><?= $category['id'] ?></th>
                                        <td class="pe-5"><?= $category['name'] ?></td>
                                        <td>
                                            <a href="manage-category.php?action=edit&id=<?= $category['id'] ?>" id="edit">
                                                <i class="ms-1 me-2 fa-solid fa-pen-to-square fa-lg" style="color: #2cdd61;"></i>
                                            </a>
                                            <a onclick="if (confirm('Are you sure want to delete this category?')) {
                                                window.location.href='delete-category.php?id=<?= $category['id'] ?>' }" id="delete">
                                                <i class="fa-solid fa-lg fa-trash" style="color: #ff0000;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>