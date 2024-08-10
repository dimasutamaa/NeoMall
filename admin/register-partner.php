<?php
include("../config.php");
require("../functions.php");

session_start();

$username = $email = $phone = $logo = "";
$usernameErr = $emailErr = $phoneErr = $logoErr = "";

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (empty($_POST["username"])) {
            $usernameErr = "Name is required";
        } else {
            $username = $_POST["username"];

            if (strlen($username) < 5) {
                $usernameErr = "Name must have at least five characters";
            }
        }

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = $_POST["email"];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($_POST["phone"])) {
            $phoneErr = "Phone is required";
        } else {
            $phone = $_POST["phone"];

            if (!filter_var($phone, FILTER_VALIDATE_INT)) {
                $phoneErr = "Phone must be number only";
            }
        }

        if (empty($_FILES["fileToUpload"]["name"])) {
            $logoErr = "Logo is required";
        } else {
            $data = upload_logo();

            if ($data["uploadOk"] == 1) {
                $logo = $data["filePath"];
            } else {
                $logoErr = $data["uploadErr"];
            }
        }

        if (empty($usernameErr) && empty($emailErr) && empty($phoneErr) && empty($logoErr)) {
            $password = random_password();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO partners (username, email, phone, logo, password, role)
                        VALUES ('$username', '$email', '$phone', '$logo', '$hashed_password', 'partner')";

            if ($conn->query($query)) {
                echo '<script>
                            alert("Registration Success!\n\nPassword: '; echo $password;
                echo '\n\nPassword is generated by system.\nPlease instruct the partner to change the password right away.");
                            window.location.href = "/NeoMall/admin/index.php";
                        </script>';
            } else {
                echo "Data Failed to Save!";
            }
        }
    } catch (mysqli_sql_exception) {
        $usernameErr = "Name has been used";
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

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" enctype="multipart/form-data">
        <div class="container container-sm mt-5 bg-white p-5 rounded-6" style="width: 880px;">
            <div class="mb-2">
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Partner Name</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" id="username" name="username" class="form-control" value="<?php echo $username ?>" />
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
                            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $phone ?>" />
                        </div>
                        <div id="phoneErr" class="form-text text-danger"><?php echo $phoneErr ?></div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-2 d-flex align-items-center">
                        <p class="mb-0 p-0">Logo</p>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-md-10">
                        <input class="form-control form-control-lg" id="fileToUpload" name="fileToUpload" type="file" />
                        <div id="logoErr" class="form-text text-danger"><?php echo $logoErr ?></div>
                    </div>
                </div>
                <a class="btn btn-primary" href="/NeoMall/admin/index.php">Cancel</a>
                <button type="submit" class="btn btn-primary" id="register" name="register">Add</button>
            </div>
        </div>
    </form>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>

</html>