<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <!-- Custom JavaScript -->
    <script src="js/search.js" type="text/javascript"></script>
    <script> signedIn = "<?php echo isset($_SESSION["username"]) ?>";</script>

    <!-- JQuery 1.12.0 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.0.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- JQuery UI -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <!-- Custom JavaScript -->
    <script src="js/search.js" type="text/javascript"></script>
    <script src="js/form.js" type="text/javascript"></script>
    <script src="js/buyDialogBoxes.js"></script>

    <!-- Custom CSS -->
    <link type="text/css" href="css/1-col-portfolio.css" rel="stylesheet">
    <link type="text/css" href="css/stylesheet.css" rel="stylesheet">

    <body>
        <?php
        // put your code here
        $signedIn = isset($_SESSION['username']);
        $active_page = $_SESSION['ACTIVE_PAGE'];
        ?>
        <!-- Navigation Bar -->
        <nav id="nav-bar" class="navbar navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="."><img class="navbar-brand" src="assets/style/icons/logo1.png" /></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left">
                        <li <?php (($active_page === "sell") ? 'class="active"' : '') ?> >
                            <a href="sell.php"><font id="nav-choice">Sell</font></a>
                        </li>
                        <li  id="nav-choice" <?php (($active_page === "help") ? 'class="active"' : '') ?> >
                            <a href="about.php"><font id="nav-choice">About</font></a>
                        </li>
                        <?php if ($active_page !== "home") { ?><li>
                                <form id="searchForm" class="navbar-form navbar-left" role="search" action="search.php" onsubmit="return validateForm()" method="GET">
                                    <div class="form-group has-feedback">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="Search for photos" type="text" name=keyword id="searchbar" value="<?php (($active_page === "search") ? $keyword : "") ?>">
                                            <div class="input-group-btn" >
                                                <button id="searchBtn" type="submit" class="btn btn-primary" ><i class="glyphicon glyphicon-search" style="color:white;"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                            <style> @media (max-width: 1200px) { body {padding-top: 300px;} } @media (max-width: 770px) { body { padding-top: 140px; } } </style><?php } ?>
                    </ul>

                    <ul class="nav navbar-nav navbar-right" style="margin-right:-25px;">
                        <?php
                        include 'db/dbHandler.php';
                        $usr_profile = dbHandler::getInstance();
                        if (!isset($_SESSION['username'])) {
                            ?>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#sign-up-modal" data-backdrop="static" data-keyboard="false"><font id="nav-choice"><span class="glyphicon glyphicon-user"></span> Register</font></a>
                            </li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#sign-in-modal" data-backdrop="static" data-keyboard="false"><font id="nav-choice"><span class="glyphicon glyphicon-log-in"></span> Sign In</font></a>
                            </li><?php } else { ?>
                            <li>
                                <a href="profile.php"><font id="nav-choice"><span class="glyphicon glyphicon-wrench"></span> Profile</font></a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><font id="nav-choice"><span class="glyphicon glyphicon-user"></span><?php echo $usr_profile->getUserInitials($_SESSION['username']); ?><span class="caret"></span></font></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="orderhistory.php">Order History</a>
                                    </li>
                                    <li>
                                        <a href="sell.php">Sell Image</a>
                                    </li>
                                    <li>
                                        <a href="manage_inventory.php">Manage Uploads</a>
                                    </li>
                                    <li>
                                        <a href="?signout=1">Sign Out</a>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- cart session
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;0&nbsp;items</a>
                        </li>
                        -->
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        <!-- End of Navigation Bar -->


        <!-- Sign In Modal -->
        <div id="sign-in-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header modal-header-style">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title"><i class="glyphicon glyphicon-user" style="float:left"></i>Account Login</h2>
                    </div>
                    <div class="modal-content-block">
                        <div class="modal-body">
                            <form action="login.php" method="POST" enctype="multipart/form-data" >
                                <div class="form-group">
                                    <input type="text" class="form-control" id="userid" name ="user" placeholder="Username" required />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="psw" name="pass" placeholder="Password" required />
                                </div>
                                <div class="form-group">
                                    <input type="button" class="btn btn-warning" data-dismiss="modal" style="float:left" value="Cancel" >
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="register-btn" type="button" class="btn btn-success" data-dismiss="modal" value="Sign Up">
                                    <input type="submit" class="btn btn-primary" name="login" style="float:right" value="Log In" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Sign In Modal -->

        <!-- Buy Dialog Boxes -->
        <div id="buy-dialog-guest" class="modal fade xlarge" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header modal-header-style">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title"><i class="glyphicon glyphicon-user" style="float:left"></i>Guest</h2>
                    </div>
                    <div class="modal-content-block">
                        <div class="modal-body" align="middle" >
                            <h3>Thank you for your interest.</h3>
                            <b><p id="selected-license">
                                    <span></span>
                                </p></b>
                            <p> Please call 1-800-PIC-POLO to complete your purchase </p>
                            <p> or <a id="sign-in-click" ><b>sign in </b></a>to take advantage of an online purchase. </p>
                            <button class="close-btn btn-primary btn-block" type="button">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="buy-dialog-user" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header modal-header-style">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title"><i class="glyphicon glyphicon-thumbs-up" style="float:left"></i>Complete</h2>
                    </div>
                    <div class="modal-content-block">
                        <div class="modal-body" align="middle" >
                            <h3>Thank you for your purchase.</h3>
                            <b><p id="selected-license">
                                    <span></span>
                                </p></b>
                            <p>The license has been added to your account.</p>
                            <button class="close-btn btn-primary btn-block" type="button">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Buy Dialog Boxes -->

        <!-- Sign Up Modal -->
        <div id="sign-up-modal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header modal-header-style">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h2 class="modal-title"><i class="glyphicon glyphicon-edit" style="float:left"></i>Register for a PicPolo Account</h2>
                    </div>
                    <div class="modal-content-block">

                        <div class="modal-body">
                            <form action="register.php#formAnchor" method="POST" enctype="multipart/form-data" id="formAnchor">
                                <div class="form-group">
                                    <input type="text" class="form-control" pattern="[a-zA-Z\s]*" oninvalid="setCustomValidity('Letters and white space only.')" onchange="try {
                                                setCustomValidity('')
                                            } catch (e) {
                                            }" id="firstname" name="firstname" placeholder="First Name" required />
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" pattern="[a-zA-Z\s]*" oninvalid="setCustomValidity('Letters and white space only.')" onchange="try {
                                                setCustomValidity('')
                                            } catch (e) {
                                            }" id="lastname" name="lastname" placeholder="Last Name" required />
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$" oninvalid="setCustomValidity('Please enter a valid email.')" onchange="try {
                                                setCustomValidity('')
                                            } catch (e) {
                                            }"  id="email" name ="email" placeholder="Email" required />
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" pattern="[a-z A-Z 0-9 \s]*" oninvalid="setCustomValidity('Letters, numbers, and white space only.')" onchange="try {
                                                setCustomValidity('')
                                            } catch (e) {
                                            }" id="userid" name ="userid" placeholder="PicPolo username" required />
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" id="psw" name="psw" placeholder="Password" required />
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" id="pswc" name="pswc" placeholder="Confirm Password" required />
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="artist" value="value1"> I am registering as an artist
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="terms" value="value2" required> By checking this box you are agreeing with our <a href="termsAndConditions.php"> Terms of Services</a>
                                </div>

                                <!--
                                <div class="form-group">
                                    <label for='userType'>Who are you?</label><br>
                                    <input type="radio" name='userType' value="artist" >&nbsp;&nbsp;Artist
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name='userType' value="buyer" >&nbsp;&nbsp;Buyer
                                </div>
                                -->

                                <div class="form-group text-right">
                                    <input type="button" class="btn btn-warning" style="float:left"  data-dismiss="modal" value="Cancel" >
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="submit" class="btn btn-primary" name ="createAcc" value="Create account" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Sign Up Modal -->
    </body>
</html>
