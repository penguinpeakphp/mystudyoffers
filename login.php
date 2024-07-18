<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["email"]) && isset($_SESSION["name"])) {
    header("Location: dashboard.php");
}
?>
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

                            <div tabindex="0" role="button" aria-labelledby="button-label" id="google-login" class="nsm7Bb-HzV7m-LgbsSe mt-3 hJDwNd-SxQuSe i5vt6e-Ia7Qfc uaxL4e-RbRzK">
                                <div class="nsm7Bb-HzV7m-LgbsSe-MJoBVe"></div>
                                <div class="nsm7Bb-HzV7m-LgbsSe-bN97Pc-sM5MNb">
                                    <div class="nsm7Bb-HzV7m-LgbsSe-Bz112c">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="LgbsSe-Bz112c">
                                            <g>
                                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                                                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                                                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                                                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                                                <path fill="none" d="M0 0h48v48H0z"></path>
                                            </g>
                                        </svg>
                                    </div>
                                    <span class="nsm7Bb-HzV7m-LgbsSe-BPrWId">Continue with Google</span>
                                    <span class="L6cTce" id="button-label">Continue with Google</span>
                                </div>
                            </div>
                            <div class="pt-3"><a class="link-opacity-100 forgot-pwd" id="forgotPassword">Forgot Password ?</a></div>
                            <div class="pt-3">

                                <p class="text-center">Not registered? <a href="javascript:void(0)" onclick='$("#exampleModal").modal("show");' title="Student Registration" class="forgot-pwd">Create an account</a></p>

                            </div>


                        </form>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="forgotPasswordForm">
                    <div class="modal-body">
                        <input type="email" name="email" class="form-control" placeholder="E-mail" required="required">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    require_once "partials/footer.php";
    ?>
    <script src="js/login.js"></script>

</body>

</html>