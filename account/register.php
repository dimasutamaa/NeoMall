<?php
include("../config.php");
require("../functions/account.php");

session_start();

$username = $email = $password = $confirm = "";
$usernameErr = $emailErr = $passwordErr = $confirmErr = "";

if (isset($_SESSION["isLogin"])) {
    header("location: /NeoMall/index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = register($_POST);

    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];
    $confirm = $data['confirm'];

    $usernameErr = $data['usernameErr'];
    $emailErr = $data['emailErr'];
    $passwordErr = $data['passwordErr'];
    $confirmErr = $data['confirmErr'];
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
    <title>Register | NeoMall</title>
    <base href="/NeoMall/">
</head>

<body style="background-color: #eee;">
    <?php include("../layout/login_register_header.php") ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Register</h3>
                        <hr />
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>">
                                <div id="usernameErr" class="form-text text-danger"><?php echo $usernameErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>">
                                <div id="emailErr" class="form-text text-danger"><?php echo $emailErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <span class="text-danger">*</span>
                                <input type="password" class="form-control" id="password" name="password" value="<?php echo $password ?>">
                                <div id="password" class="form-text text-danger"><?php echo $passwordErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <span class="text-danger">*</span>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?php echo $confirm ?>">
                                <div id="confPasswordErr" class="form-text text-danger"><?php echo $confirmErr ?></div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Already have an account? <a href="/NeoMall/account/login.php">Login</a></label>
                            </div>
                            <button type="submit" id="register" name="register" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>