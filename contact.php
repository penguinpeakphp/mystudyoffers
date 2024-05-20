<?php
require_once "controllers/functions/globalfunctions.php";
if(!isset($_SESSION)){session_start();}
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="css/owl.carousel.min.css">

  <!-- Elmentkit Icon CSS -->
  <link rel="stylesheet" type="text/css" href="elementskit-icon-pack/assets/css/ekiticons.css">

  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">

  <title>Contact us - Mystudyoffers.com</title>
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
                <h1>Contact Us</h1>
                <ul>
                  <li>
                    <a href="index.html">Home</a>
                  </li>
                  <li>Contact Us</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>


  <section class="contact-page-section">
                <div class="container">
                    <div class="row align-items-lg-end align-items-center">
                        <div class="col-lg-6">
                            <div class="section-head">
                                <span class="section-sub-title ">GET IN TOUCH</span>
                                <h3 class="section-title">
                                    FOR FURTHER INFORMATION!
                                </h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="section-head">
                                <!--<p class="section-paragraph">
                                    Magnam corporis rem commodi dolore possimus varius justo litora ipsum suspendisse dignissimos. Odit, dolor, minima. Diam facilisis dignissimos metus, id delectus fuga doloribus qui, explicabo.
                                </p>-->
                            </div>
                        </div>
                    </div>
                    <div class="contact-deatil-list">
                        <div class="connection-detail-wrapper">
                            <figure class="contact-icon">
                                <i aria-hidden="true" class="icon icon-phone"></i>
                            </figure>
                            <div class="contact-info-list">
                                <h5 class="contact-list-title">PHONE</h5>
                                <ul>
                                    <li>
                                        <a href="tel:+91 6356000607 ">+91 6356000607</a>
                                    </li>                                   
                                </ul>
                            </div>
                        </div>
                        <div class="connection-detail-wrapper">
                            <figure class="contact-icon">
                                <i aria-hidden="true" class="icon icon-email"></i>
                            </figure>
                            <div class="contact-info-list">
                                <h5 class="contact-list-title">Email</h5>
                                <ul>                                   
                                    <li>
                                        <a href="mailto:admin@mystudyoffers.com">admin@mystudyoffers.com </a>
                                    </li>
                                </ul>
                            </div>
                        </div>                     
                    </div>
                    <div class="contact-form-inner">
                        <div class="col-md-10 offset-md-1">
                            <div class="contact-from-wrap">
                                <form class="contact-from row">
                                    <div class="col-sm-6">
                                        <input type="text" name="name" placeholder="Your Name..">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" name="email" placeholder="Your Email..">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="number" name="number" placeholder="Your Number..">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="subject" placeholder="Your Subject..">
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea rows="8" placeholder="Enter Message.."></textarea>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="submit" name="submit" class="slider-btn" value="SUBMIT MESSAGE">
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

  <script src="js/register.js"></script>
</body>

</html>