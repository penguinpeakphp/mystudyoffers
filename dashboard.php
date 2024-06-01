<?php
require_once "controllers/functions/globalfunctions.php";
require_once "admin/database/db.php";

checksession();
if (isset($_SESSION["studentid"])) {
    $result = $db->query("SELECT profilestatus FROM student where studentid = " . $_SESSION["studentid"]);
    $url = "";
    $row = $result->fetch_assoc();
    if ($row["profilestatus"] == "academic") {
        $url = "academicprofile1.php";
    }
    if ($row["profilestatus"] == "qualification") {
        $url = "qualificationprofile.php";
    }
    if ($row["profilestatus"] == "testscore") {
        $url = "testscoreprofile.php";
    }
    if ($row["profilestatus"] == "countryinterest") {
        $url = "countryinterest.php";
    }
    if($url != "")
    {
        header("Location: " . $url);
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - My Study Offers</title>
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
                    <div class="banner-section mb-4">
                        <div class="banner-content ">
                            <h2>Welcome back, <?= $_SESSION['name'] ?>!</h2>
                            <p>Always stay updated in your student portal</p>
                            <h5>My Timeline</h5>
                            <div class="progress-container">
                                <div class="my-progress-bar">
                                    <label class="step">
                                        <input type="radio" name="progress" value="1">
                                        <span class="circle">✔</span>
                                        <span class="label">Text 1</span>
                                    </label>
                                    <label class="step">
                                        <input type="radio" name="progress" value="2">
                                        <span class="circle">✔</span>
                                        <span class="label">Text 2</span>
                                    </label>
                                    <label class="step">
                                        <input type="radio" name="progress" value="3">
                                        <span class="circle">✔</span>
                                        <span class="label">Text 3</span>
                                    </label>
                                    <label class="step">
                                        <input type="radio" name="progress" value="4">
                                        <span class="circle">✔</span>
                                        <span class="label">Text 4</span>
                                    </label>
                                    <label class="step">
                                        <input type="radio" name="progress" value="5">
                                        <span class="circle">✔</span>
                                        <span class="label">Text 5</span>
                                    </label>
                                    <label class="step">
                                        <input type="radio" name="progress" value="6">
                                        <span class="circle">✔</span>
                                        <span class="label">Text 6</span>
                                    </label>
                                    <label class="step">
                                        <input type="radio" name="progress" value="7">
                                        <span class="circle">✔</span>
                                        <span class="label">Text 7</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        </section>
                    </div>

                    <div class="row">
                        <div class="warning-banner mb-4">
                            <div class="warning-info">
                                <h4>Please Verify your Phone Number with OTP</h4>
                                <a href="javascript:void(0)" id="sendotp" class="info-btn">Send OTP</a>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="detail">
                                <div class="course-suggestion-detail mb-3 d-none">
                                    <div class="course-title">
                                        <h5>Course Suggestions</h5>
                                        <a href="">Edit</a>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <div class="course-info">
                                                <div class="course-imgconatainer">
                                                    <img src="images/ms_imgs/course-suggest.jpg" class="img-fluid">
                                                </div>
                                                <div class="course-detail">
                                                    <h3>Programming with HTML, JavaScript, PHP</h3>
                                                    <div class="course-prize">
                                                        <h4>$32.00</h4>
                                                        <img src="images/ms_imgs/canada.jpg" class="img-fluid" style="height: 25px;width: auto;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="course-info">
                                                <div class="course-imgconatainer">
                                                    <img src="images/ms_imgs/course-suggest.jpg" class="img-fluid">
                                                </div>
                                                <div class="course-detail">
                                                    <h3>Programming with HTML, JavaScript, PHP</h3>
                                                    <div class="course-prize">
                                                        <h4>$32.00</h4>
                                                        <img src="images/ms_imgs/canada.jpg" class="img-fluid" style="height: 25px;width: auto;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="course-info">
                                                <div class="course-imgconatainer">
                                                    <img src="images/ms_imgs/course-suggest.jpg" class="img-fluid">
                                                </div>
                                                <div class="course-detail">
                                                    <h3>Programming with HTML, JavaScript, PHP</h3>
                                                    <div class="course-prize">
                                                        <h4>$32.00</h4>
                                                        <img src="images/ms_imgs/canada.jpg" class="img-fluid" style="height: 25px;width: auto;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="course-info">
                                                <div class="course-imgconatainer">
                                                    <img src="images/ms_imgs/course-suggest.jpg" class="img-fluid">
                                                </div>
                                                <div class="course-detail">
                                                    <h3>Programming with HTML, JavaScript, PHP</h3>
                                                    <div class="course-prize">
                                                        <h4>$32.00</h4>
                                                        <img src="images/ms_imgs/canada.jpg" class="img-fluid" style="height: 25px;width: auto;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="education-detail mb-3">
                                    <div class="accordions">
                                        <div class="accordion-item">
                                            <div class="accordion-title" data-tab="academicdetail">
                                                <h2>My Accademics<i class='bx bx-chevron-down'></i></h2>
                                            </div>
                                            <div class="accordion-content " id="academicdetail" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <div class="accordion-title" data-tab="qualificationlevel">
                                                <h2>My Qualification<i class='bx bx-chevron-down'></i></h2>
                                            </div>
                                            <div class="accordion-content " id="qualificationlevel" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <div class="accordion-title" data-tab="nextqualification">
                                                <h2>My Next Qualification<i class='bx bx-chevron-down'></i></h2>
                                            </div>
                                            <div class="accordion-content " id="nextqualification" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <div class="accordion-title" data-tab="testscores">
                                                <h2>My Test Scores<i class='bx bx-chevron-down'></i></h2>
                                            </div>
                                            <div class="accordion-content " id="testscores" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <div class="accordion-title" data-tab="item3">
                                                <h2>My Document<i class='bx bx-chevron-down'></i></h2>
                                            </div>
                                            <div class="accordion-content " id="item3" style="display: none;">
                                                <div class="according-text">
                                                    <h5> Coming Soon </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <div class="accordion-title" data-tab="item4">
                                                <h2>My Future Plan<i class='bx bx-chevron-down'></i></h2>
                                            </div>
                                            <div class="accordion-content " id="item4" style="display: none;">
                                                <div class="according-text">
                                                    <h5> Coming Soon </h5>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
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
                                <div class="personal-info mb-3">
                                    <h3>My Information</h3>
                                    <div class="detail mb-2">
                                        <h6>Name:</h6>
                                        <span class="name"></span>
                                    </div>
                                    <div class="detail mb-2">
                                        <h6>Email:</h6>
                                        <span class="email"></span>
                                    </div>
                                    <div class="detail mb-2">
                                        <h6>Phone:</h6>
                                        <span class="phone"></span>
                                    </div>
                                </div>
                                <div class="destination-info mb-3">
                                    <h3>Destination</h3>
                                    <div class="coutry-info">
                                        <div class="country-name">
                                            <img src="images/ms_imgs/india.jpg" class="img-fluid">
                                            <h5>In</h5>
                                        </div>
                                        <div class="country-name">
                                            <img src="images/ms_imgs/canada.jpg" class="img-fluid">
                                            <h5>can</h5>
                                        </div>
                                        <div class="country-name">
                                            <img src="images/ms_imgs/australia.jpg" class="img-fluid">
                                            <h5>Aus</h5>
                                        </div>
                                    </div>

                                </div>
                                <div class="application-info mb-3 d-none">
                                    <h3>Application's</h3>
                                    <ul class="applications">
                                        <li>
                                            <div class="application-name">
                                                <div class="d-flex flex-column">
                                                    <h5>Lorem Ipsum is simply dummy text of the printing...</h5>
                                                    <span> <i class="fa-solid fa-calendar-days"></i>10/05/2024 - 10:30AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="application-name">
                                                <div class="d-flex flex-column">
                                                    <h5>Lorem Ipsum is simply dummy text of the printing...</h5>
                                                    <span> <i class="fa-solid fa-calendar-days"></i>10/05/2024 - 10:30AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="application-name">
                                                <div class="d-flex flex-column">
                                                    <h5>Lorem Ipsum is simply dummy text of the printing...</h5>
                                                    <span> <i class="fa-solid fa-calendar-days"></i>10/05/2024 - 10:30AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="application-name">
                                                <div class="d-flex flex-column">
                                                    <h5>Lorem Ipsum is simply dummy text of the printing...</h5>
                                                    <span> <i class="fa-solid fa-calendar-days"></i>10/05/2024 - 10:30AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="application-name">
                                                <div class="d-flex flex-column">
                                                    <h5>Lorem Ipsum is simply dummy text of the printing...</h5>
                                                    <span> <i class="fa-solid fa-calendar-days"></i>10/05/2024 - 10:30AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="application-name">
                                                <div class="d-flex flex-column">
                                                    <h5>Lorem Ipsum is simply dummy text of the printing...</h5>
                                                    <span> <i class="fa-solid fa-calendar-days"></i>10/05/2024 - 10:30AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="application-name">
                                                <div class="d-flex flex-column">
                                                    <h5>Lorem Ipsum is simply dummy text of the printing...</h5>
                                                    <span> <i class="fa-solid fa-calendar-days"></i>10/05/2024 - 10:30AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="application-name">
                                                <div class="d-flex flex-column">
                                                    <h5>Lorem Ipsum is simply dummy text of the printing...</h5>
                                                    <span> <i class="fa-solid fa-calendar-days"></i>10/05/2024 - 10:30AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="application-name">
                                                <div class="d-flex flex-column">
                                                    <h5>Lorem Ipsum is simply dummy text of the printing...</h5>
                                                    <span> <i class="fa-solid fa-calendar-days"></i>10/05/2024 - 10:30AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="application-name">
                                                <div class="d-flex flex-column">
                                                    <h5>Lorem Ipsum is simply dummy text of the printing...</h5>
                                                    <span> <i class="fa-solid fa-calendar-days"></i>10/05/2024 - 10:30AM</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="application-name">
                                                <div class="d-flex flex-column">
                                                    <h5>Lorem Ipsum is simply dummy text of the printing...</h5>
                                                    <span> <i class="fa-solid fa-calendar-days"></i>10/05/2024 - 10:30AM</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                                <div class="travel-bookcontainer mb-3">
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
        <script>
            $(document).ready(function() {
                // Ensure the first accordion item is open by default
                $('.accordion-item:first-child .accordion-content').show();

                $(".accordion-title").click(function() {
                    var accordionItem = $(this).attr("data-tab");
                    $("#" + accordionItem)
                        .slideToggle()
                        .toggleClass("active")
                        .parent()
                        .siblings()
                        .find(".accordion-content")
                        .slideUp()
                        .removeClass("active");
                    $(this).toggleClass("active-title");
                    $("#" + accordionItem)
                        .parent()
                        .siblings()
                        .find(".accordion-title")
                        .removeClass("active-title");
                });
            });
        </script>
        <script src="js/dashboard.js"></script>

</body>

</html>