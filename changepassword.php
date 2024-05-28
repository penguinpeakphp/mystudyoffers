<?php
require_once "controllers/functions/globalfunctions.php";

checksession();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Change Password - My Study Offers</title>
    <link rel="icon" href="images/logo-img.png" type="image/png" sizes="16x16" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/default.css" />
    <link rel="stylesheet" href="css/media.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <?php
    require_once "partials/header.php";
    ?>
    <div class="main">
        <div class="container">
            <div class="mystudy-dashboard">
                <div class="left-content">
                    <?php
                    require_once "partials/sidebar.php";
                    ?>
                </div>
                <div class="right-content">
                    <div class="header-section mb-4">
                        <?php
                        require_once "partials/headernav.php";
                        ?>
                    </div>

                    <div class="edit-profile-section">
                        <h3>Change Password</h3>
                        <form class="register_form" id="changepassword">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-col">
                                        <label for="npassword">New Password</label>
                                        <input type="password" name="npassword" id="npassword" value="" placeholder="Enter New Password">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-col">
                                        <label for="cpassword">Confirm Password</label>
                                        <input type="password" name="cpassword" id="cpassword" value="" placeholder="Enter Confirm Password">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-col mt-4">
                                        <button type="submit" class="register-btn">Update</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <?php
        require_once "partials/footer.php";
        ?>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/custom.js"></script>
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script src="js/changepassword.js"></script>

</body>

</html>