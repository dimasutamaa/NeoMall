<?php
include("../config.php");

session_start();

$username = $password =  "";
$usernameErr = $passwordErr =  "";

if (isset($_SESSION["isLogin"])) {
    header("location: /NeoMall/index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['username'])) {
        $usernameErr = "Username is required.";
    } else {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
    }

    if (empty($_POST['password'])) {
        $passwordErr = "Password is required.";
    } else {
        $password = mysqli_real_escape_string($conn, $_POST['password']);
    }

    if (empty($usernameErr) && empty($passwordErr)) {
        $admin_result = mysqli_query($conn, "SELECT * FROM admins WHERE username = '$username'");
        $partner_result = mysqli_query($conn, "SELECT * FROM partners WHERE username = '$username'");
        $customer_result = mysqli_query($conn, "SELECT * FROM customers WHERE username = '$username'");

        try {
            if ($admin_result->num_rows > 0) {
                $data = mysqli_fetch_assoc($admin_result);

                if (password_verify($password, $data['password'])) {
                    $_SESSION["id"] = $data["id"];
                    $_SESSION["username"] = $data["username"];
                    $_SESSION["email"] = $data["email"];
                    $_SESSION["role"] = $data["role"];
                    $_SESSION["isLogin"] = true;

                    header("location: /NeoMall/admin/index.php");
                } else {
                    $passwordErr = "Invalid password.";
                }
            }

            if ($partner_result->num_rows > 0) {
                $data = mysqli_fetch_assoc($partner_result);

                if (password_verify($password, $data['password'])) {
                    $_SESSION["id"] = $data["id"];
                    $_SESSION["username"] = $data["username"];
                    $_SESSION["email"] = $data["email"];
                    $_SESSION["role"] = $data["role"];
                    $_SESSION["isLogin"] = true;

                    header("location: /NeoMall/brand-partner/index.php");
                } else {
                    $passwordErr = "Invalid password.";
                }
            }

            if ($customer_result->num_rows > 0) {
                $data = mysqli_fetch_assoc($customer_result);

                if (password_verify($password, $data['password'])) {
                    $_SESSION["id"] = $data["id"];
                    $_SESSION["username"] = $data["username"];
                    $_SESSION["email"] = $data["email"];
                    $_SESSION["role"] = $data["role"];
                    $_SESSION["isLogin"] = true;

                    header("location: /NeoMall/index.php");
                } else {
                    $passwordErr = "Invalid password.";
                }
            }

            if ($admin_result->num_rows == 0 && $partner_result->num_rows == 0 && $customer_result->num_rows == 0) {
                $passwordErr = "Account is not available.";
            }
        } catch (mysqli_sql_exception) {
            $passwordErr = "An error occurred.";
        }
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
    <title>Login | NeoMall</title>
    <base href="/NeoMall/">
</head>

<body style="background-color: #eee;">
    <?php include("../layout/login_register_header.php") ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Login</h3>
                        <hr />
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <span class="text-danger">*</span>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $username ?>">
                                <div id="usernameErr" class="form-text text-danger"><?php echo $usernameErr ?></div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <span class="text-danger">*</span>
                                <input type="password" class="form-control" id="password" name="password">
                                <div id="passwordErr" class="form-text text-danger"><?php echo $passwordErr ?></div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Don't have an account? <a href="/NeoMall/account/register.php">Sign Up</a></label>
                            </div>
                            <button type="submit" id="login" name="login" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>