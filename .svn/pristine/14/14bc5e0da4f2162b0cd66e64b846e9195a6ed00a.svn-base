<?php
//start php session to store information
if (session_id() === '')
    session_start();

// session variable to track current page
$_SESSION['ACTIVE_PAGE'] = "privacy";

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
        <h2 style="margin-top: -80px">
            Privacy Notice
        </h2>
        <p>
            Your privacy is very important to us. Accordingly, we have developed this Policy in order for you to understand how we collect, use, communicate and disclose and make use of personal information. The following outlines our privacy policy.
        </p>

        <ul>
            <li>
                Before or at the time of collecting personal information, we will identify the purposes for which information is being collected.
            </li>
            <li>
                We will collect and use of personal information solely with the objective of fulfilling those purposes specified by us and for other compatible purposes, unless we obtain the consent of the individual concerned or as required by law.
            </li>
            <li>
                We will only retain personal information as long as necessary for the fulfillment of those purposes.
            </li>
            <li>
                We will collect personal information by lawful and fair means and, where appropriate, with the knowledge or consent of the individual concerned.
            </li>
            <li>
                Personal data should be relevant to the purposes for which it is to be used, and, to the extent necessary for those purposes, should be accurate, complete, and up-to-date.
            </li>
            <li>
                We will protect personal information by reasonable security safeguards against loss or theft, as well as unauthorized access, disclosure, copying, use or modification.
            </li>
            <li>
                We will make readily available to customers information about our policies and practices relating to the management of personal information.
            </li>
        </ul>

        <p>
            We are committed to conducting our business in accordance with these principles in order to ensure that the confidentiality of personal information is protected and maintained.
        </p>

        <!-- Header -->
        <?php include 'includes/header.php'; ?>
        <!-- /Header -->

        <!-- Body -->
        <div class="container push-bottom">

        </div>
        <!-- /Body -->

        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>
        <!-- /Footer -->

    </body>

</html>
