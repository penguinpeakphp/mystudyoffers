<?php
require_once "controllers/functions/globalfunctions.php";

checksession();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Profile - My Study Offers</title>
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
                        <h3>Edit Profile</h3>
                        <form class="register_form" id="editprofile">
                            <div class="row">
                                  <div class="col-lg-12">
                                    <div class="form-col text-center">
                                        <label for="editprofilepic">Edit Profile Picture</label>
                                        <label class="profile-img edit-profile-img"> 
                                            <img src="images/user.png">
                                            <input type="file" name="editprofilepic" id="editprofilepic">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-col">
                                        <label for="editname">Name</label>
                                        <input type="text" name="editname" id="editname">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-col">
                                        <label for="editsurname">Surname</label>
                                        <input type="text" name="editsurname" id="editsurname">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-col">
                                        <label for="editphone">Phone</label>
                                        <input type="number" name="editphone" id="editphone">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-col">
                                        <label for="editemail">Email</label>
                                        <input type="email" name="editemail" id="editemail">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-col">
                                        <label for="editpincode">Pincode</label>
                                        <input type="text" name="editpincode" id="editpincode">
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
        <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
        <script src="js/editprofile.js"></script>

</body>

</html>