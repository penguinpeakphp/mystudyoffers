<?php
require_once "../controllers/globalfunctions.php";

checksession();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Test Score</title>
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
            <h1>Test Score</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Home</a></li>
                    <li class="breadcrumb-item">Masters</li>
                    <li class="breadcrumb-item active">Test Score</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-8">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Test Score List</h5>

                            <button type="button" class="btn btn-primary add"><i class="bi-plus-square"></i></button>

                            <!-- Table with stripped rows -->
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Test Score</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="testscorebody">
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                            <div class="modal fade" id="editmodal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Test Score</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="editform">
                                            <input type="hidden" id="edittestscoreid" name="edittestscoreid">
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <label for="edittestscore" class="form-label">Test Score</label>
                                                        <input type="text" class="form-control" id="edittestscore" name="edittestscore">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-10">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="edittestscorestatus" name="edittestscorestatus">
                                                            <label class="form-check-label" for="edittestscorestatus">
                                                                Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" id="editsubmit">Edit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- End Basic Modal-->

                            <div class="modal fade" id="addmodal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add Test Score</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form id="addform">
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-12">
                                                        <label for="addtestscore" class="form-label">Test Score</label>
                                                        <input type="text" class="form-control" id="addtestscore" name="addtestscore">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-sm-10">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="addtestscorestatus" name="addtestscorestatus">
                                                            <label class="form-check-label" for="addtestscorestatus">
                                                                Active
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" id="addsubmit">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- End Basic Modal-->
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

<script src="testscore.js"></script>

</html>