<?php
include("../config.php");
require("../functions/admin.php");

session_start();

$username = $email = $phone = $gender = "";
$usernameErr = $emailErr = $phoneErr = $genderErr = "";

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = register_admin($_POST);

    $username = $data['username'];
    $email = $data['email'];
    $phone = $data['phone'];
    $gender = $data['gender'];

    $usernameErr = $data['usernameErr'];
    $emailErr = $data['emailErr'];
    $phoneErr = $data['phoneErr'];
    $genderErr = $data['genderErr'];
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

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
        <div class="container container-sm mt-5 bg-white p-5 rounded-6" style="width: 850px;">
            <div class="mb-2">
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Admin Name</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <div data-mdb-input-init class="form-outline">
                            <input type="username" id="username" name="username" class="form-control" value="<?php echo $username ?>" />
                        </div>
                        <div id="usernameErr" class="form-text text-danger"><?php echo $usernameErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Email</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <div data-mdb-input-init class="form-outline">
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $email ?>" />
                        </div>
                        <div id="emailErr" class="form-text text-danger"><?php echo $emailErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Phone</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <div data-mdb-input-init class="form-outline">
                            <input type="phone" id="phone" name="phone" class="form-control" value="<?php echo $phone ?>" />
                        </div>
                        <div id="phoneErr" class="form-text text-danger"><?php echo $phoneErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Gender</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gender" value="Male" <?php echo ($gender == "Male") ? "checked" : "" ?> />
                            <label class="form-check-label" for="gender">Male</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="gender" value="Female" <?php echo ($gender == "Female") ? "checked" : "" ?> />
                            <label class="form-check-label" for="gender">Female</label>
                        </div>
                        <div id="genderErr" class="form-text text-danger"><?php echo $genderErr ?></div>
                    </div>
                </div>
                <a class="btn btn-primary" href="/NeoMall/admin/manage-admin.php">Cancel</a>
                <button type="submit" class="btn btn-primary" id="register" name="register">Add</button>
            </div>
        </div>
    </form>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>