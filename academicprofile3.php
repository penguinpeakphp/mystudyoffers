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
                <form id="academicform3">

                    <div class="styled-form maxwidth-100">
                        <h4 class="title mb-10 mt-30">Higher Schooling > Commerce/Business</h4>
                        <div class="sec-title mt-30">
                            <h5 class="title mb-10">Passing Year</h5>
                            <p>If pursuing tap predicted</p>
                        </div>
                        <div class="row clearfix">
                            <!-- Form Group -->
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="radio" id="passyear79" name="passyear9" value="7">
                                <label class="checklabel" for="passyear79" data-content="2025 or later">2025 or later</label>
                            </div>
                            <!-- Form Group -->
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="radio" id="passyear69" name="passyear9" value="6" checked>
                                <label class="checklabel" for="passyear69" data-content="2024">2024</label>
                            </div>
                            <!-- Form Group -->
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="radio" id="passyear59" name="passyear9" value="5">
                                <label class="checklabel" for="passyear59" data-content="2023">2023</label>
                            </div>
                            <!-- Form Group -->
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="radio" id="passyear49" name="passyear9" value="4">
                                <label class="checklabel" for="passyear49" data-content="2022">2022</label>
                            </div>
                            <!-- Form Group -->
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="radio" id="passyear39" name="passyear9" value="3">
                                <label class="checklabel" for="passyear39" data-content="2021">2021</label>
                            </div>
                            <!-- Form Group -->
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="radio" id="passyear29" name="passyear9" value="2">
                                <label class="checklabel" for="passyear29" data-content="2020">2020</label>
                            </div>
                            <!-- Form Group -->
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="radio" id="passyear19" name="passyear9" value="1">
                                <label class="checklabel" for="passyear19" data-content="2009 or before">2009 or before</label>
                            </div>
                        </div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/academic3.js"></script>

</body>

</html>