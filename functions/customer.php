<?php

function add_to_cart($data, $product_id, $customer_id)
{
    global $conn;
    $quantity = "";
    $quantityErr = $alert = "";

    if (empty($data["quantity"])) {
        $quantityErr = "Quantity is required!";
    } else {
        $quantity = $data["quantity"];

        if ($quantity < 0) {
            $quantityErr = "The quantity must be at least 1!";
        }
    }

    $size = $data["size"];

    if ($quantity > 0) {
        $product = mysqli_query($conn, "SELECT * FROM carts WHERE product_id = '$product_id' AND customer_id = '$customer_id'");

        if (mysqli_num_rows($product) < 1) {
            $query = "INSERT INTO carts (customer_id, product_id, size, quantity) VALUES ('$customer_id', '$product_id', '$size', '$quantity')";

            if ($conn->query($query)) {
                $alert = flash("Successfully!", "add the product to your cart.", "success");
            } else {
                $alert = flash("Failed!", "add the product to your cart.", "danger");
            }
        } else {
            $alert = flash("Ouch!", "the product is already in your cart.", "warning");
        }
    }

    return [
        'quantityErr' => $quantityErr,
        'alert' => $alert,
    ];
}

function change_password($data, $id)
{
    global $conn;

    $current_password = $new_password = $confirm_password = "";
    $currentPassErr = $newPasswordErr = $confirmPassErr = $alert = "";

    if (empty($data["current_password"])) {
        $currentPassErr = "Current Password is required";
    } else {
        $current_password = $data["current_password"];
    }

    if (empty($data["new_password"])) {
        $newPasswordErr = "New Password is required";
    } else {
        $new_password = $data["new_password"];
    }

    if (empty($data["confirm_password"])) {
        $confirmPassErr = "Confirm Password is required";
    } else {
        $confirm_password = $data["confirm_password"];

        if ($confirm_password != $new_password) {
            $confirmPassErr = "Confirm password does not match.";
        }
    }

    $query = mysqli_query($conn, "SELECT * FROM customers WHERE id = '$id'");
    $partner = mysqli_fetch_assoc($query);

    if (password_verify($current_password, $partner["password"])) {
        if (empty($currentPassErr) && empty($newPasswordErr) && empty($confirmPassErr)) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            $query = "UPDATE customers SET password = '$hashed_new_password' WHERE id = '$id'";

            if ($conn->query($query)) {
                $alert = flash("Successfully!", "Change your password.", "success");
            } else {
                $alert = flash("Failed!", "to change your password.", "danger");
            }
        }
    } else {
        $currentPassErr = "Invalid password";
    }

    return [
        'alert' => $alert,
        'current_password' => $current_password,
        'new_password' => $new_password,
        'confirm_password' => $confirm_password,
        'currentPassErr' => $currentPassErr,
        'newPasswordErr' => $newPasswordErr,
        'confirmPassErr' => $confirmPassErr
    ];
}

function set_address($data, $id)
{
    global $conn;

    $first_name = $last_name = $address = $email = $phone = $additional_information = "";
    $firstNameErr = $lastNameErr = $addressErr = $emailErr = $phoneErr = $alert = "";

    if (empty($data["first_name"])) {
        $firstNameErr = "Username is required";
    } else {
        $first_name = $data["first_name"];

        if (!preg_match("/^[a-zA-Z-' ]*$/", $first_name)) {
            $firstNameErr = "Only letters and white space allowed";
        }
    }

    if (isset($data["last_name"])) {
        $last_name = $data["last_name"];

        if (!preg_match("/^[a-zA-Z-' ]*$/", $last_name)) {
            $lastNameErr = "Only letters and white space allowed";
        }
    }

    if (empty($data["address"])) {
        $addressErr = "Address is required";
    } else {
        $address = $data["address"];
    }

    if (empty($data['email'])) {
        $emailErr = "Email is required.";
    } else {
        $email = $data['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($data["phone"])) {
        $phoneErr = "Phone is required";
    } else {
        $phone = $data["phone"];

        if (!filter_var($phone, FILTER_VALIDATE_INT)) {
            $phoneErr = "Phone must be number only";
        }
    }

    if (isset($data["additional_information"])) {
        $additional_information = $data["additional_information"];
    }

    if (empty($firstNameErr) && empty($lastNameErr) && empty($addressErr) && empty($emailErr) && empty($phoneErr)) {
        $customer = mysqli_query($conn, "SELECT * FROM customer_addresses WHERE id = '$id'");

        if (mysqli_num_rows($customer) > 0) {
            $query = "UPDATE customer_addresses SET first_name = '$first_name', last_name = '$last_name', 
                        address = '$address', email = '$email', phone = '$phone', additional_information = '$additional_information' 
                        WHERE customer_id = '$id'";

            if ($conn->query($query)) {
                $alert = flash("Successfully!", "Changed your address.", "success");
            } else {
                $alert = flash("Failed!", "to change your address.", "danger");
            }
        } else {
            $query = "INSERT INTO customer_addresses (customer_id, first_name, last_name, address, email, phone, additional_information)
                        VALUES ('$id', '$first_name', '$last_name', '$address', '$email', '$phone', '$additional_information')";

            if ($conn->query($query)) {
                $alert = flash("Successfully!", "Saved your address.", "success");
            } else {
                $alert = flash("Failed!", "to save your address.", "danger");
            }
        }
    }

    return [
        'alert' => $alert,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'address' => $address,
        'email' => $email,
        'phone' => $phone,
        'additional_information' => $additional_information,
        'firstNameErr' => $firstNameErr,
        'lastNameErr' => $lastNameErr,
        'addressErr' => $addressErr,
        'emailErr' => $emailErr,
        'phoneErr' => $phoneErr
    ];
}
