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
