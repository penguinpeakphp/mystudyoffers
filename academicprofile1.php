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
                <form id="academicform1">

                    <div class="styled-form maxwidth-100">
                        <div class="sec-title mb-30">
                            <h4 class="title mb-10">My Academics</h4>
                            <p>Also Include pursing the latest, you may tap all applicable</p>
                        </div>
                        <div class="row clearfix academicoptionlist">
                        </div>
                    </div>



                    <!--qualification section-->




                    <!--Destimation section-->


                    <div class="styled-form maxwidth-100 pt-30">

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


                </form>
            </div>
        </div>
    </section>

    <?php
    require_once "partials/footer.php";
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/academic1.js"></script>

</body>

</html>