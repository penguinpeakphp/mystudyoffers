<?php
    require_once "controllers/globaldata.php";
?>
<header id="header">
    <div class="loader"></div>
    <div class="container">
        <div class="main-header">
            <div class="row">
                <div class="col-auto">
                    <div class="logo-img">
                        <a href="/"><img src="images/logo-img.png" alt=""></a>
                    </div>
                </div>
                <div class="col-auto ms-auto">
                    <div class="right-header">
                        <div class="header-info">
                            <span><svg width="18px" height="18px" viewBox="0 0 17 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path d="M15.668 6.017c-0.957-3.557-3.863-6.017-7.168-6.017-3.295 0-6.212 2.464-7.168 6.017-0.747 0.082-1.332 0.712-1.332 1.483v4c0 0.625 0.382 1.16 0.924 1.385 0.194 1.747 1.663 3.115 3.461 3.115h2.707c0.207 0.581 0.757 1 1.408 1h3c0.827 0 1.5-0.673 1.5-1.5s-0.673-1.5-1.5-1.5h-3c-0.651 0-1.201 0.419-1.408 1h-2.707c-1.208 0-2.217-0.86-2.449-2h1.064v-1h1v-5h-1v-1h-0.606c0.913-2.961 3.352-5 6.106-5 2.762 0 5.193 2.037 6.106 5h-0.606v1h-1v5h1v1h1.506c0.824 0 1.494-0.673 1.494-1.5v-4c0-0.771-0.585-1.401-1.332-1.483zM8.5 15h3c0.275 0 0.5 0.224 0.5 0.5s-0.225 0.5-0.5 0.5h-3c-0.275 0-0.5-0.224-0.5-0.5s0.225-0.5 0.5-0.5zM2 12h-0.506c-0.272 0-0.494-0.224-0.494-0.5v-4c0-0.276 0.222-0.5 0.494-0.5h0.506v5zM16 11.5c0 0.276-0.222 0.5-0.494 0.5h-0.506v-5h0.506c0.272 0 0.494 0.224 0.494 0.5v4z" fill="#000000" />
                                </svg> Call us : <?= $sitephone ?> </span>
                            <span>|</span>
                            <span><svg fill="#000000" height="18px" width="18px" version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 256 235" xml:space="preserve">
                                    <path d="M250,107.6v-0.3l-19.4-34.1v47.1l-12.2,8V7.2H37.1V128l-12.2-8V73.2L5.5,107.3v122.5H128h122.5V107.3L250,107.6z M48.8,18.9
                h157.9v117.1L128,187.7l-79.2-52V18.9z M94.7,65H68.8V39.1h25.9V65z M187.3,65h-79.8V47.6h79.8V65z M187.3,97.4H68.8V80h118.5V97.4z
                 M187.3,129.9H68.8v-17.4h118.5V129.9z" />
                                </svg> Email us : <?= $siteemail ?></span>
                        </div>
                        <div class="main_menu">
                            <nav class="navbar navbar-expand-lg navbar-light">
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon">
                                        <svg width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 6H20M4 12H20M4 18H20" stroke="#000843" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                        <li class="nav-item">
                                            <a class="nav-link" href="index.php">Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="about.php">About us</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="services.php">Services</a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="contact.php">Contact us </a>
                                        </li>
                                        <?php
                                            if(isset($_SESSION["name"]))
                                            {
                                        ?>
                                                <li class="nav-item d-black d-lg-none">
                                                    <a href="/dashboard.php" class="nav-link login-btn">My Dashboard</a>
                                                </li>
                                                <li class="nav-item d-black d-lg-none">
                                                    <a class="nav-link register-btn logout">Logout</a>
                                                </li>
                                        <?php
                                            }
                                            else
                                            {
                                        ?>
                                                <li class="nav-item d-black d-lg-none">
                                                    <a href="/login.php" class="nav-link login-btn">Login</a>
                                                </li>
                                                <li class="nav-item d-black d-lg-none">
                                                    <a class="nav-link register-btn registerbutton">Register </a>
                                                </li>
                                        <?php
                                            }
                                        ?>
                                        <li class="nav-item d-black d-lg-none">
                                            <div class="info-text">
                                                <strong>Call us</strong> : <?= $sitephone ?> <br>
                                                <strong>Email us </strong>: <?= $siteemail ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>

                    <?php
                        if(isset($_SESSION["name"]))
                        {
                    ?>
                            <div class="header-btn">
                                <a href="/dashboard.php" type="button" class="login-btn">My Dashboard</a>
                                <a type="button" class="register-btn logout">Logout</a>
                            </div>
                    <?php   
                        }
                        else
                        {
                    ?>
                            <div class="header-btn">
                                <a href="/login.php" type="button" class="login-btn">Login</a>
                                <a type="button" class="registerbutton register-btn" id="openregister">Register</a>
                            </div>
                    <?php
                        }        
                    ?>
                </div>
            </div>
        </div>

    </div>
</header>