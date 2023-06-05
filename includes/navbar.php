<nav class="navbar navbar-expand-lg navbar-dark bg-dark-blue navbarclass">
    <div class="container">
        <a class="navbar-brand" href="index.php">Project3</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Add to Database
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" <?php if (isset($_SESSION['login_admin'])) {
                                                            echo 'href="add_customer.php"';
                                                        } ?>><?php if (!isset($_SESSION['login_admin'])) {
                                    echo '<i class="fa-solid fa-lock"></i>';
                                } ?> Add Customer</a></li>
                        <li><a class="dropdown-item" <?php if (isset($_SESSION['login_admin'])) {
                                                            echo 'href="add_employee.php"';
                                                        } ?>><?php if (!isset($_SESSION['login_admin'])) {
                                    echo '<i class="fa-solid fa-lock"></i>';
                                } ?> Add Employee</a></li>
                        <li><a class="dropdown-item" <?php if (isset($_SESSION['login_admin'])) {
                                                            echo 'href="add_office.php"';
                                                        } ?>><?php if (!isset($_SESSION['login_admin'])) {
                                    echo '<i class="fa-solid fa-lock"></i>';
                                } ?> Add Office</a></li>
                        <li><a class="dropdown-item" <?php if (isset($_SESSION['login_admin'])) {
                                                            echo 'href="add_orderdetails.php"';
                                                        } ?>><?php if (!isset($_SESSION['login_admin'])) {
                                    echo '<i class="fa-solid fa-lock"></i>';
                                } ?> Add Order Details</a></li>
                        <li><a class="dropdown-item" <?php if (isset($_SESSION['login_admin'])) {
                                                            echo 'href="add_order.php"';
                                                        } ?>><?php if (!isset($_SESSION['login_admin'])) {
                                    echo '<i class="fa-solid fa-lock"></i>';
                                } ?> Add Order</a></li>
                        <li><a class="dropdown-item" <?php if (isset($_SESSION['login_admin'])) {
                                                            echo 'href="add_payment.php"';
                                                        } ?>><?php if (!isset($_SESSION['login_admin'])) {
                                    echo '<i class="fa-solid fa-lock"></i>';
                                } ?> Add Payment</a></li>
                        <li><a class="dropdown-item" <?php if (isset($_SESSION['login_admin'])) {
                                                            echo 'href="add_productline.php"';
                                                        } ?>><?php if (!isset($_SESSION['login_admin'])) {
                                    echo '<i class="fa-solid fa-lock"></i>';
                                } ?> Add Productline</a></li>
                        <li><a class="dropdown-item" <?php if (isset($_SESSION['login_admin'])) {
                                                            echo 'href="add_product.php"';
                                                        } ?>><?php if (!isset($_SESSION['login_admin'])) {
                                    echo '<i class="fa-solid fa-lock"></i>';
                                } ?> Add Product</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto"> <!-- Add "ms-auto" to align the login button to the right -->
                <?php if (!isset($_SESSION['login_user'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../webpages/register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../webpages/login.php">Login</a>
                    </li>
                <?php } elseif (isset($_SESSION['login_user']) && !isset($_SESSION['login_admin'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link pointer">
                            <?php echo $_SESSION['login_user']; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../includes/logout.php">Logout</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link pointer">
                            <?php echo $_SESSION['login_user']; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../webpages/adminpanel.php">Admin panel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../includes/logout.php">Logout</a>
                    </li>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>