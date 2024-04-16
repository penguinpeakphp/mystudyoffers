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
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/img/trust.jpg') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


    <!-- Elmentkit Icon CSS -->
    <link rel="stylesheet" type="text/css" href="elementskit-icon-pack/assets/css/ekiticons.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

    <title>Student Profile - MyStudyOffers</title>
</head>

<body>
    <?php
    require_once "partials/header.php";
    ?>

    <section class="header-section container">
        <?php
        require_once "partials/headersection.php";
        ?>
    </section>


    <section class="contact-page-section">
        <div class="register-section container">
            <div class="register-box maxwidth-100">


                <!-- Login Form -->
                <form id="academicform2">

                    <div class="styled-form maxwidth-100">
                        <div class="styled-form maxwidth-100 pt-30" id="submitbtns">

                            <div class="row clearfix">
                                <div class="form-group col-lg-4 text-center">
                                    <button type="submit" class="readon btn">
                                        <span class="txt">Save & Continue</span></button>
                                </div>
                                <div class="form-group col-lg-4 text-center">
                                    <a href="dashboard.php">
                                        <button type="button" class="readon btn">
                                            <span class="txt">Back to Dashboard</span></button></a>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <?php
    require_once "partials/footer.php";
    ?>
    <script src="js/custom.js"></script>
    <script src="js/academic2.js"></script>

</body>

</html>