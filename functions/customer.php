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
