<?php
require("../functions/general.php");

function register_admin($data)
{
    global $conn;

    $username = $email = $phone = $gender = "";
    $usernameErr = $emailErr = $phoneErr = $genderErr = "";

    try {
        if (empty($data["username"])) {
            $usernameErr = "Username is required";
        } else {
            $username = $data["username"];

            if (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {
                $usernameErr = "Only letters and white space allowed";
            }

            if (strlen($username) < 5) {
                $usernameErr = "Username must have at least five characters";
            }
        }

        if (empty($data["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = $data["email"];

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

        if (empty($data["gender"])) {
            $genderErr = "Gender is required";
        } else {
            $gender = $data["gender"];
        }

        if (empty($usernameErr) && empty($emailErr) && empty($phoneErr) && empty($genderErr)) {
            $password = random_password();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO admins (username, email, phone, gender, password, role) VALUES ('$username', '$email', '$phone', '$gender', '$hashed_password', 'admin')";

            if ($conn->query($query)) {
                echo '<script>
                        alert("Registration Success!\n\nPassword: ';
                echo $password;
                echo '\n\nPassword is generated by system.\nPlease instruct the admin to change the password right away.");
                        window.location.href = "/NeoMall/admin/manage-admin.php";
                    </script>';
            } else {
                echo "Data Failed to Save!";
            }
        }
    } catch (mysqli_sql_exception) {
        $usernameErr = "Username has been used";
    }

    return [
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'gender' => $gender,
        'usernameErr' => $usernameErr,
        'emailErr' => $emailErr,
        'phoneErr' => $phoneErr,
        'genderErr' => $genderErr,
    ];
}

function update_admin($data, $id)
{
    global $conn;

    $username = $email = $phone = $gender = "";
    $usernameErr = $emailErr = $phoneErr = $genderErr = "";

    try {
        if (empty($data["username"])) {
            $usernameErr = "Username is required";
        } else {
            $username = $data["username"];

            if (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {
                $usernameErr = "Only letters and white space allowed";
            }

            if (strlen($username) < 5) {
                $usernameErr = "Username must have at least five characters";
            }
        }

        if (empty($data["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = $data["email"];

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

        if (empty($data["gender"])) {
            $genderErr = "Gender is required";
        } else {
            $gender = $data["gender"];
        }

        if (empty($usernameErr) && empty($emailErr) && empty($phoneErr) && empty($genderErr)) {

            $query = "UPDATE admins SET username = '$username', email = '$email', phone = '$phone', gender = '$gender' WHERE id = $id";

            if ($conn->query($query)) {
                header("location: /NeoMall/admin/manage-admin.php");
            } else {
                echo "Data Failed to Save!";
            }
        }
    } catch (mysqli_sql_exception) {
        $usernameErr = "Username has been used";
    }

    return [
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'gender' => $gender,
        'usernameErr' => $usernameErr,
        'emailErr' => $emailErr,
        'phoneErr' => $phoneErr,
        'genderErr' => $genderErr,
    ];
}

function add_category($data)
{
    global $conn;

    $category_name = "";
    $categoryErr = "";

    $status = $data['status'];

    try {
        if (empty($data["category_name"])) {
            $categoryErr = "Category is required";
        } else {
            $category_name = $data["category_name"];

            if (!preg_match("/^[a-zA-Z-' ]*$/", $category_name)) {
                $categoryErr = "Only letters and white space allowed";
            }
        }

        if (empty($categoryErr) && empty($statusErr)) {
            $query = "INSERT INTO categories (name, status) VALUES ('$category_name', '$status')";

            if ($conn->query($query)) {
                header("location: /NeoMall/admin/manage-category.php");
            } else {
                echo "Failed to save data!";
            }
        }
    } catch (mysqli_sql_exception) {
        $categoryErr = "Category name has been used";
    }

    return [
        'status' => $status,
        'category_name' => $category_name,
        'categoryErr' => $categoryErr
    ];
}

function edit_category($data, $id)
{
    global $conn;

    $category_name = "";
    $categoryErr = "";

    $status = $data['status'];

    try {
        if (empty($data["category_name"])) {
            $categoryErr = "Category is required";
        } else {
            $category_name = $data["category_name"];

            if (!preg_match("/^[a-zA-Z-' ]*$/", $category_name)) {
                $categoryErr = "Only letters and white space allowed";
            }
        }

        if (empty($categoryErr) && empty($statusErr)) {
            $query = "UPDATE categories SET name = '$category_name', status = '$status' WHERE id = $id";

            if ($conn->query($query)) {
                header("location: /NeoMall/admin/manage-category.php");
            } else {
                echo "Failed to save data!";
            }
        }
    } catch (mysqli_sql_exception) {
        $categoryErr = "Category name has been used";
    }

    return [
        'status' => $status,
        'category_name' => $category_name,
        'categoryErr' => $categoryErr
    ];
}

function register_partner($data, $upload)
{
    global $conn;

    $username = $email = $phone = $logo = "";
    $usernameErr = $emailErr = $phoneErr = $logoErr = "";

    try {
        if (empty($data["username"])) {
            $usernameErr = "Name is required";
        } else {
            $username = $data["username"];

            if (strlen($username) < 5) {
                $usernameErr = "Name must have at least five characters";
            }
        }

        if (empty($data["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = $data["email"];

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

        if (empty($upload["fileToUpload"]["name"])) {
            $logoErr = "Logo is required";
        } else {
            $result = upload("logo");

            if ($result["uploadOk"] == 1) {
                $logo = $result["filePath"];
            } else {
                $logoErr = $result["uploadErr"];
            }
        }

        if (empty($usernameErr) && empty($emailErr) && empty($phoneErr) && empty($logoErr)) {
            if ($result['uploadOk'] == 1) {
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $result['target_file']);
            }

            $password = random_password();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO partners (username, email, phone, logo, password, role)
                        VALUES ('$username', '$email', '$phone', '$logo', '$hashed_password', 'partner')";

            if ($conn->query($query)) {
                echo '<script>
                            alert("Registration Success!\n\nPassword: ';
                echo $password;
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

    return [
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'logo' => $logo,
        'usernameErr' => $usernameErr,
        'emailErr' => $emailErr,
        'phoneErr' => $phoneErr,
        'logoErr' => $logoErr,
    ];
}

function update_partner($data, $id, $row, $upload)
{
    global $conn;

    $username = $email = $phone = $logo = "";
    $usernameErr = $emailErr = $phoneErr = $logoErr = "";

    try {
        if (empty($data["username"])) {
            $usernameErr = "Name is required";
        } else {
            $username = $data["username"];

            if (strlen($username) < 5) {
                $usernameErr = "Name must have at least five characters";
            }
        }

        if (empty($data["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = $data["email"];

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

        if (empty($upload["fileToUpload"]["name"])) {
            $logo = $row["logo"];
        } else {
            $result = upload("logo");

            if ($result["uploadOk"] == 1) {
                unlink($row["logo"]);
                $logo = $result["filePath"];
            } else {
                $logoErr = $result["uploadErr"];
            }
        }

        if (empty($usernameErr) && empty($emailErr) && empty($phoneErr) && empty($logoErr)) {
            if ($result['uploadOk'] == 1) {
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $result['target_file']);
            }

            $query = "UPDATE partners SET username = '$username', email = '$email', phone = '$phone', logo = '$logo' WHERE id = $id";

            if ($conn->query($query)) {
                header("location: /NeoMall/admin/index.php");
            } else {
                echo "Data Failed to Save!";
            }
        }
    } catch (mysqli_sql_exception) {
        $usernameErr = "Name has been used";
    }

    return [
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
        'logo' => $logo,
        'usernameErr' => $usernameErr,
        'emailErr' => $emailErr,
        'phoneErr' => $phoneErr,
        'logoErr' => $logoErr,
    ];
}

function add_shipping($data)
{
    global $conn;

    $type = $price = "";
    $typeErr = $priceErr = "";

    try {
        if (empty($data['type'])) {
            $typeErr = "Type is required";
        } else {
            $type = $data['type'];

            if (!preg_match("/^[a-zA-Z-' ]*$/", $type)) {
                $typeErr = "Only letters and white space allowed";
            }
        }

        if (empty($data['price'])) {
            $priceErr = "Price is required";
        } else {
            $price = $data['price'];

            if (!filter_var($price, FILTER_VALIDATE_INT)) {
                $priceErr = "Price must be number only";
            }

            if ($price < 1000) {
                $priceErr = "Price must be greater than 1000";
            }
        }

        if (empty($typeErr) && empty($priceErr)) {
            $query = "INSERT INTO shippings (type, price) VALUES ('$type', '$price')";

            if ($conn->query($query)) {
                header("location: /NeoMall/admin/manage-shipping.php");
            } else {
                echo "Failed to save data!";
            }
        }
    } catch (mysqli_sql_exception) {
        $typeErr = "Type has been used";
    }

    return [
        'type' => $type,
        'price' => $price,
        'typeErr' => $typeErr,
        'priceErr' => $priceErr
    ];
}

function edit_shipping($data, $id)
{
    global $conn;

    $type = $price = "";
    $typeErr = $priceErr = "";

    try {
        if (empty($data['type'])) {
            $typeErr = "Type is required";
        } else {
            $type = $data['type'];

            if (!preg_match("/^[a-zA-Z-' ]*$/", $type)) {
                $typeErr = "Only letters and white space allowed";
            }
        }

        if (empty($data['price'])) {
            $priceErr = "Price is required";
        } else {
            $price = $data['price'];

            if (!filter_var($price, FILTER_VALIDATE_INT)) {
                $priceErr = "Price must be number only";
            }

            if ($price < 1000) {
                $priceErr = "Price must be greater than 1000";
            }
        }

        if (empty($typeErr) && empty($priceErr)) {
            $query = "UPDATE shippings SET type = '$type', price = '$price' WHERE id = $id";

            if ($conn->query($query)) {
                header("location: /NeoMall/admin/manage-shipping.php");
            } else {
                echo "Failed to save data!";
            }
        }
    } catch (mysqli_sql_exception) {
        $typeErr = "Type has been used";
    }

    return [
        'type' => $type,
        'price' => $price,
        'typeErr' => $typeErr,
        'priceErr' => $priceErr
    ];
}

function checkAction($data)
{
    $id = isset($data['id']) ? $data['id'] : '';

    if (isset($data['action']) == 'edit') {
        return '?action=edit&id=' . $id;
    } else if (isset($data['action']) == 'delete') {
        return '?action=delete&id=' . $id;
    } else {
        return '';
    }
}

function search($search)
{
    global $conn;

    $query = "SELECT a.username, a.role, a.id 
                FROM admins a 
                WHERE a.username LIKE '%$search%' 
                UNION ALL 
                SELECT p.username, p.role, p.id 
                FROM partners p 
                WHERE p.username LIKE '%$search%'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $username = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $username[] = $row;
        }
    } else {
        $username = [];
    }

    return ['username' => $username];
}
