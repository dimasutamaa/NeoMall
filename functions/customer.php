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
                $affectedRows = mysqli_affected_rows($conn);
                if ($affectedRows > 0) {
                    $alert = flash("Successfully!", "add the product to your cart.", "success");
                }
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
        'affectedRows' => $affectedRows ?? 0
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
                $affectedRows = mysqli_affected_rows($conn);
                if ($affectedRows > 0) {
                    $alert = flash("Successfully!", "Changed your password.", "success");
                }
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
        'confirmPassErr' => $confirmPassErr,
        'affectedRows' => $affectedRows ?? 0
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
        $customer = mysqli_query($conn, "SELECT * FROM customer_addresses WHERE customer_id = '$id'");

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
        'phoneErr' => $phoneErr,
        'affectedRows' => mysqli_affected_rows($conn)
    ];
}

function delete_cart_item($id)
{
    $alert = "";

    global $conn;

    $query = mysqli_query($conn, "SELECT p.name FROM carts c JOIN products p ON p.id = c.product_id WHERE c.id = $id");
    $product_name = mysqli_fetch_column($query);

    $result = mysqli_query($conn, "DELETE FROM carts WHERE id = $id");

    if ($result) {
        $alert = flash("Successfully!", "Removed " . '<strong>' . $product_name . '</strong>' . " from your cart.", "success");
    } else {
        $alert = flash("Failed!", "to delete cart item.", "success");
    }

    return [
        'alert' => $alert,
        'affectedRows' => mysqli_affected_rows($conn)
    ];
}

function checkout($data, $cart)
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

    $customer_id = $_SESSION['id'];

    $shipping_id = $shipping_type = $shippingErr = "";
    $shipping_price = 0;

    $payment = $data['payment'];
    $sub_total = $cart['total'];
    $grand_total = 0;

    if (empty($data['shipping'])) {
        $shippingErr = "Please choose the shipping method";
    } else {
        $shipping_id = $data['shipping'];

        $query = mysqli_query($conn, "SELECT * FROM shippings WHERE id = $shipping_id");
        $result = mysqli_fetch_assoc($query);

        $shipping_type = $result['type'];
        $shipping_price = $result['price'];
    }

    $grand_total = $sub_total + $shipping_price;

    if (empty($firstNameErr) && empty($lastNameErr) && empty($addressErr) && empty($emailErr) && empty($phoneErr) && empty($shippingErr)) {
        $query = "INSERT INTO orders (customer_id, shipping_type, shipping_price, sub_total, grand_total, payment, first_name, last_name, address, email, phone, additional_info)
                    VALUES ('$customer_id', '$shipping_type', '$shipping_price', '$sub_total', '$grand_total', '$payment', '$first_name', '$last_name', '$address', '$email', '$phone', '$additional_information')";

        if ($conn->query($query)) {
            $affectedRows = mysqli_affected_rows($conn);
            if ($affectedRows > 0) {
                $query = mysqli_query($conn, "SELECT id FROM orders WHERE customer_id = $customer_id ORDER BY created_at DESC");
                $order_id = mysqli_fetch_column($query);

                $items = $cart['items'];

                foreach ($items as $item) {
                    $product_id = $item['product_id'];
                    $name = $item['name'];
                    $quantity = $item['quantity'];
                    $price = $item['price'];
                    $size = $item['size'];
                    $total = $price * $quantity;

                    $query = "INSERT INTO order_items (order_id, product_id, name, quantity, price, size, total, status) 
                            VALUES ('$order_id', '$product_id', '$name', '$quantity', '$price', '$size', '$total', 'new')";

                    mysqli_query($conn, $query);
                }

                mysqli_query($conn, "DELETE FROM carts WHERE customer_id = $customer_id");

                $alert = flash("Thank you!", "Your order has been placed.", "success");
            } else {
                $alert = flash("Failed!", "to process your order.", "danger");
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
        'phoneErr' => $phoneErr,
        'shippingErr' => $shippingErr,
        'affectedRows' => $affectedRows ?? 0
    ];
}

function getOrders()
{
    global $conn;

    $id = $_SESSION['id'];

    $query = "SELECT DISTINCT O.id, O.grand_total, O.shipping_type, O.created_at 
                FROM order_items OI JOIN orders O ON OI.order_id = O.id 
                WHERE O.customer_id = $id ORDER BY O.created_at DESC";
    $exec = mysqli_query($conn, $query);

    $orders = [];

    while ($row = mysqli_fetch_assoc($exec)) {
        $orders[] = $row;
    }

    return ['orders' => $orders];
}

function getOrderDetails($id)
{
    global $conn;

    $queryItems = "SELECT P.picture, OI.name, OI.size, OI.quantity, OI.total, OI.status
                    FROM order_items OI JOIN products P ON OI.product_id = P.id
                    WHERE OI.order_id = $id";

    $exec = mysqli_query($conn, $queryItems);

    $items = [];

    while ($row = mysqli_fetch_assoc($exec)) {
        $items[] = $row;
    }

    $queryOrder = mysqli_query($conn, "SELECT sub_total, shipping_price, grand_total, created_at FROM orders WHERE id = $id");
    $order = mysqli_fetch_assoc($queryOrder);

    return [
        'items' => $items,
        'order' => $order
    ];
}

function update_cart_item_quantity($itemId, $quantity)
{
    global $conn;

    $alert = "";

    $query = mysqli_query($conn, "SELECT P.name FROM carts C JOIN products P ON C.product_id = P.id WHERE C.id = $itemId");
    $product_name = mysqli_fetch_column($query);

    if ($quantity > 0) {
        $query = "UPDATE carts SET quantity = $quantity WHERE id = $itemId";

        if ($conn->query($query)) {
            $affectedRows = mysqli_affected_rows($conn);

            if ($affectedRows > 0) {
                $alert = flash("Successfully!", "Updated the quantity of " . '<strong>' . $product_name . '</strong>', "success");
            } else {
                $alert = flash("Failed!", "to update the quantity of " . '<strong>' . $product_name . '</strong>', "danger");
            }
        }
    } else {
        $query = "DELETE FROM carts WHERE id = $itemId";

        if ($conn->query($query)) {
            $affectedRows = mysqli_affected_rows($conn);
            $alert = flash("Successfully!", "Removed " . '<strong>' . $product_name . '</strong>' . " from your cart.", "success");
        }
    }

    return [
        'alert' => $alert,
        'affectedRows' => $affectedRows
    ];
}
