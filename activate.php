<?php
  require_once "admin/database/db.php";
  $select = "SELECT activationtoken FROM student WHERE studentid = '{$_GET['id']}'";
  $result = $db->query($select);
  $row = mysqli_fetch_assoc($result);
  if($row["activationtoken"] != $_GET["token"])
  {
    echo "<center>Could not activate. Please contact for support</center>";
    exit;
  }

  $update = "UPDATE student SET status = true WHERE studentid = '{$_GET['id']}'";
  $db->query($update);
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
  <link rel="stylesheet" href="css/owl.carousel.min.css">

  <!-- Elmentkit Icon CSS -->
  <link rel="stylesheet" type="text/css" href="elementskit-icon-pack/assets/css/ekiticons.css">

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">

  <title>Thank You for Registration - MyStudyOffers</title>
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
            <h1>Registration Success</h1>
            <ul>
              <li>
                <a href="<?= $siteurl ?>">Home</a>
              </li>
              <li>Activation</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="contact-page-section">
    <div class="container">
      <div class="row align-items-lg-end align-items-center">
        <div class="col-lg-12">
          <div class="section-head">
            <span class="section-sub-title ">Account Activation</span>
            <h3 class="section-title">
              Account Created Successfully.
            </h3>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="section-head"><br>
            <p class="section-paragraph">
              Hello <b></b>, Your account is active now.
              <br><br><b><a href="<?= $siteurl ?>/login" title="Login">Login</a></b> to your account and complete your profile.
              <br><br>For any support or help connect with us on <b><a href="mailto:<?= $siteemail ?>"><?= $siteemail ?></a></b>
            </p>
          </div>
        </div>
      </div>



    </div>
  </section>

  <?php
  require_once "partials/footer.php";
  ?>
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>