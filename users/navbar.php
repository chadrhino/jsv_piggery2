<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container">
        <h1 class="navbar-brand fw-bold mb-0"><a href="index.php?page=home" class="text-decoration-none text-dark">JSV Piggery</a></h1>

        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu"><i class="fa fa-bars"></i></button>

        <div class="navbar-collapse collapse" id="menu">
            <ul class="navbar-nav ms-lg-auto gap-lg-4">
                <li class="nav-item">
                    <a href="index.php?page=home" class="nav-link <?= isset($_GET['page']) ? $_GET['page'] == 'home' ? 'active' : '' : 'active' ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=about" class="nav-link <?= isset($_GET['page']) ? $_GET['page'] == 'about' ? 'active' : '' : '' ?>">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="index.php?page=product" class="nav-link <?= isset($_GET['page']) ? $_GET['page'] == 'product' ? 'active' : '' : '' ?>">Products</a>
                </li>
                <?php
                if (isset($_SESSION['USER_ID']) && isset($_SESSION['USER_NAME']) && isset($_SESSION['USER_EMAIL'])) {
                ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-user"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li >
                                <a href="index.php?logout" class="dropdown-item"><i class="fa fa-sign-out"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                <?php
                } else {
                ?>
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-dark rounded-0">Sign In</a>
                    </li>
                <?php
                }
                ?>

            </ul>
        </div>
    </div>
</nav>