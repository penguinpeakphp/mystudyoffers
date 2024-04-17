<?php
require_once "controllers/functions/globalfunctions.php";

checksession();
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

    <!--fontawesome
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
    integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">-->

    <!-- font-awesome css -->
    <link rel="stylesheet" type="text/css" href="https://demo.mystudyoffers.com/css/font-awesome.min.css">

    <!-- Elmentkit Icon CSS -->
    <link rel="stylesheet" type="text/css" href="elementskit-icon-pack/assets/css/ekiticons.css">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">


    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />

    <title>Queries - MyStudyOffers</title>
</head>

<body>
    <?php
    require_once "partials/header.php";
    ?>

    <div class="container">

        <div class="content-section">
            <?php
            require_once "partials/sidebar.php";
            ?>

            <section class="main">
                <section class="header-section">
                    <?php
                    require_once "partials/headersection.php";
                    ?>
                </section>

                <section class="banner-section mb-4">
                    <div class="banner-content ">
                        <small>11-Apr-2424</small>
                        <h2>Welcome back, <span class="name"></span>!</h2>
                        <p>Always stay updated in your student portal</p>

                        <div class="search-option">
                            <div>
                                <label for="exampleFormControlInput1" class="form-label"><img src="images/icons/teacher.png" />Course Search</label>
                                <div class="search-content">
                                    <a class="form-icon"><img src="images/icons/search.png" /></a>
                                    <input type="text" placeholder="Search..." name class="form-control" />
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

                <section class="query-list">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Sr.</th>
                                <th scope="col">My Query</th>
                                <th scope="col">Last Reply</th>
                                <th scope="col">Reply</th>
                            </tr>
                        </thead>
                        <tbody id="querybody">
                            <tr>
                                <td>1.</td>
                                <td>How to create a responsive webpage?</td>
                                <td>MSO - 2024-02-21</td>
                                <td><a href="#" class="btn btn-reply">Reply</a></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>How to learn React?</td>
                                <td>Myself - 2024-02-21</td>
                                <td><a href="#" class="btn btn-reply">Reply</a></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Lorem ipsum dolor sit amet ?</td>
                                <td>MSO - 2024-02-21</td>
                                <td><a href="#" class="btn btn-reply">Reply</a></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>How to learn React?</td>
                                <td>Myself - 2024-02-21</td>
                                <td><a href="#" class="btn btn-reply">Reply</a></td>
                            </tr>
                            <tr>
                                <td>5.</td>
                                <td>Lorem ipsum dolor sit amet ?</td>
                                <td>MSO - 2024-02-21</td>
                                <td><a href="#" class="btn btn-reply">Reply</a></td>
                            </tr>
                            <tr>
                                <td>6.</td>
                                <td>How to learn React?</td>
                                <td>Myself - 2024-02-21</td>
                                <td><a href="#" class="btn btn-reply">Reply</a></td>
                            </tr>
                            <tr>
                                <td>7.</td>
                                <td>Lorem ipsum dolor sit amet ?</td>
                                <td>MSO - 2024-02-21</td>
                                <td><a href="#" class="btn btn-reply">Reply</a></td>
                            </tr>
                            <!-- Add more query items as needed -->
                        </tbody>
                    </table>
                    <!-- <nav class="float-end mt-3">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#"><i class="fadeIn animated bx bx-caret-left"></i></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="fadeIn animated bx bx-caret-right"></i></a></li>
                        </ul>
                    </nav> -->
                </section>
        </div>
    </div>
    </section>

    <?php
    require_once "partials/footer.php";
    ?>

</body>

</html>