<?php
include("../config.php");
require("../functions/admin.php");

session_start();

$category_name = "";
$categoryErr = "";

if (!isset($_SESSION["isLogin"]) || $_SESSION["role"] == "customer") {
    header("location: /NeoMall/index.php");
}

if ($_SESSION["role"] == "partner") {
    header("location: /NeoMall/brand-partner/index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = add_category($_POST);

    $category_name = $data['category_name'];
    $categoryErr = $data['categoryErr'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.min.css" rel="stylesheet" />
    <title>Admin | NeoMall</title>
</head>

<body style="background-color: #eee;">
    <?php include("../layout/header.php") ?>

    <div class="container mx-auto mt-5" style="width: 850px;">
        <div class="card">
            <div class="card-header bg-light">
                <div class="row">
                    <div class="col d-flex justify-content-start">
                        <h3>Category</h3>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
                            New Category
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="newCategoryModalLabel">New Category</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="categoryForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="category_name" class="form-label">Category</label>
                                                <span class="text-danger">*</span>
                                                <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category_name ?>">
                                                <div id="categoryErr" class="form-text text-danger"><?php echo $categoryErr ?></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body bg-light">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM categories");
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <div class="row">
                        <div class="col d-flex justify-content-start">
                            <div class="p-1" style="font-size: 18px;"><?= $data['name'] ?></div>
                        </div>
    
                        <div class="col d-flex justify-content-end">
                            <a onclick="if (confirm('Are you sure want to delete this category?')) {
                            window.location.href='/NeoMall/admin/delete-category.php?id=<?= $data['id'] ?>' }" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                    <hr>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.3.2/mdb.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    document.getElementById('categoryForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        fetch(form.action, {
            method: form.method,
            body: formData,
        }).then(response => response.text()).then(data => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(data, 'text/html');
            const error = doc.querySelector('#categoryErr').textContent.trim();
            if (error) {
                document.getElementById('categoryErr').textContent = error;
                const modal = bootstrap.Modal(document.getElementById('newCategoryModal'));
                modal.show();
            } else {
                window.location.href = "/NeoMall/admin/manage-category.php";
            }
        }).catch(error => console.error('Error:', error));
    });
</script>

</html>