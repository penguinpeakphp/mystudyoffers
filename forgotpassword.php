<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


    <!-- Elmentkit Icon CSS -->
    <link rel="stylesheet" type="text/css" href="elementskit-icon-pack/assets/css/ekiticons.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

    <title>Change Password - MyStudyOffers</title>
</head>

<body>
    <?php
    require_once "partials/header.php";
    ?>

    <section id="page-banner" class="fxt-page-banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-area">
                        <h1>Reset Password</h1>
                        <ul>
                            <li>
                                <a href="home.php">Home</a>
                            </li>
                            <li>Reset Password</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-page-section">
        <div class="rs-login container">
            <div class="noticed">
                <div class="main-part">
                    <div class="method-account">
                        <div class="error-msg"></div>
                        <form id="forgot-password">
                            <input type="password" name="password" placeholder="Password" required="required">
                            <input type="password" name="cpassword" placeholder="Confirm Password" required="required">
                            <button type="submit" class="readon btn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    require_once "partials/footer.php";
    ?>

    <script src="js/forgotpassword.js"></script>
</body>

</html>