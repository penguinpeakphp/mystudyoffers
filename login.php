<?php
if(!isset($_SESSION))
{
    session_start();
}

if(isset($_SESSION["email"]) && isset($_SESSION["name"]))
{
    header("Location: dashboard.php");
}
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


    <!-- Elmentkit Icon CSS -->
    <link rel="stylesheet" type="text/css" href="elementskit-icon-pack/assets/css/ekiticons.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">

    <title>Student Login - MyStudyOffers</title>
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
                        <h1>Student Login</h1>
                        <ul>
                            <li>
                                <a href="home.php">Home</a>
                            </li>
                            <li>Login</li>
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

                        <h2 class="login">Login</h2>

                        <div class="error-msg">
                        </div>


                        <form id="loginform">

                            <input type="email" name="email" placeholder="E-mail" required="required">

                            <input type="password" name="password" placeholder="Password" required="required">

                            <button type="submit" class="readon btn">Login</button>

                            <div class="last-password">

                                <p>Not registered? <a href="javascript:void(0)" onclick='$("#exampleModal").modal("show");' title="Student Registration"><b>Create an account</b></a></p>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


        </div>
    </section>

    <?php
    require_once "partials/footer.php";
    ?>
    <script src="js/login.js"></script>

</body>

</html>