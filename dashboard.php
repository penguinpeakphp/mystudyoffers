<?php
require_once "controllers/functions/globalfunctions.php";
require_once "admin/database/db.php";

session_start();
$result = $db->query("SELECT profilestatus FROM student where studentid = " . $_SESSION["studentid"]);
$url = "";
$row = $result->fetch_assoc();
if($row["profilestatus"] == "academic")
{
    $url = "academicprofile1.php";
}
if($row["profilestatus"] == "qualification")
{
    $url = "qualificationprofile.php";
}
if($row["profilestatus"] == "testscore")
{
    $url = "testscoreprofile.php";
}
if($row["profilestatus"] == "countryinterest")
{
    $url = "countryinterest.php";
}
header("Location: ".$url);

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
                    
                    <div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        <strong>My Academics</strong>
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body academics">
        <div class="according-edit"><a href="academicprofile1.php">Edit</a></div>
        <div class="education-detail" id="academicdetail">
                            </div>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
         <strong>My Qualification</strong>
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body academics">
           <div class="according-edit"><a href="qualificationprofile.php">Edit</a></div>
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
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
       <strong>My Test Scores</strong>
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body academics">
          <div class="according-edit"><a href="testscoreprofile.php">Edit</a></div>
        <div class="education-detail">

                                <div class="education mb-3">
                                    <div class="subject-row">
                                        <div class="progress-bar row justify-content-start h-auto rounded-0" id="testscores">
                                        </div>
                                    </div>
                                </div>
                                </div>
      </div>
    </div>
  </div>
</div>
                    
                    
                   

                    <div class="person-detail">
                        <h4 class="mb-3">My Information:</h4>
                        <div class="user-info">
                            <div>
                                <p><b>Email:</b><br><span class="email text-dark"></span></p>
                                <p><b>Phone:</b><br><span class="phone text-dark"></span></p>
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

    <?php require_once "partials/footer.php";?>
    <script src="js/custom.js"></script>
    <script src="js/dashboard.js"></script>

</body>

</html>