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
                                    <button class="nav-link w-100 active tabbtn" id="tab1" data-bs-toggle="tab" data-bs-target="#section1" type="button" role="tab" aria-controls="section1" aria-selected="false" tabindex="-1">University Information</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button disabled class="nav-link w-100 tabbtn" id="tab2" data-bs-toggle="tab" data-bs-target="#section2" type="button" role="tab" aria-controls="section2" aria-selected="false" tabindex="-1">University Intellectual Assets</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button disabled class="nav-link w-100 tabbtn" id="tab3" data-bs-toggle="tab" data-bs-target="#section3" type="button" role="tab" aria-controls="section3" aria-selected="false" tabindex="-1">University Rankings</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button disabled class="nav-link w-100 tabbtn" id="tab4" data-bs-toggle="tab" data-bs-target="#section4" type="button" role="tab" aria-controls="section4" aria-selected="true">University Statistics</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button disabled class="nav-link w-100 tabbtn" id="tab5" data-bs-toggle="tab" data-bs-target="#section5" type="button" role="tab" aria-controls="section5" aria-selected="false" tabindex="-1">Tuition and Fees</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2" id="myTabjustifiedContent">
                                <div class="tab-pane fade active show" id="section1" role="tabpanel" aria-labelledby="section1">
                                    <form class="row g-3" id="universityinformationform">
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="universitystatus" name="universitystatus">
                                                <label class="form-check-label" for="universitystatus">
                                                    Active
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="universityname" class="form-label">University Name</label>
                                            <input type="text" class="form-control" id="universityname" name="universityname">
                                        </div>
                                        <div class="col-6">
                                            <label for="universityimage" class="form-label">University Image</label>
                                            <a href="javascript:void(0)" id="viewuniversityimage" class="d-none">View File</a>
                                            <a href="javascript:void(0)" id="deleteuniversityimage" class="d-none">Delete File</a>
                                            <input type="file" class="form-control" id="universityimage" name="universityimage" accept="image/jpeg, image/png">
                                        </div>
                                        <div class="col-6">
                                            <label for="universitylicensenumber" class="form-label">University License Number</label>
                                            <input type="text" class="form-control" id="universitylicensenumber" name="universitylicensenumber">
                                        </div>
                                        <div class="col-6">
                                            <label for="courselevelsoffered" class="form-label">Offered Course Levels</label>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="courselevelsdropdown" name="courselevelsdropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Course Levels
                                                </button>
                                                <div class="dropdown-menu p-2 courselevelsoffered w-100" aria-labelledby="courselevelsdropdown">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="keycontactname" class="form-label">Key Contact Name</label>
                                            <input type="text" class="form-control" id="keycontactname" name="keycontactname">
                                        </div>
                                        <div class="col-6">
                                            <label for="keycontactemail" class="form-label">Key Contact Email</label>
                                            <input type="email" class="form-control" id="keycontactemail" name="keycontactemail">
                                        </div>
                                        <div class="col-6">
                                            <label for="keycontactdesignation" class="form-label">Key Contact Designation</label>
                                            <input type="text" class="form-control" id="keycontactdesignation" name="keycontactdesignation">
                                        </div>
                                        <div class="col-6">
                                            <label for="yearestablishment" class="form-label">Year Establishment</label>
                                            <input type="number" class="form-control" id="yearestablishment" name="yearestablishment">
                                        </div>
                                        <div class="col-12">
                                            <label for="overview" class="form-label">Description/Overview</label>
                                            <textarea class="form-control" placeholder="Overview" id="overview" name="overview" rows="5"></textarea>
                                        </div>
                                        <p><b>Main Campus Details</b></p>
                                        <div class="col-12">
                                            <label for="maincampusstreetaddress" class="form-label">Street Address</label>
                                            <input type="text" class="form-control" id="maincampusstreetaddress" name="maincampusstreetaddress">
                                        </div>
                                        <div class="col-6">
                                            <label for="maincampuscity" class="form-label">City</label>
                                            <select class="form-select citylist" id="maincampuscity" name="maincampuscity" aria-label="City">
                                                <option selected="" disabled="" value="">Select City</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="maincampuspostcode" class="form-label">Post Code</label>
                                            <input type="text" class="form-control" id="maincampuspostcode" name="maincampuspostcode">
                                        </div>
                                        <div id="othercampusdetails">
                                            <p><b>Other Campus Details</b></p>
                                        </div>

                                        <button type="button" class="btn btn-primary" id="addothercampus" name="addothercampus">Add Another Campus</button>

                                        <div id="othercampustemplate" class="othercampus d-none">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row align-items-center justify-content-between">

                                                        <label class="form-label col-auto">
                                                            Street Address
                                                        </label>
                                                        <button type="button" class="btn me-3 mb-2 col-auto ms-auto btn-danger btn-sm removeothercampus">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                    <input name="othercampusstreetaddress" type="text" class="form-control othercampusstreetaddress">
                                                </div>
                                                <div class="col-6">
                                                    <label class="form-label">City</label>
                                                    <select name="othercampuscity" class="form-select othercampuscity" aria-label="City">
                                                        <option selected="" disabled="" value="">Select City</option>
                                                    </select>
                                                </div>
                                                <div class="col-6 mb-2">
                                                    <label class="form-label">Post Code</label>
                                                    <input type="text" class="form-control othercampuspostcode" name="othercampuspostcode">
                                                </div>
                                            </div>
                                            <hr>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary" id="universityinfobtn">Add</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="section2" role="tabpanel" aria-labelledby="section2">
                                    <form class="row g-3" id="universityintellectualassets">
                                        <div class="col-6">
                                            <label for="logoimage" class="form-label">Logo Image</label>
                                            <a href="javascript:void(0)" id="viewlogoimage" class="d-none">View File</a>
                                            <a href="javascript:void(0)" id="deletelogoimage" class="d-none">Delete File</a>
                                            <input type="file" class="form-control" id="logoimage" accept="image/jpeg, image/png">
                                        </div>
                                        <div class="col-6">
                                            <label for="mascotimage" class="form-label">Mascot Image</label>
                                            <a href="javascript:void(0)" id="viewmascotimage" class="d-none">View File</a>
                                            <a href="javascript:void(0)" id="deletemascotimage" class="d-none">Delete File</a>
                                            <input type="file" class="form-control" id="mascotimage" accept="image/jpeg, image/png">
                                        </div>
                                        <div id="otherteamsandclubslist">
                                            <p><b>Other Teams and Clubs</b></p>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <button type="button" class="btn btn-primary" id="addteamsandclubs">Add Teams and Clubs</button>
                                        </div>
                                        <div id="otherteamsandclubstemplate" class="d-none row mb-2">
                                            <div class="col-11">
                                                <input type="text" class="form-control otherteamsandclubs" name="otherteamsandclubs">
                                            </div>
                                            <div class="col-1">
                                                <button type="button" class="btn btn-danger btn-sm removeteamsandclubs">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="facilityimageslist">
                                            <p><b>Facility Images</b></p>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <button type="button" class="btn btn-primary" id="addfacilityimages">Add Facility Image</button>
                                        </div>
                                        <div id="facilityimagestemplate" class="d-none row mb-2">
                                            <div class="col-11">
                                                <a href="javascript:void(0)" class="d-none viewfacilityimage"></a>
                                                <a href="javascript:void(0)" class="d-none deletefacilityimage">Delete File</a>
                                                <input type="file" class="form-control facilityimages" name="facilityimages" accept="image/jpeg, image/png">
                                            </div>
                                            <div class="col-1">
                                                <button type="button" class="btn btn-danger btn-sm removefacilityimages">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="section3" role="tabpanel" aria-labelledby="section3">
                                    <form id="universityrankings">
                                        <div class="row my-3">
                                            <label class="col-sm-2 col-form-label">Accreditation Status</label>
                                            <div class="col-sm-10">
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="accreditationstatus" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Accreditation Status
                                                    </button>
                                                    <div class="dropdown-menu p-2 accreditationstatus w-100" aria-labelledby="accreditationstatus">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Name of Ranking, Rank Awarding Body, Year of Ranking, Description -->
                                        <div id="otherrankingslist">
                                            <p><b>Rankings</b></p>
                                        </div>
                                        <div class="row d-none otherrankings" id="otherrankingstemplate">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="col-auto">
                                                        <label for="nameofranking" class="form-label">Name of Ranking</label>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-danger btn-sm mb-3 removeotherranking">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <input type="text" class="form-control" name="nameofranking">
                                            </div>
                                            <div class="col-6 my-2">
                                                <label for="rankawardingbody" class="form-label">Rank Awarding Body</label>
                                                <select class="form-select rankawardingbodylist" aria-label="Default select" name="rankawardingbodies">
                                                </select>
                                            </div>
                                            <div class="col-6 my-2">
                                                <label for="yearofranking" class="form-label">Year of Ranking</label>
                                                <input type="text" class="form-control" name="yearofranking">
                                            </div>
                                            <div class="col-12 my-2">
                                                <label for="description" class="form-label mb-3">Description</label>
                                                <textarea class="form-control" name="description"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <button type="button" class="btn btn-primary" id="addotherrankings">Add Ranking</button>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="section4" role="tabpanel" aria-labelledby="section4">
                                    <form class="row g-3" id="universitystatistics">
                                        <div class="col-6">
                                            <label for="totalstudents" class="form-label">Total Students</label>
                                            <input type="number" class="form-control" id="totalstudents">
                                        </div>
                                        <div class="col-6">
                                            <label for="totalinternationalstudents" class="form-label">Total International Students</label>
                                            <input type="number" class="form-control" id="totalinternationalstudents">
                                        </div>
                                        <div class="col-6">
                                            <label for="acceptancerate" class="form-label">Acceptance Rate</label>
                                            <input type="number" class="form-control" id="acceptancerate" step="any">
                                        </div>
                                        <div class="col-6">
                                            <label for="graduateemploymentrate" class="form-label">Graduate Employment Rate</label>
                                            <input type="number" class="form-control" id="graduateemploymentrate" step="any">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Add</button>
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
                                            <input type="text" class="form-control" id="tuitionfee">
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
                                            <button type="submit" class="btn btn-primary">Add</button>
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
<?php
if (isset($_GET["edit"]) && isset($_GET["view"])) {
?>
    <script src="viewuniversity.js"></script>
    <script src="adduniversity.js"></script>
<?php
} else if (isset($_GET["view"])) {
?>
    <script src="viewuniversity.js"></script>
<?php
} else {
?>
    <script src="adduniversity.js"></script>
<?php
}
?>

</html>