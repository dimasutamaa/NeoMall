<?php

function login($data)
{
    global $conn;

    $username = $password =  "";
    $usernameErr = $passwordErr =  "";

    if (empty($data['username'])) {
        $usernameErr = "Username is required.";
    } else {
        $username = mysqli_real_escape_string($conn, $data['username']);
    }

    if (empty($data['password'])) {
        $passwordErr = "Password is required.";
    } else {
        $password = mysqli_real_escape_string($conn, $data['password']);
    }

    if (empty($usernameErr) && empty($passwordErr)) {
        $admin_result = mysqli_query($conn, "SELECT * FROM admins WHERE username = '$username'");
        $partner_result = mysqli_query($conn, "SELECT * FROM partners WHERE username = '$username'");
        $customer_result = mysqli_query($conn, "SELECT * FROM customers WHERE username = '$username'");

        try {
            if ($admin_result->num_rows > 0) {
                $result = mysqli_fetch_assoc($admin_result);

                if (password_verify($password, $result['password'])) {
                    $_SESSION["id"] = $result["id"];
                    $_SESSION["username"] = $result["username"];
                    $_SESSION["email"] = $result["email"];
                    $_SESSION["role"] = $result["role"];
                    $_SESSION["isLogin"] = true;

                    header("location: /NeoMall/admin/index.php");
                } else {
                    $passwordErr = "Invalid password.";
                }
            }

            if ($partner_result->num_rows > 0) {
                $result = mysqli_fetch_assoc($partner_result);

                if (password_verify($password, $result['password'])) {
                    $_SESSION["id"] = $result["id"];
                    $_SESSION["username"] = $result["username"];
                    $_SESSION["email"] = $result["email"];
                    $_SESSION["phone"] = $result["phone"];
                    $_SESSION["logo"] = $result["logo"];
                    $_SESSION["role"] = $result["role"];
                    $_SESSION["isLogin"] = true;

                    header("location: /NeoMall/brand-partner/index.php");
                } else {
                    $passwordErr = "Invalid password.";
                }
            }

            if ($customer_result->num_rows > 0) {
                $result = mysqli_fetch_assoc($customer_result);

                if (password_verify($password, $result['password'])) {
                    $_SESSION["id"] = $result["id"];
                    $_SESSION["username"] = $result["username"];
                    $_SESSION["email"] = $result["email"];
                    $_SESSION["role"] = $result["role"];
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

    return [
        'username' => $username,
        'password' => $password,
        'usernameErr' => $usernameErr,
        'passwordErr' => $passwordErr,
    ];
}

function register($data)
{
    global $conn;

    $username = $email = $password = $confirm = "";
    $usernameErr = $emailErr = $passwordErr = $confirmErr = "";

    try {
        if (empty($data['username'])) {
            $usernameErr = "Username is required.";
        } else {
            $username = mysqli_real_escape_string($conn, $data['username']);
        }

        if (empty($data['email'])) {
            $emailErr = "Email is required.";
        } else {
            $email = mysqli_real_escape_string($conn, $data['email']);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }

        if (empty($data['password'])) {
            $passwordErr = "Password is required.";
        } else {
            $password = mysqli_real_escape_string($conn, $data['password']);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        }

        if (empty($data['confirm_password'])) {
            $confirmErr = "Confirm password is required.";
        } else {
            $confirm = mysqli_real_escape_string($conn, $data['confirm_password']);

            if ($confirm != $password) {
                $confirmErr = "Confirm password does not match.";
            }
        }

        if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmErr)) {
            $query = "INSERT INTO customers(username, email, password, role) VALUES('$username', '$email', '$hashed_password', 'customer')";

            if ($conn->query($query)) {
                header("location: /NeoMall/account/login.php");
            } else {
                echo "Failed to register.";
            }
        }
    } catch (mysqli_sql_exception) {
        $usernameErr = "Username has been used";
    }

    return [
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'confirm' => $confirm,
        'usernameErr' => $usernameErr,
        'emailErr' => $emailErr,
        'passwordErr' => $passwordErr,
        'confirmErr' => $confirmErr,
    ];
}
