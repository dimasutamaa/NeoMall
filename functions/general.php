<?php

function random_password()
{
    $random_int = rand(100, 999);
    $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    $random_str = substr(str_shuffle($str_result), 0, 5);

    $random_password = $random_str . $random_int;

    return $random_password;
}

function upload($path)
{
    $target_dir = "../assets/" . $path . "/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadErr = "";

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        $uploadErr = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $uploadErr = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $uploadErr = "Sorry, only JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    }

    $data = [
        "uploadErr" => $uploadErr,
        "uploadOk" => $uploadOk,
        "filePath" => $uploadOk ? $target_file : null
    ];

    return $data;
}

function getCategoryById($data)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT name FROM categories WHERE id = '$data'");
    $category = mysqli_fetch_column($query);

    return $category;
}

function getBrandPartnerById($data)
{
    global $conn;

    $query = mysqli_query($conn, "SELECT username FROM partners WHERE id = '$data'");
    $brand_partner = mysqli_fetch_column($query);

    return $brand_partner;
}

function flash($message, $action, $type)
{
    $alert = '<div class="alert alert-' . $type . ' alert-dismissible fade show border border-black" role="alert">
            <strong>' . $message . '</strong> ' . $action . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';

    return $alert;
}

function get_cart()
{
    global $conn;

    $items = [];
    $customer_id = $_SESSION['id'];

    $query = "SELECT c.id, c.quantity, p.id AS product_id, p.name, p.price, p.picture, p.category_id, c.size FROM carts c 
                JOIN customers cu ON c.customer_id = cu.id 
                JOIN products p ON p.id = c.product_id 
                WHERE c.customer_id = $customer_id";

    $cart = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($cart)) {
        $items[] = $row;
    }

    $total = 0;

    foreach ($items as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return [
        'items' => $items,
        'total' => $total
    ];
}

function getAlertMessage()
{
    $alert = "";

    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
    }

    return $alert;
}

function getAllProducts($category = null)
{
    global $conn;

    $checkCategory = $category ? 'WHERE category_id = ' . $category : '';

    $query = mysqli_query($conn, "SELECT * FROM products $checkCategory ORDER BY created_at DESC LIMIT 16");

    while ($product = mysqli_fetch_assoc($query)) {
        echo '<div class="col-lg-3 col-md-12 mb-4">
            <div class="card">
                <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light" data-mdb-ripple-color="light">
                    <img src="' . str_replace('../', '', $product["picture"]) . '" style="width: 310px; height:350px" />
                    <a href="shop/product-details.php?id=' . $product["id"] . '">
                        <div class="hover-overlay">
                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                        </div>
                    </a>
                </div>
                <div class="card-body">
                    <a href="shop/product-details.php?id=' . $product["id"] . '" class="text-reset">
                        <h5 class="card-title mb-3">' . $product["name"] . '</h5>
                    </a>
                    <p>
                        <a href="shop/brands.php?id=' . $product["partner_id"] . '" class="text-reset">' . getBrandPartnerById($product["partner_id"]) . '</a>
                        <span> | </span>
                        <a href="shop/categories.php?id=' . $product["category_id"] . '" class="text-reset">' . getCategoryById($product["category_id"]) . '</a>
                    </p>
                    <h6 class="mb-3">Rp' . $product["price"] . '</h6>
                </div>
            </div>
        </div>';
    }
}

function getAllCategories()
{
    global $conn;

    $query = mysqli_query($conn, "SELECT * FROM categories WHERE status = 'Yes' ORDER BY name ASC");
    $categories = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $categories[] = $row;
    }

    return ['categories' => $categories];
}
