<?php
//start php session to store information
if (session_id() === '')
    session_start();

// session variable to track current page
$_SESSION['ACTIVE_PAGE'] = "home";
if (!isset($_COOKIE['HOME'])) {
    setcookie('HOME', filter_input(INPUT_SERVER, 'REQUEST_URI'));
}
if (isset($_SESSION['username']))
    $current_user = $_SESSION['username'];

// signout
if (isset($_SESSION['username']) && isset($_GET['signout'])) {
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
    header('Location:' . $_COOKIE['CURRENT_PAGE']);
} else {
    // save current page url to cookie for redirection during sign in or sign out.
    setcookie('CURRENT_PAGE', $_SERVER['REQUEST_URI']);
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Welcome to PicPolo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <!-- include header file -->
        <?php include 'includes/header.php'; ?>

        <!-- Page Content -->
        <div class="container push-bottom" style="margin-top:-80px">

            <!-- Carousel -->
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div id="intro-div">
                <p style="font-size:35pt; margin-bottom: 0px; margin-top: -10px;padding-left: 5px;" > Explore PicPOLO</p>
                <p style="color: white; font-size: 14pt; vertical-align: text-top; padding-left: 5px;" > License and Sell Images </p>
            </div>
               <div class="carousel-inner">
                    <div class="item active">
                        <img src="assets/style/icons/photo1.jpg" class="img-responsive">
                        <div class="container">
                            <div class="carousel-caption">
                                <form id="searchForm" action="search.php" onsubmit="return validateForm()" method="GET">
                                    <div class="form-group-lg">
                                        <div class="input-group input-group-lg">
                                            <input id="input-box" type="text" name="keyword"class="form-control" placeholder="Search Image by Title, Artist, or Description" autofocus>
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
             </div>

            <!-- Page Heading -->
            <div class="row push-top" style="margin-top:-30px; margin-left:-100px">
                <div class="col-sm-12 text-center"  >
                    <div class="col-sm-3 placeholder col-sm-offset-1">
                        <div class="well">
                            <a href="browse.php">
                                <h4>Browse</h4>
                                <img src="assets/style/icons/category.png" class="img-responsive" alt="Generic placeholder thumbnail" style="margin-top:-30px">
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-3 placeholder col-sm-offset-1" >
                        <div class="well">
                            <a href="artist.php">
                                <h4>Artist</h4>
                                <img src="assets/style/icons/artist.png" class="img-responsive" alt="Generic placeholder thumbnail" style="margin-top:-30px">
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-3 col-sm-offset-1 placeholder">
                        <div class="well">
                            <a href="gallery.php">
                                <h4>New Arrival</h4>
                                <img src="assets/style/icons/new-arrive.png" class="img-responsive" alt="Generic placeholder thumbnail" style="margin-top:-30px">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
     </div>


        <!-- /.container -->


        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>

    </body>

</html>
