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
