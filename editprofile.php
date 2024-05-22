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
                        <h3>Edit Profile</h3>
                        <form id="editprofile">
                            <div class="form-col">
                                <label for="editname">Name</label>
                                <input type="text" name="editname" id="editname" value="" placeholder="enter your name" required>
                            </div>

                            <div class="form-col">
                                <label for="editphone">Phone</label>
                                <input type="number" name="editphone" id="editphone" value="" placeholder="enter your valid phone number" required>
                            </div>
                            <div class="form-col">
                                <label for="editemail">Email</label>
                                <input type="email" name="editemail" id="editemail" value="" placeholder="enter your valid email" required>
                            </div>
                            <div class="form-col">
                                <label for="editpassword">Password</label>
                                <input type="password" name="editpassword" id="editpassword" value="" placeholder="enter your password">
                            </div>
                            <div class="form-col">
                                <label for="editpincode">Pincode</label>
                                <input type="text" name="editpincode" id="editpincode" value="" placeholder="enter your pincode" required></input>
                            </div>

                            <div class="form-col mt-2">
                                <button type="submit" class="register-btn">Update</button>
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