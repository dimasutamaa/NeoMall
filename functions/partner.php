<?php
require("../functions/general.php");

function add_product($data, $upload, $partner_id)
{
    global $conn;

    $name = $price = $description = $picture = $category = "";
    $nameErr = $priceErr = $descriptionErr = $pictureErr = $categoryErr = "";

    if (empty($data["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = $data["name"];

        if (strlen($name) < 5) {
            $nameErr = "Name must have at least five characters";
        }
    }

    if (empty($data["price"])) {
        $priceErr = "Price is required";
    } else {
        $price = $data["price"];

        if ($price < 10000) {
            $priceErr = "Price must be higher than 10000";
        }
    }

    if (empty($data["description"])) {
        $descriptionErr = "Description is required";
    } else {
        $description = $data["description"];

        if (strlen($description) < 5) {
            $descriptionErr = "Description must have at least five characters";
        }
    }

    if (empty($data["category"])) {
        $categoryErr = "Category is required";
    } else {
        $category = $data["category"];
    }

    if (empty($upload["fileToUpload"]["name"])) {
        $pictureErr = "Picture is required";
    } else {
        $result = upload("product");

        if ($result["uploadOk"] == 1) {
            $picture = $result["filePath"];
        } else {
            $pictureErr = $result["uploadErr"];
        }
    }

    if (empty($nameErr) && empty($priceErr) && empty($descriptionErr) && empty($pictureErr) && empty($categoryErr)) {
        $query = "INSERT INTO products (partner_id, category_id, name, price, description, picture) 
                    VALUES ('$partner_id', '$category', '$name', '$price', '$description', '$picture')";

        if ($conn->query($query)) {
            header("location: /NeoMall/brand-partner/manage-product.php");
        } else {
            echo "Data Failed to Save!";
        }
    }

    return [
        'name' => $name,
        'price' => $price,
        'description' => $description,
        'picture' => $picture,
        'category' => $category,
        'nameErr' => $nameErr,
        'priceErr' => $priceErr,
        'descriptionErr' => $descriptionErr,
        'pictureErr' => $pictureErr,
        'categoryErr' => $categoryErr,
    ];
}

function update_product($data, $upload, $id, $row)
{
    global $conn;

    $name = $price = $description = $picture = $category = "";
    $nameErr = $priceErr = $descriptionErr = $pictureErr = $categoryErr = "";

    if (empty($data["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = $data["name"];

        if (strlen($name) < 5) {
            $nameErr = "Name must have at least five characters";
        }
    }

    if (empty($data["price"])) {
        $priceErr = "Price is required";
    } else {
        $price = $data["price"];

        if ($price < 10000) {
            $priceErr = "Price must be higher than 10000";
        }
    }

    if (empty($data["description"])) {
        $descriptionErr = "Description is required";
    } else {
        $description = $data["description"];

        if (strlen($description) < 5) {
            $descriptionErr = "Description must have at least five characters";
        }
    }

    if (empty($data["category"])) {
        $categoryErr = "Category is required";
    } else {
        $category = $data["category"];
    }

    if (empty($upload["fileToUpload"]["name"])) {
        $picture = $row["picture"];
    } else {
        $result = upload("product");

        if ($result["uploadOk"] == 1) {
            unlink($row["picture"]);
            $picture = $result["filePath"];
        } else {
            $pictureErr = $result["uploadErr"];
        }
    }

    if (empty($nameErr) && empty($priceErr) && empty($descriptionErr) && empty($pictureErr) && empty($categoryErr)) {
        $query = "UPDATE products SET category_id = '$category', name = '$name', price = '$price', description = '$description', picture = '$picture' WHERE id = '$id'";

        if ($conn->query($query)) {
            header("location: /NeoMall/brand-partner/manage-product.php");
        } else {
            echo "Data Failed to Save!";
        }
    }

    return [
        'name' => $name,
        'price' => $price,
        'description' => $description,
        'picture' => $picture,
        'category' => $category,
        'nameErr' => $nameErr,
        'priceErr' => $priceErr,
        'descriptionErr' => $descriptionErr,
        'pictureErr' => $pictureErr,
        'categoryErr' => $categoryErr,
    ];
}

function change_logo($upload, $id, $partner)
{
    global $conn;

    $logo = "";
    $logoErr = "";

    if (empty($upload["fileToUpload"]["name"])) {
        $logo = $partner["logo"];
    } else {
        $result = upload("logo");

        if ($result["uploadOk"] == 1) {
            unlink($partner["logo"]);
            $logo = $result["filePath"];
            $_SESSION["logo"] = $logo;
        } else {
            $logoErr = $result["uploadErr"];
        }
    }

    if (empty($logoErr)) {
        $query = "UPDATE partners SET logo = '$logo' WHERE id = '$id'";

        if ($conn->query($query)) {
            header("location: /NeoMall/brand-partner/index.php");
        } else {
            echo "Data Failed to Save!";
        }
    }

    return [
        'logo' => $logo,
        'logoErr' => $logoErr
    ];
}

function change_password($data, $id)
{
    global $conn;

    $current_password = $new_password = $confirm_password = "";
    $currentPassErr = $newPasswordErr = $confirmPassErr = "";

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

    $query = mysqli_query($conn, "SELECT * FROM partners WHERE id = '$id'");
    $partner = mysqli_fetch_assoc($query);

    if (password_verify($current_password, $partner["password"])) {
        if (empty($currentPassErr) && empty($newPasswordErr) && empty($confirmPassErr)) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            $query = "UPDATE partners SET password = '$hashed_new_password' WHERE id = '$id'";

            if ($conn->query($query)) {
                header("location: /NeoMall/brand-partner/index.php");
            } else {
                echo "Data Failed to Save!";
            }
        }
    } else {
        $currentPassErr = "Invalid password";
    }

    return [
        'current_password' => $current_password,
        'new_password' => $new_password,
        'confirm_password' => $confirm_password,
        'currentPassErr' => $currentPassErr,
        'newPasswordErr' => $newPasswordErr,
        'confirmPassErr' => $confirmPassErr,
    ];
}

function getCurrentOrders()
{
    global $conn;

    $partner_id = $_SESSION['id'];

    $query = "SELECT DISTINCT OI.id, O.id AS order_id, O.first_name, O.last_name, O.email, OI.name, OI.status, O.created_at 
            FROM order_items OI JOIN orders O ON OI.order_id = o.id 
            JOIN products P ON OI.product_id = P.id
            WHERE P.partner_id = '$partner_id' AND (OI.status = 'new' OR OI.status = 'inProgress') ORDER BY OI.created_at DESC";

    $orders = [];

    $exec = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($exec)) {
        $orders[] = $row;
    }

    return ['orders' => $orders];
}

function getOrderDetail($id)
{
    global $conn;

    $query = "SELECT P.id AS product_id, O.id AS order_id, O.first_name, O.last_name, O.email, OI.name, OI.status, 
                O.address, O.phone, O.additional_info, OI.size, OI.quantity, OI.total, OI.price
                FROM order_items OI JOIN orders O ON OI.order_id = o.id 
                JOIN products P ON OI.product_id = P.id
                WHERE OI.id = $id";

    $exec = mysqli_query($conn, $query);
    $order = mysqli_fetch_assoc($exec);

    return ['order' => $order];
}

function update_status($data, $id)
{
    global $conn;

    $status = $data['status'];

    $query = "UPDATE order_items SET status = '$status' WHERE id = $id";

    if ($conn->query($query)) {
        header("location: index.php");
    } else {
        echo 'error';
    }
}

function getCompletedOrders()
{
    global $conn;

    $partner_id = $_SESSION['id'];

    $query = "SELECT DISTINCT OI.id, O.id AS order_id, O.first_name, O.last_name, O.email, OI.name, OI.status, O.created_at 
            FROM order_items OI JOIN orders O ON OI.order_id = o.id 
            JOIN products P ON OI.product_id = P.id
            WHERE P.partner_id = '$partner_id' AND OI.status = 'completed' ORDER BY OI.created_at DESC";

    $orders = [];

    $exec = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($exec)) {
        $orders[] = $row;
    }

    return ['orders' => $orders];
}
