<?php

//start php session to store information
if (session_id() === '')
    session_start();

// session variable to track current page
$_SESSION['ACTIVE_PAGE'] = "uploadimage";

if(isset($_SESSION['username']))
    $current_user = $_SESSION['username'];


// signout
if (isset($_SESSION['username']) && isset($_GET['signout'])) {
    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();

    // redirect to home page
    header('Location: http://sfsuswe.com/~s16g02');
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
        <title>Profile</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        // put your code here


        ?>

        <!-- Header -->
        <?php include 'includes/header.php'; ?>

        <!-- Body Contents -->
        <div class="container push-bottom">
            <div class="row">
                <div class="col-sm-3 col-md-2">
                    <ul class="nav text-center" >
                        <li>
                            <div class="well">
                                <a href="profile.php" class="text-muted">
                                    <span class="glyphicon glyphicon-user" style="font-size: 500%;"></span>
                                    <p>My Profile</p>
                                </a>
                            </div>
                        </li>

                        <li>
                            <div class="well">
                                <a href="sell.php" class="text-success">
                                    <span class="glyphicon glyphicon-upload" style="font-size: 500%;"></span>
                                    <p>Sell New Image</p>
                                </a>
                            </div>
                        </li>

                        <li>
                            <div class="well">
                                <a href="manage_inventory.php" class="text-muted">
                                    <span class="glyphicon glyphicon-list" style="font-size: 500%;"></span>
                                    <p>Manage Uploads</p>
                                </a>
                            </div>
                        </li>

                         <li>
                            <div class="well">
                                <a href="orderhistory.php" class="text-muted">
                                    <span class="glyphicon glyphicon-paste" style="font-size: 500%;"></span>
                                    <p>Order History</p>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-7 col-sm-offset-1 col-md-8 col-md-offset-1">






                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>

    </body>
</html>
