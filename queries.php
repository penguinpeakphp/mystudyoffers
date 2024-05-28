<?php
require_once "controllers/functions/globalfunctions.php";

checksession();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Queries - My Study Offers</title>
    <link rel="icon" href="images/logo-img.png" type="image/png" sizes="16x16" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/media.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <?php
    require_once "partials/header.php";
    ?>
    <div class="main">
        <div class="container">
            <div class="mystudy-dashboard">
                <div class="left-content">
                    <?php
                    require_once "partials/sidebar.php";
                    ?>
                    <?php
                    require_once "partials/sidebarextra.php";
                    ?>
                </div>
                <div class="right-content">
                    <div class="header-section mb-4">
                        <?php
                        require_once "partials/headernav.php";
                        ?>
                    </div>

                    <div class="add-question mb-4">
                        <h3>Ask a Query</h3>
                        <div class="input-container mb-3">
                            <select id="querytype" name="querytype" class="form-select h-100">
                                <option value="" disabled="" selected="">Query Type</option>
                                <option value="1">General Question</option>
                                <option value="2">Loan Inquiry</option>
                                <option value="3">Admission Inquiry</option>
                            </select>
                            <input class="h-100" id="query" type="text" placeholder="Enter your query">
                            <button class="question-button h-100" id="askquery">Add Query</button>
                        </div>
                    </div>

                    <div class="query-list table-responsive mb-3">
                        <h3 class="mt-2">Query List</h3>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Sr.</th>
                                    <th scope="col">My Query</th>
                                    <th scope="col">Query Type</th>
                                    <th scope="col">Last Reply</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="querybody">
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="detail">
                                <div class="visa-application mb-3">
                                    <img src="images/ms_imgs/visa-application-banner.jpg" class="img-fluid">
                                    <div class="visa-content">
                                        <h2>My Visa <span>Applications</span></h2>
                                        <a href="">Learn More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="personal-detail">
                                <div class="travel-bookcontainer mb-3 mt-0">
                                    <img src="images/ms_imgs/travel-img.jpg" class="img-fluid">
                                    <h2>Travel Booking</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        require_once "partials/footer.php";
        ?>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/custom.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script src="js/query.js"></script>

</body>

</html>