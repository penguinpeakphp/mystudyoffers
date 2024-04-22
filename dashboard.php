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

    <title>Student Dashboard - MyStudyOffers</title>
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

                <?php
                    require_once "partials/bannersection.php";
                ?>

                <section class="sub-main">
                    <div>
                        <!-- end myacademic section -->
                        <div class="academics mb-5">
                            <div class="title mb-2">
                                <h5>My Academics</h5>
                                <a href="academicprofile1.php">Edit</a>
                            </div>
                            <div class="education-detail" id="academicdetail">
                            </div>
                        </div>

                        <!-- end myacademic section -->

                        <!-- my qualification section start -->
                        <div class="academics mb-5">
                            <div class="title mb-2">
                                <h5>My Qualification</h5>
                                <a href="qualificationprofile.php">Edit</a>
                            </div>
                            <div class="education-detail" id="qualificationlevel">
                                <div class="mb-3">
                                    <span class="education-title">
                                        Level of Qualification
                                        <!--<span class="border-line"></span>-->
                                        <span></span>
                                </div>

                            </div>
                            <!-- Next Qualification -->
                            <div class="education-detail" id="nextqualification">
                                <div class="mb-3">
                                    <span class="education-title">
                                        Next Qualification
                                        <!--<span class="border-line"></span>-->
                                        <span></span>
                                </div>

                            </div>

                        </div>
                        <!--  my qualification section -->


                        <!-- end myacademic section -->
                        <div class="academics mb-5">
                            <div class="title mb-2">
                                <h5>My Test Scores</h5>
                                <a href="testscoreprofile.php">Edit</a>
                            </div>
                            <div class="education-detail">

                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar row justify-content-start h-auto rounded-0" id="testscores">
                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">

                                            <div class="progress-fill pboxwidth">
                                                TOEFL<br>7.0 overall </div>




                                            <div class="progress-fill pboxwidth">
                                                GMAT<br>6.5 overall </div>




                                            <div class="progress-fill pboxwidth">
                                                DuoLingo<br>6.0 overall </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">

                                            <div class="progress-fill pboxwidth">
                                                LanguageCert<br>5.5 overall or below </div>




                                            <div class="progress-fill pboxwidth">
                                                SAT<br>Preparing to Appear </div>

                                        </div>
                                    </div>
                                </div> -->



                            </div>
                        </div>

                        <!-- end myacademic section -->

                    </div>

                    <div class="person-detail">
                        <h4 class="mb-3">My Information:</h4>
                        <div class="user-info">
                            <div>
                                <p><b>Email:</b><br><span class="email"></span></p>
                                <p><b>Phone:</b><br><span class="phone"></span></p>
                            </div>
                        </div>
                        <div class="study-detail">
                            <h4 class="mb-4">Details</h4>
                            <div class="detail mb-3" id="countrylist">
                                <h6 class="pb-2">Country of Interest (<a href="countryinterest.php">Edit</a>)</h6>
                            </div>

                            <div class="detail mb-3">
                                <h6 class="pb-2">My Work Experience (<a href="testscoreprofile.php">Edit</a>)</h6>
                                <span id="workexperience"></span>
                            </div>

                        </div>
                    </div>
                </section>
        </div>
    </div>
    </section>

    <?php
    require_once "partials/footer.php";
    ?>
    <script src="js/custom.js"></script>
    <script src="js/dashboard.js"></script>

</body>

</html>