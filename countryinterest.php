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
                <form id="studentregi">

                    <!--Destimation section-->
                    <div class="styled-form maxwidth-100 pb-30">
                        <div class="sec-title mb-10">
                            <h4 class="title mb-10">My Destinations</h4>
                            <p>Select min 3 Countries</p>
                        </div>
                        <div class="row clearfix">
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="checkbox" id="chkdesti15" name="chkdesti[]" value="15" checked>
                                <label class="checklabel" for="chkdesti15" data-content="Asia">Asia</label>
                            </div>
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="checkbox" id="chkdesti11" name="chkdesti[]" value="11" checked>
                                <label class="checklabel" for="chkdesti11" data-content="Australia">Australia</label>
                            </div>
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="checkbox" id="chkdesti9" name="chkdesti[]" value="9" checked>
                                <label class="checklabel" for="chkdesti9" data-content="Canada">Canada</label>
                            </div>
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="checkbox" id="chkdesti12" name="chkdesti[]" value="12" checked>
                                <label class="checklabel" for="chkdesti12" data-content="Europe">Europe</label>
                            </div>
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="checkbox" id="chkdesti14" name="chkdesti[]" value="14">
                                <label class="checklabel" for="chkdesti14" data-content="New Zealand">New Zealand</label>
                            </div>
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="checkbox" id="chkdesti13" name="chkdesti[]" value="13" checked>
                                <label class="checklabel" for="chkdesti13" data-content="Other">Other</label>
                            </div>
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="checkbox" id="chkdesti8" name="chkdesti[]" value="8" checked>
                                <label class="checklabel" for="chkdesti8" data-content="United Kingdom">United Kingdom</label>
                            </div>
                            <div class="formrow col-lg-3">
                                <input class="checkbox" type="checkbox" id="chkdesti10" name="chkdesti[]" value="10" checked>
                                <label class="checklabel" for="chkdesti10" data-content="USA">USA</label>
                            </div>
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


                </form>
            </div>
        </div>
    </section>

    <?php
        require_once "partials/footer.php";
    ?>
    <script src="js/custom.js"></script>
    <script src="js/countryinterest.js"></script>

</body>

</html>