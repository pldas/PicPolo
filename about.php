<?php
//start php session to store information
if (session_id() === '')
    session_start();

// session variable to track current page
$_SESSION['ACTIVE_PAGE'] = "about";

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
        <div class="container push-bottom">
            <div class="col-sm-7 col-sm-offset-1 col-md-8 col-md-offset-1">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>About Pic Polo</h2>
                        <p> PicPolo is a user friendly web application that helps artists
                            license photos for others to use. PicPolo is owned by Collective Images, Inc.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <h2>About Collective Images</h2>
                        <p>
                            Collective Images, Inc. (CII) is an established media distribution company that
            manages portfolios of images and videos for their artists, and licenses them for use
            by customers.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container -->

        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>

        <!-- End of Sign In & Sign Up Modal -->
    </body>

</html>
