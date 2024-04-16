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
                    <!--qualification section-->

                    <div class="styled-form maxwidth-100 pb-30">
                        <div class="sec-title mb-10">
                            <h4 class="title mb-10">Level of Qualification</h4>
                            <p>Select min 2 Qualifications</p>
                        </div>
                        <div class="row clearfix">
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkqualilevel2" name="chkqualilevel[]" value="2" onclick="return chkboxlengthchk('chkqualilevel[]',2);">
                                <label class="checklabel" for="chkqualilevel2" data-content="Bachelor Degree">Bachelor Degree</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkqualilevel1" name="chkqualilevel[]" value="1" onclick="return chkboxlengthchk('chkqualilevel[]',2);">
                                <label class="checklabel" for="chkqualilevel1" data-content="Foundation year, Diploma, Adv Dip.">Foundation year, Diploma, Adv Dip.</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkqualilevel4" name="chkqualilevel[]" value="4" onclick="return chkboxlengthchk('chkqualilevel[]',2);" checked>
                                <label class="checklabel" for="chkqualilevel4" data-content="Masters Degree - Course Work">Masters Degree - Course Work</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkqualilevel5" name="chkqualilevel[]" value="5" onclick="return chkboxlengthchk('chkqualilevel[]',2);">
                                <label class="checklabel" for="chkqualilevel5" data-content="Masters Degree - Research Work">Masters Degree - Research Work</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkqualilevel3" name="chkqualilevel[]" value="3" onclick="return chkboxlengthchk('chkqualilevel[]',2);" checked>
                                <label class="checklabel" for="chkqualilevel3" data-content="PG Cert/Diploma">PG Cert/Diploma</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkqualilevel6" name="chkqualilevel[]" value="6" onclick="return chkboxlengthchk('chkqualilevel[]',2);">
                                <label class="checklabel" for="chkqualilevel6" data-content="PHd">PHd</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkqualilevel7" name="chkqualilevel[]" value="7" onclick="return chkboxlengthchk('chkqualilevel[]',2);">
                                <label class="checklabel" for="chkqualilevel7" data-content="Professional Certification">Professional Certification</label>
                            </div>
                        </div>
                    </div>

                    <div class="styled-form maxwidth-100 pb-30">
                        <div class="sec-title mb-10">
                            <h4 class="title mb-10">Next Qualification</h4>
                            <p>Select min 3 Qualifications</p>
                        </div>
                        <div class="row clearfix">
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali2" name="chkquali[]" value="2" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali2" data-content="Accounting, Finance, Statestics">Accounting, Finance, Statestics</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali1" name="chkquali[]" value="1" checked onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali1" data-content="Business, HR, Marketing, Supply Chain">Business, HR, Marketing, Supply Chain</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali7" name="chkquali[]" value="7" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali7" data-content="Civil and Architecture">Civil and Architecture</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali4" name="chkquali[]" value="4" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali4" data-content="Computer, Data, Engineering & Sciences">Computer, Data, Engineering & Sciences</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali5" name="chkquali[]" value="5" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali5" data-content="Computer, Data, Engineering & Sciences">Computer, Data, Engineering & Sciences</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali16" name="chkquali[]" value="16" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali16" data-content="Creative Arts">Creative Arts</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali8" name="chkquali[]" value="8" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali8" data-content="Electronics & Electrical">Electronics & Electrical</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali15" name="chkquali[]" value="15" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali15" data-content="Fashion Design">Fashion Design</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali12" name="chkquali[]" value="12" checked onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali12" data-content="Heath Sciences">Heath Sciences</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali3" name="chkquali[]" value="3" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali3" data-content="Hotel, Hospitality, Event Mgt.">Hotel, Hospitality, Event Mgt.</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali20" name="chkquali[]" value="20" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali20" data-content="Jorunalism, Mass communication">Jorunalism, Mass communication</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali19" name="chkquali[]" value="19" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali19" data-content="Law, International studies">Law, International studies</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali18" name="chkquali[]" value="18" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali18" data-content="Liberal Arts, Literature">Liberal Arts, Literature</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali6" name="chkquali[]" value="6" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali6" data-content="Mechanical Engineering">Mechanical Engineering</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali10" name="chkquali[]" value="10" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali10" data-content="Medicine">Medicine</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali17" name="chkquali[]" value="17" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali17" data-content="Music, Drama, Theater">Music, Drama, Theater</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali9" name="chkquali[]" value="9" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali9" data-content="Nursing">Nursing</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali11" name="chkquali[]" value="11" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali11" data-content="Paramedical">Paramedical</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali13" name="chkquali[]" value="13" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali13" data-content="Pharmacy">Pharmacy</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali21" name="chkquali[]" value="21" onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali21" data-content="Psycology">Psycology</label>
                            </div>
                            <div class="formrow col-lg-6">
                                <input class="checkbox" type="checkbox" id="chkquali14" name="chkquali[]" value="14" checked onclick="return chkboxlengthchk('chkquali[]',3);">
                                <label class="checklabel" for="chkquali14" data-content="Pure Sciences - Chemistry, Biology, Physics, Math">Pure Sciences - Chemistry, Biology, Physics, Math</label>
                            </div>
                        </div>
                    </div>






                    <!--Destimation section-->


                    <div class="styled-form maxwidth-100 pt-30">

                        <div class="row clearfix">
                            <div class="form-group col-lg-4 text-center">
                                <button type="submit" class="readon btn">
                                    <span class="txt">Save & Continue</span></button>
                            </div>
                            <div class="form-group col-lg-4 text-center">
                                <a href="https://demo.mystudyoffers.com/student-dashboard">
                                    <button type="button" class="readon btn">
                                        <span class="txt">Back to Dashboard</span></button></a>
                            </div>

                            <input type="hidden" name="btnsubmit" value="submit">
                            <input type="hidden" name="hdflag" value="profileupdate">
                            <input type="hidden" name="stepinfo" value="nextqualification">
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
    <script src="js/qualification.js"></script>

</body>

</html>