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

    <!--fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

    <title>Mystudyoffers.com</title>
</head>

<body>
    <?php
        require_once "partials/header.php";
    ?>
    <section class="main-slider">
        <div class="container">
            <div id="sync1" class="owl-carousel owl-theme">
                <div class="item">
                    <div class="slider-cont">
                        <div class="row">
                            <div class="col-sm-6 txt">
                                <h2>Study Abroad</h2>
                                <h4>Bachelor / Master / PHD</h4>
                                <h4>Get the best counselling from the world finest mentors</h4>
                                <p>
                                    <span>Experience our simplified Tap to Apply Tool</span>
                                </p>
                                <a class="slider-btn registerbutton">Tap To Apply</a>
                            </div>
                            <div class="col-sm-6 slider-img-sec d-sm-block d-none">
                                <!-- <span class="save">
                  <p>Student Profilling<br>
                  Admission Essays<br>
                    Scholarships</p>-->
                                </span>
                                <span class="pottan-img">
                                    <img src="images/pottan-img.png" alt="">
                                </span>
                                <span class="slider-icon">
                                    <img src="images/slider-icon.png" alt="">
                                </span>
                                <span class="slider-img">
                                    <img src="images/ban1.png" alt="">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div id="sync2" class="owl-carousel owl-theme">
                <div class="item">
                    <div class="slide slide1">
                        <h5>Options of 2000+<br>Top Universities Globally</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="slide slide2">
                        <h5>Quick Admission <br>
                            Applications</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="slide slide4">
                        <h5>Avail Education <br>
                            Loan at Affordable Rate</h5>
                    </div>
                </div>

                <div class="item">
                    <div class="slide slide3">
                        <h5>Accurate <br>
                            Visa Applications</h5>
                    </div>
                </div>
                <div class="item">
                    <div class="slide slide5">
                        <h5>Extra Mile <br>
                            Post Landing Support</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="topchoice-sec">
        <div class="container">
            <h3>Top Choice Countries</h3>
            <p>Choose your dream destination from the world's finest education providers for international students</p>
            <div class="topchoice-slider">
                <div id="carousel_topchoice" class="owl-carousel">
                    <div class="item">
                        <div class="topchoice-col">
                            <img src="images/topchoice-img1.png" alt="">
                            <h5>USA</h5>
                            <h6>1200+ Universities</h6>
                            Huge Scholarships<br>
                            <span>Upto 3 Years of STEM WP</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="topchoice-col">
                            <img src="images/topchoice-img2.png" alt="">
                            <h5>UK</h5>
                            <h6>150+ Universities</h6>
                            Affordable Tuition Fee<br>
                            <span>Upto 3 Years of PGWP</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="topchoice-col">
                            <img src="images/topchoice-img3.png" alt="">
                            <h5>Canada</h5>
                            <h6>200+ Universities</h6>
                            Affordable Tuition Fee<br>
                            <span>Upto 3 Years of PGWP</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="topchoice-col">
                            <img src="images/australia.jpg" alt="">
                            <h5>Australia</h5>
                            <h6>50+ Universities</h6>
                            Affordable Tuition Fee<br>
                            <span>Upto 5 Years of PGWP</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="topchoice-col">
                            <img src="images/europe.jpg" alt="">
                            <h5>Europe</h5>
                            <h6>800+ Universities</h6>
                            Zero Tuition Fee Options<br>
                            <span>Upto 5 Years of PGWP</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="topchoice-col">
                            <img src="images/nz.jpg" alt="">
                            <h5>New Zealand</h5>
                            <h6>30+ Universities</h6>
                            Affordable Tuition Fee<br>
                            <span>Upto 3 Years of PGWP</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="topchoice-col">
                            <img src="images/bharat.jpg" alt="">
                            <h5>Bharat</h5>
                            <h6>1100+ Universities & Colleges</h6>
                            Competitive Tuition Fee<br>
                            <span>Affordable Living Cost</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="weprovide-sec">
        <div class="container">
            <div class="weprovide-col">
                <div class="row">
                    <div class="col-12 col-md-6 txt">
                        <span>
                            <h3>Book a Discovery Session with Our Expert Mentors</h3>
                            <p>Our mentors will guide you through a complex journey of securing admission in to top higher education destinations globally, be it at UG level or PG level. MyStudyOffers mentors are internationally qualified and experienced from the prestigious universities globally.</p>
                            <a class="main-btn">Book a Session</a>
                        </span>
                    </div>
                    <div class="col-12 col-md-6">
                        <img src="images/expert-mentors.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="apply_Universities">
        <div class="container">
            <h3>Choose from Featured Universities Globally</h3>
            <p>Be your choice is top ranking or prestigious, affordable or funded programs, upgrading your profile or changing the career, mystudyoffers has all for you.</p>
            <nav>
                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">USA</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">UK</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Canada</button>
                </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div id="owl-usa" class="owl-carousel">
                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/umass-boston.jpg" alt="">
                                <h5>UMass Bostons</h5>
                                <h6>USA</h6>
                                Range of UG & PG Programs <br>
                                <span>Scholarships upto 6000 USD</span>
                            </div>
                        </div>
                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/upacific-usa.jpg" alt="">
                                <h5>University of Pacific</h5>
                                <h6>USA</h6>
                                Range of UG & PG Programs<br>
                                <span>Scholarships upto 30000 USD</span>
                            </div>
                        </div>
                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/udayton-usa.jpg" alt="">
                                <h5>University of Dayton</h5>
                                <h6>USA</h6>
                                Range of UG & PG Programs<br>
                                <span>Scholarships upto 25000 USD</span>
                            </div>
                        </div>
                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/uic-usa.jpg" alt="">
                                <h5>University of Illinois</h5>
                                <h6>USA</h6>
                                Range of UG & PG Programs<br>
                                <span>Scholarships upto 10000 USD</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div id="owl-uk" class="owl-carousel">
                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/queeem-mary-london.jpg" alt="">
                                <h5>Queen Mary University London</h5>
                                <h6>UK</h6>
                                Range of UG & PG Programs<br>
                                <span>Apply Jan 2024 / Sept 2024</span>
                            </div>
                        </div>
                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/greenwich-london.jpg" alt="">
                                <h5>University of Greenwich</h5>
                                <h6>UK</h6>
                                Programs with Placement year<br>
                                <span>Apply Jan 2024 / Sept 2024</span>
                            </div>
                        </div>
                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/uheartfordshire-london.jpg" alt="">
                                <h5>University of Hertfordshire</h5>
                                <h6>UK</h6>
                                PG Programs with Placement year<br>
                                <span>Apply Jan 2024 / Sept 2024</span>
                            </div>
                        </div>

                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/middlesex-london.jpg" alt="">
                                <h5>Middlesex University London</h5>
                                <h6>UK</h6>
                                Range of UG & PG Programs<br>
                                <span>Apply Jan 2024 / Sept 2024</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div id="owl-canada" class="owl-carousel">

                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/windsor-canada.jpg" alt="">
                                <h5>University of Windsor</h5>
                                <h6>Canada</h6>
                                Range of UG & PG Programs<br>
                                <span>Apply for 2024 Intakes</span>
                            </div>
                        </div>

                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/trinity-canada.jpg" alt="">
                                <h5>Trinity Western University</h5>
                                <h6>Canada</h6>
                                Range of UG & PG Programs<br>
                                <span>Apply for 2024 Intakes</span>
                            </div>
                        </div>

                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/ucwest-canada.jpg" alt="">
                                <h5>University of Canada West</h5>
                                <h6>Canada</h6>
                                Range of UG & PG Programs<br>
                                <span>Apply for 2024 Intakes</span>
                            </div>
                        </div>

                        <div class="item">
                            <div class="topchoice-col">
                                <img src="images/toronto-metropolitan-canada.jpg" alt="">
                                <h5>Toronto Metropolitan University</h5>
                                <h6>Canada</h6>
                                Range of UG & PG Programs<br>
                                <span>Apply for 2024 Intakes</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </section>



    <section class="wehelp-sec">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Get Education Loan upto 60 Lacs, Digital Processing.</h3>
                    <p>Secured / Unsecured Options are available from India's renowned banks. Check your eligibility in minutes and get your loan sanction in days from our partnered banks.</p>
                    <a class="main-btn">Check Eligibility Now!</a>
                </div>
                <div class="col-12 col-md-6 wehelp-logo">
                    <h6>Our Associated Banks </h6>
                    <div class="row">
                        <div class="col-sm-4 col-6 border-right border-bottom">
                            <img src="images/wehelp-logo1.png" alt="">
                        </div>
                        <div class="col-sm-4 col-6 border-right border-bottom">
                            <img src="images/wehelp-logo2.png" alt="">
                        </div>
                        <div class="col-sm-4 col-6 border-bottom">
                            <img src="images/wehelp-logo3.png" alt="">
                        </div>
                        <div class="col-sm-4 col-6 border-right">
                            <img src="images/wehelp-logo4.png" alt="">
                        </div>
                        <div class="col-sm-4 col-6 border-right">
                            <img src="images/wehelp-logo5.png" alt="">
                        </div>
                        <div class="col-sm-4 col-6">
                            <img src="images/wehelp-logo6.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="howitworks-sec">
        <div class="container">
            <h3>Simplified and Transparent International Applicant Journey</h3>
            <p>Our transparent process & pro active approach with years of experience & expertise, student are assured with<br>highest chances of acceptance at admission and visa stages. Check our below how it works.</p>
            <div class="row">
                <div class="col-12 col-md-6">
                    <img src="images/application-journey.jpg" alt="">
                </div>
                <div class="col-12 col-md-6">
                    <div class="howitworks-bar">
                        <span class="icon">
                            <img src="images/hitw-ic1.png" alt="">
                        </span>
                        <div class="txt-cont">
                            <h4>Register</h4>
                            <p>Register your interest in less than 2 minutes with our Tap to Apply tool.</p>
                        </div>
                        <span class="no">
                            01
                        </span>
                    </div>
                    <div class="howitworks-bar">
                        <span class="icon">
                            <img src="images/hitw-ic2.png" alt="">
                        </span>
                        <div class="txt-cont">
                            <h4>Book a Discovery Session</h4>
                            <p>Book a Free Discovery Session of 30 minutes with our expert mentors.</p>
                        </div>
                        <span class="no">
                            02
                        </span>
                    </div>
                    <div class="howitworks-bar">
                        <span class="icon">
                            <img src="images/hitw-ic3.png" alt="">
                        </span>
                        <div class="txt-cont">
                            <h4>Decision Making</h4>
                            <p>Make a Dicision on Courses, Universities and Countries from customised list curated by our experts.
                            </p>
                        </div>
                        <span class="no">
                            03
                        </span>
                    </div>
                    <div class="howitworks-bar">
                        <span class="icon">
                            <img src="images/application.png" alt="">
                        </span>
                        <div class="txt-cont">
                            <h4>Lodge Admission Applications </h4>
                            <p>Submit required documents to create application portal and start applying.</p>
                        </div>
                        <span class="no">
                            04
                        </span>
                    </div>
                    <div class="howitworks-bar">
                        <span class="icon">
                            <img src="images/hitw-5f.png" alt="">
                        </span>
                        <div class="txt-cont">
                            <h4>Expore Funding Opportunities</h4>
                            <p>While admission applications are in process explore various funding opportunities including scholarships, education load etc. with our expert guidance.</p>
                        </div>
                        <span class="no">
                            05
                        </span>
                    </div>

                    <div class="howitworks-bar">
                        <span class="icon">
                            <img src="images/hitw-ic4.png" alt="">
                        </span>
                        <div class="txt-cont">
                            <h4>Apply for Visa</h4>
                            <p>After receiving unconditional admission, prepare and submit visa application with our expert guidance.</p>
                        </div>
                        <span class="no">
                            06
                        </span>
                    </div>

                    <div class="howitworks-bar">
                        <span class="icon">
                            <img src="images/hitw-ic5.png" alt="">
                        </span>
                        <div class="txt-cont">
                            <h4>Pre Departure & Post Landing Support</h4>
                            <p>On receipt of Visa get extended support at pre departure and post landing from our support team experts.</p>
                        </div>
                        <span class="no">
                            07
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="about-sec">
        <div class="container">
            <div class="about-col">
                <div class="row">
                    <div class="col-12 col-md-7 txt">
                        <span>
                            <h3>About Mystudyoffers.com</h3>
                            <p>Welcome to Mystudyoffers.com, a pioneering AI-powered platform that serves as the ultimate nexus
                                connecting students, universities, governments, trade departments, education agents, and more. Our
                                platform revolutionises the way individual’s access and engage with higher education opportunities
                                across
                                the globe. Through cutting-edge technology and a user-centric approach, we are dedicated to simplifying
                                the complex journey of education discovery, application, funding, accommodation, visa-related
                                formalities,
                                and collaboration.</p>
                            <a class="readmore-btn" href="about.html">Read More</a>
                        </span>
                    </div>
                    <div class="col-12 col-md-5">
                        <img class="about-img1" src="images/about-img1.png" alt="">
                        <img class="about-img2" src="images/about-img2.png" alt="">
                        <img class="about-img3" src="images/about-img3.png" alt="">
                        <img class="raund-img" src="images/raund-img.png" alt="">
                        <span class="total">
                            <span class="icon">
                                <svg width="80px" height="80px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="10" stroke="#000843" stroke-width="1.5" />
                                    <path d="M9 16C9.85038 16.6303 10.8846 17 12 17C13.1154 17 14.1496 16.6303 15 16" stroke="#000843" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M16 10.5C16 11.3284 15.5523 12 15 12C14.4477 12 14 11.3284 14 10.5C14 9.67157 14.4477 9 15 9C15.5523 9 16 9.67157 16 10.5Z" fill="#000843" />
                                    <ellipse cx="9" cy="10.5" rx="1" ry="1.5" fill="#000843" />
                                </svg>
                            </span>
                            <h6>
                                2500+
                                <span>Total Students</span>
                            </h6>
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php
        require_once "partials/footer.php";
    ?>

    <script src="js/owl.carousel.min.js"></script>
    <script src="js/index.js"></script>
</body>

</html>