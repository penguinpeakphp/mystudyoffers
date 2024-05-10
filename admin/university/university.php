<?php
require_once "../controllers/globalfunctions.php";

checksession();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>University</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>
    <?php
    require_once "../partials/header.php";
    require_once "../partials/sidebar.php";
    ?>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>University</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item active">University</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">University</h5>

                            <!-- Default Tabs -->
                            <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100 active" id="tab1" data-bs-toggle="tab" data-bs-target="#section1" type="button" role="tab" aria-controls="section1" aria-selected="false" tabindex="-1">University Information</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="tab2" data-bs-toggle="tab" data-bs-target="#section2" type="button" role="tab" aria-controls="section2" aria-selected="false" tabindex="-1">University Intellectual Assets</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="tab4" data-bs-toggle="tab" data-bs-target="#section4" type="button" role="tab" aria-controls="section4" aria-selected="true">University Statistics</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="tab5" data-bs-toggle="tab" data-bs-target="#section5" type="button" role="tab" aria-controls="section5" aria-selected="false" tabindex="-1">Tuition and Fees</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2" id="myTabjustifiedContent">
                                <div class="tab-pane fade active show" id="section1" role="tabpanel" aria-labelledby="section1">
                                    <form class="row g-3" id="universityinformationform">
                                        <div class="col-6">
                                            <label for="universityname" class="form-label">University Name</label> 
                                            <input type="text" class="form-control" id="universityname">
                                        </div>
                                        <div class="col-6">
                                            <label for="universityimage" class="form-label">University Image</label> 
                                            <input type="file" class="form-control" id="universityimage">
                                        </div>
                                        <div class="col-6">
                                            <label for="universitylicensenumber" class="form-label">University License Number</label>
                                            <input type="text" class="form-control" id="universitylicensenumber">
                                        </div>
                                        <div class="col-6">
                                            <label for="courselevelsoffered" class="form-label">Offered Course Levels</label>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="courselevelsdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Course Levels
                                                </button>
                                                    <div class="dropdown-menu p-2 courselevelsoffered w-100" aria-labelledby="courselevelsdropdown">
                                                        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="keycontactname" class="form-label">Key Contact Name</label>
                                            <input type="text" class="form-control" id="keycontactname">
                                        </div>
                                        <div class="col-6">
                                            <label for="keycontactemail" class="form-label">Key Contact Email</label>
                                            <input type="email" class="form-control" id="keycontactemail">
                                        </div>
                                        <div class="col-6">
                                            <label for="keycontactdesignation" class="form-label">Key Contact Designation</label>
                                            <input type="text" class="form-control" id="keycontactdesignation">
                                        </div>
                                        <div class="col-6">
                                            <label for="yearestablishment" class="form-label">Year Establishment</label>
                                            <input type="number" class="form-control" id="yearestablishment">
                                        </div>
                                        <div class="col-12">
                                            <label for="overview" class="form-label">Description/Overview</label>
                                            <textarea class="form-control" placeholder="Overview" id="overview" rows="5"></textarea>
                                        </div>
                                        <p><b>Main Campus Details</b></p>
                                        <div class="col-12">
                                            <label for="maincampusstreetaddress" class="form-label">Street Address</label>
                                            <input type="text" class="form-control" id="maincampusstreetaddress">
                                        </div>
                                        <div class="col-6">
                                            <label for="maincampuscity" class="form-label">City</label>
                                            <select class="form-select citylist" id="maincampuscity" aria-label="City">
                                                <option selected="" disabled="" value="">Select City</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="maincampuspostcode" class="form-label">Post Code</label>
                                            <input type="text" class="form-control" id="maincampuspostcode">
                                        </div>
                                        <div id="othercampusdetails">
                                            <p><b>Other Campus Details</b></p>
                                        </div>

                                        <button type="button" class="btn btn-primary" id="addothercampus">Add Another Campus</button>

                                        <div id="othercampustemplate" class="othercampus d-none">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="othercampusstreetaddress" class="form-label">Street Address</label>
                                                    <input id="othercampusstreetaddress" type="text" class="form-control othercampusstreetaddress">
                                                </div>
                                                <div class="col-6">
                                                    <label for="othercampuscity" class="form-label">City</label>
                                                    <select id="othercampuscity" class="form-select othercampuscity" aria-label="City">
                                                        <option selected="" disabled="" value="">Select City</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <label for="othercampuspostcode" class="form-label">Post Code</label>
                                                    <input type="text" class="form-control othercampuspostcode" id="othercampuspostcode">
                                                </div>
                                                <div class="col-12 text-right">
                                                    <button type="button" class="btn btn-danger removeothercampus">Remove</button>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade active show" id="section2" role="tabpanel" aria-labelledby="section2">
                                    <form class="row g-3" id="universityintellectualassets">
                                        <div class="col-6">
                                            <label for="logoimage" class="form-label">Logo Image</label> 
                                            <input type="file" class="form-control" id="logoimage">
                                        </div>
                                        <div class="col-6">
                                            <label for="mascotimage" class="form-label">Mascot Image</label> 
                                            <input type="file" class="form-control" id="mascotimage">
                                        </div>
                                        <div id="otherteamsandclubslist">
                                            <div id="otherteamsandclubstemplate" class="d-none">
                                                <div class="col-12">
                                                    <label for="otherteamsandclubs" class="form-label">Other Teams and Clubs</label>
                                                    <input type="text" class="form-control otherteamsandclubs">
                                                </div>
                                                <div class="col-4 mt-3">
                                                    <button type="button" class="btn btn-danger removeteamsandclubs">Remove Team/Club</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <button type="button" class="btn btn-primary" id="addteamsandclubs">Add Teams and Clubs</button>
                                        </div>
                                        <div id="facilityimageslist">
                                            <div id="facilityimagestemplate" class="d-none">
                                                <div class="col-6">
                                                    <label for="facilityimages" class="form-label">Facility Images</label>
                                                    <input type="file" class="form-control facilityimages">
                                                </div>
                                                <div class="col-4 mt-3">
                                                    <button type="button" class="btn btn-danger removefacilityimages">Remove Facility Image</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <button type="button" class="btn btn-primary" id="addfacilityimages">Add Facility Image</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="section4" role="tabpanel" aria-labelledby="section4">
                                    <form class="row g-3" id="universitystatistics">
                                        <div class="col-6">
                                            <label for="totalstudents" class="form-label">Total Students</label> 
                                            <input type="text" class="form-control" id="totalstudents">
                                        </div>
                                        <div class="col-6">
                                            <label for="totalinternationstudents" class="form-label">Total International Students</label> 
                                            <input type="text" class="form-control" id="totalinternationstudents">
                                        </div>
                                        <div class="col-6">
                                            <label for="acceptancerate" class="form-label">Acceptance Rate</label> 
                                            <input type="text" class="form-control" id="acceptancerate">
                                        </div>
                                        <div class="col-6">
                                            <label for="graduateemploymentrate" class="form-label">Graduate Employment Rate</label> 
                                            <input type="text" class="form-control" id="graduateemploymentrate">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="section5" role="tabpanel" aria-labelledby="section5">
                                    <form class="row g-3" id="tuitionandfees">
                                        <div class="col-6">
                                            <label for="applicationfee" class="form-label">Application Fee</label> 
                                            <input type="text" class="form-control" id="applicationfee">
                                        </div>
                                        <div class="col-6">
                                            <label for="tuitionfee" class="form-label">Tuition Fee</label> 
                                            <input type="number" class="form-control" id="tuitionfee">
                                        </div>
                                        <div class="col-6">
                                            <label for="otherfees" class="form-label">Other Fees</label>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="otherfeesdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Other Fees
                                                </button>
                                                    <div class="dropdown-menu p-2 otherfees w-100" aria-labelledby="otherfeesdropdown">
                                                        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="financialaid" class="form-label">Financial Aid</label>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="financialaiddropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Financial Aid
                                                </button>
                                                    <div class="dropdown-menu p-2 financialaid w-100" aria-labelledby="financialaiddropdown">
                                                        
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- End Default Tabs -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
    <?php
    require_once "../partials/footer.php";
    ?>
</body>

<script src="../assets/js/utils.js"></script>
<script src="university.js"></script>

</html>