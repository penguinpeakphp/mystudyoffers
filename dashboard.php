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
    <link rel="stylesheet" type="text/css" href="https://demo.mystudyoffers.com/css/font-awesome.min.css">

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

                <section class="banner-section mb-4">
                    <div class="banner-content ">
                        <small>11-Apr-2424</small>
                        <h2>Welcome back, <span class="name"></span>!</h2>
                        <p>Always stay updated in your student portal</p>

                        <div class="search-option">
                            <div>
                                <label for="exampleFormControlInput1" class="form-label"><img src="images/icons/teacher.png" />Course Search</label>
                                <div class="search-content">
                                    <a class="form-icon"><img src="images/icons/search.png" /></a>
                                    <input type="text" placeholder="Search..." name class="form-control" />
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

                <section class="sub-main">
                    <div>
                        <!-- end myacademic section -->
                        <div class="academics mb-5">
                            <div class="title mb-2">
                                <h5>My Academics</h5>
                                <a href="https://demo.mystudyoffers.com/stregi-step2">Edit</a>
                            </div>
                            <div class="education-detail">

                                <div class="mb-3">
                                    <span class="education-title">
                                        Higher Schooling > Humanities or Arts <!--<span class="border-line"></span>-->
                                        <span></span>
                                </div>
                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">
                                            <div class="progress-fill pboxwidth">Passing Year<br>2025 or later</div>
                                            <div class="progress-fill pboxwidth">Result<br>95% to 100%</div>
                                            <div class="progress-fill pboxwidth" title="CBSE">Awarding Body<br>CBSE...</div>
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <span class="education-title">
                                        Bachelor Degree > Art & Design <!--<span class="border-line"></span>-->
                                        <span></span>
                                </div>
                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">
                                            <div class="progress-fill pboxwidth">Passing Year<br>2025 or later</div>
                                            <div class="progress-fill pboxwidth">Result<br>80% to 89%</div>
                                            <div class="progress-fill pboxwidth" title="Open University (Including distance learning)">Awarding Body<br>Open University (Inc...</div>
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <span class="education-title">
                                        Masters Degree > Art & Design <!--<span class="border-line"></span>-->
                                        <span></span>
                                </div>
                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">
                                            <div class="progress-fill pboxwidth">Passing Year<br>2025 or later</div>
                                            <div class="progress-fill pboxwidth">Result<br>95% to 100%</div>
                                            <div class="progress-fill pboxwidth" title="Polytechnics, Technical Institutes">Awarding Body<br>Polytechnics, Techni...</div>
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <span class="education-title">
                                        PHd > Sciences <!--<span class="border-line"></span>-->
                                        <span></span>
                                </div>
                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">
                                            <div class="progress-fill pboxwidth">Passing Year<br>2024</div>
                                            <div class="progress-fill pboxwidth">Result<br>90% to 94%</div>
                                            <div class="progress-fill pboxwidth" title="Private University (Including deemed)">Awarding Body<br>Private University (...</div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>

                        <!-- end myacademic section -->

                        <!-- my qualification section start -->
                        <div class="academics mb-5">
                            <div class="title mb-2">
                                <h5>My Qualification</h5>
                                <a href="https://demo.mystudyoffers.com/stregi-step2?stepinfo=myacademic_dtl">Edit</a>
                            </div>
                            <div class="education-detail">
                                <div class="mb-3">
                                    <span class="education-title">
                                        Level of Qualification
                                        <!--<span class="border-line"></span>-->
                                        <span></span>
                                </div>

                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">
                                            <div class="progress-fill pboxwidth_full">Masters Degree - Course Work</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">
                                            <div class="progress-fill pboxwidth_full">PG Cert/Diploma</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Next Qualification -->
                            <div class="education-detail">
                                <div class="mb-3">
                                    <span class="education-title">
                                        Next Qualification
                                        <!--<span class="border-line"></span>-->
                                        <span></span>
                                </div>

                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">
                                            <div class="progress-fill pboxwidth_full">Business, HR, Marketing, Supply Chain</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">
                                            <div class="progress-fill pboxwidth_full">Heath Sciences</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">
                                            <div class="progress-fill pboxwidth_full">Pure Sciences - Chemistry, Biology, Physics, Math</div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!--  my qualification section -->


                        <!-- end myacademic section -->
                        <div class="academics mb-5">
                            <div class="title mb-2">
                                <h5>My Test Scores</h5>
                                <a href="https://demo.mystudyoffers.com/stregi-step2?stepinfo=nextqualification">Edit</a>
                            </div>
                            <div class="education-detail">

                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar">

                                            <div class="progress-fill pboxwidth">
                                                IELTS<br>Preparing to Appear </div>




                                            <div class="progress-fill pboxwidth">
                                                PTE<br>8.0 overall or above </div>




                                            <div class="progress-fill pboxwidth">
                                                GRE<br>7.5 overall </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="education mb-3">
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
                                </div>



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
                            <div class="detail mb-3">
                                <h6 class="pb-2">Country of Interest (<a href="https://demo.mystudyoffers.com/stregi-step2?stepinfo=workexp">Edit</a>)</h6>
                                <span># United Kingdom</span>
                                <span># Canada</span>
                                <span># USA</span>
                                <span># Australia</span>
                                <span># Europe</span>
                                <span># Other</span>
                                <span># Asia</span>
                            </div>


                            <div class="detail mb-3">
                                <h6 class="pb-2">My Work Experience (<a href="https://demo.mystudyoffers.com/stregi-step2?stepinfo=nextqualification">Edit</a>)</h6>
                                <span>4 Years or above Relevant to Studies</span>
                            </div>


                        </div>
                    </div>
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