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
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

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

                <section class="add-question">
                    <div class="container">
                        <div class="input-container mb-3">
                            <select id="querytype" name="querytype" class="form-select h-100">
                                <option value="" disabled selected>Query Type</option>
                            </select>
                            <input class="h-100" id="query" type="text" placeholder="Enter your query">
                            <button class="question-button h-100" id="askquery">Add Query</button>
                        </div>
                    </div>
                </section>
                <section class="query-list">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Sr.</th>
                                <th scope="col">My Query</th>
                                <th scope="col">Query Type</th>
                                <th scope="col">Last Reply</th>
                                <th scope="col">Reply</th>
                            </tr>
                        </thead>
                        <tbody id="querybody">
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
    <script src="js/query.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>