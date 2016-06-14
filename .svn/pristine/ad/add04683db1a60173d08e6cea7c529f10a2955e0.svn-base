<?php
//start php session to store information
if (session_id() === '')
    session_start();

// session variable to track current page
$_SESSION['ACTIVE_PAGE'] = "orderhistory";

if (isset($_SESSION['username']))
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

        <div class="container push-bottom" >
            <div class="row">
                <h2 style="margin-top: -80px">Order History</h2>
                <?php include 'includes/accountTabs.php'; ?>


                <!--<div class="col-xs-7 col-sm-7 col-sm-offset-1 col-md-8 col-md-offset-1">-->




                <div class="container ">
                    <div class="row col-xs-12">

                        <table class="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th style="width: 20%">Date Of Purchase </th>
                                    <th style="width: 20%">Title</th>
                                    <th style="width: 20%">Description</th>
                                    <th style="width: 20%">License</th>
                                    <th style="width: 20%">Price</th>
                                </tr>
                            </thead>

                        </table>
                    </div>

                    <!--
                    <div class="row col-xs-12 text-center">
                        <div class="col-xs-1 col-sm-2 label-success" style="color: white"> Date of Purchase </div>
                      <div class="col-xs-1 col-sm-1 col-sm-offset-1 label-success " style="color: white">Title</div>
                      <div class="col-xs-1 col-sm-2 col-sm-offset-1 label-success "style="color: white ">Description </div>
                  <div class="col-xs-1 col-sm-1 col-sm-offset-1 label-success " style="color: white"> License </div>
                  <div class="col-xs-1 col-sm-1 col-sm-offset-1 label-success" style="color: white"> Price </div>

                    </div> -->

                </div>


                <!--</div>-->
            </div>

        </div>

    </div>
</div>
</div>
</div>
</div>

<!-- Footer -->
<?php include 'includes/footer.php'; ?>

</body>
</html>
