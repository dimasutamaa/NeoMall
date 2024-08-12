<nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary py-3">
    <div class="container container-fluid">
        <button data-mdb-collapse-init class="navbar-toggler" type="button" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <a class="navbar-brand mt-2 mt-lg-0 fs-4 fw-medium" href="/NeoMall/index.php">NeoMall</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
            <form class="d-flex input-group w-auto me-1">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <span class="input-group-text border-0" id="search-addon">
                    <i class="fas fa-search"></i>
                </span>
            </form>
        </div>

        <div class="d-flex align-items-center">
            <?php
            // Guest
            if (!isset($_SESSION["isLogin"])) {
                echo '<a href="/NeoMall/account/login.php" class="btn btn-secondary me-2">Login</a>
                    <a href="/NeoMall/account/register.php" class="btn btn-primary">Register</a>';
            }
            // Guest

            if (isset($_SESSION["isLogin"])) {
                // Customer
                if ($_SESSION["role"] == "customer") {
                    echo '<a class="link-secondary me-3" href="#">
                            <i class="fa-solid fa-cart-shopping fa-lg" style="color: #0c0d0d;"></i>
                            <span class="badge bg-danger badge-dot"></span>
                        </a>';
                }
                // Customer

                echo '<div class="dropdown">
                        <a data-mdb-dropdown-init class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" aria-expanded="false">
                            <i class="fa-solid fa-user fa-lg" style="color: #0c0d0d;"></i>
                            <span class="ps-2 text-black">'; echo $_SESSION["username"]; echo '</span>
                        </a>
                    <ul class="dropdown-menu dropdown-menu-start mt-3" aria-labelledby="navbarDropdownMenuAvatar">';

                // Customer
                if ($_SESSION["role"] == "customer") {
                    echo '<li>
                            <a class="dropdown-item" href="#">History</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Settings</a>
                        </li>';
                }
                // Customer

                // Brand Partner
                if ($_SESSION["role"] == "partner") {
                    echo '<li>
                            <a class="dropdown-item" href="#">Completed Orders</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/NeoMall/brand-partner/manage-product.php">Manage Products</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Settings</a>
                        </li>';
                }
                // Brand Partner

                // Admin
                if ($_SESSION["role"] == "admin") {
                    echo '<li>
                            <a class="dropdown-item" href="/NeoMall/admin/manage-admin.php">Manage Admin</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/NeoMall/admin/manage-category.php">Manage Categories</a>
                        </li>';
                }
                // Admin

                echo '<li>
                        <a class="dropdown-item" href="/NeoMall/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>';
            } ?>
        </div>
    </div>
</nav>