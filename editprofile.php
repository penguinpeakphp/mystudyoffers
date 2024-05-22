<?php
require_once "controllers/functions/globalfunctions.php";

checksession();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--fontawesome
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">-->

    <!-- font-awesome css -->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

    <!-- Elmentkit Icon CSS -->
    <link rel="stylesheet" type="text/css" href="elementskit-icon-pack/assets/css/ekiticons.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">


    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />

    <title>Queries - MyStudyOffers</title>
</head>

<body>
    <?php
    require_once "partials/header.php";
    ?>

    <div class="container">

        <div class="content-section">
            <?php
            require_once "partials/sidebar.php";
            ?>

            <section class="main">
                <section class="header-section">
                    <?php
                    require_once "partials/headersection.php";
                    ?>
                </section>

                <div class="profile-form">
                    <div class="register_form">
                        <h3>My Profile</h3>
                        <form action="" name="studentregi" method="post">
                            <div class="form-col">
                                <label for="">Name</label>
                                <input type="text" name="name" placeholder="enter your name" required="">
                            </div>

                            <div class="form-col">
                                <label for="">Phone</label>
                                <input type="number" name="phone" placeholder="enter your valid phone number" required="">
                            </div>
                            <div class="form-col">
                                <label for="">Email</label>
                                <input type="email" name="stemail" id="stemail" placeholder="enter your valid email" required="">
                            </div>
                            <div class="form-col">
                                <label for="">password</label>
                                <input type="password" name="password" placeholder="enter your password" required="">
                            </div>
                            <div class="form-col">
                                <label for="">Address</label>
                                <textarea id="exampleFormControlTextarea1" rows="5" style="height: 80px !important;"></textarea>
                            </div>

                            <div class="form-col">
                                <input type="Submit" name="btnsubmit" value="Submit" class="register-btn">
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
    </section>

    <?php
    require_once "partials/footer.php";
    ?>
    <script src="js/editprofile.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>