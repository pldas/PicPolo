<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Contact</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="/">Pic Polo</a></li>
                        <!-- <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Image<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Illustration</a></li>
                                <li><a href="#">Photo</a></li>
                            </ul>
                        </li> -->
                        <li>
                            <a href="login.php">Sell</a>
                        </li>
                        <li>
                            <a href="#">Help</a>
                        </li>
                        <!-- <li>
                            <a href="about.html">About</a>
                        </li> -->
                        <li>
                            <form class="navbar-form navbar-left" role="search" onsubmit="search.php">
                              <div class="form-group has-feedback">
                                <input class="form-control" placeholder="Search for photos" type="text" id="searchbar">
                                <i class="glyphicon glyphicon-search form-control-feedback" style="color:#777;"></i>
                              </div>
                            </form>
                          </li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#" data-toggle="modal" data-target="#signinupmodal" data-backdrop="static" data-keyboard="false">Log in or Register</a>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;0&nbsp;items</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        <!-- End of Navigation Bar -->

        <!-- Page Content -->
        <div class="container push-bottom">
            <div class="row col-sm-12">
                <div class="jumbotron col-sm-5 black-box">
                    <h3 class="text-center">CONTACT</h3>
                    <br>
                    <div>
                        <p><span class="glyphicon glyphicon-phone-alt text-info"></span>&nbsp;&nbsp;+1-(800)-742-7656</p>
                        <p><span class="glyphicon glyphicon-envelope text-info"></span>&nbsp;&nbsp;support@picpolo.com</p>
                        <p>
                            <a href="http://www.facebook.com/picpolo"><img alt="Facebook logo" src="assets/style/icons/facebook.png"></a>
                            &nbsp;
                            <a href="http://www.twitter.com/picpolo"><img alt="Facebook logo" src="assets/style/icons/twitter.png"></a>
                            &nbsp;
                            <a href="http://www.instagram.com/picpolo"><img alt="Facebook logo" src="assets/style/icons/instagram.png"></a>
                        </p>
                    </div>
                </div>

                <div class="jumbotron col-sm-offset-2 col-sm-5 black-box">
                    <h3 class="text-center">GENERAL INQUERIES</h3>
                    <p class="required small text-danger">* = Required fields</p>
                    <!--begin HTML Form-->
                    <form class="form-horizontal" role="form" method="post" action="contact.php">
                        <div class="form-group">
                            <label for="name" class="control-label"><span class="text-danger">*</span> Name:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="First & Last">
                        </div>

                        <div class="form-group">
                            <label for="email" class="control-label"><span class="text-danger">*</span> Email: </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="you@domain.com">
                        </div>

                        <div class="form-group">
                            <label for="message" class="control-label"><span class="text-danger">*</span> Message:</label>
                            <textarea class="form-control" row="6" name="message" placeholder="Tell us your story?" style="resize: none;"></textarea>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" id="submit" name="submit" class="btn-lg btn-default">SUBMIT</button>
                        </div>
                        <!--end Form-->
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container -->


        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="text-info">Copyright &copy; CSC648 Team 2 2016</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>


        <!-- Sign In & Sign Up Modal -->
        <div id="signinupmodal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="col-sm-12 text-right">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="row">
                        <div class="modal-content-block col-sm-6">
                            <div class="modal-header">
                                <h4 class="modal-title">Account Login</h4>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="userid" placeholder="Username" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="psw" placeholder="Password" required />
                                    </div>
                                    <div class="form-group text-right">
                                        <input type="submit" class="btn btn-default" value="Login" />
                                    </div>
                                </form>
                            </div>

                        </div>

                        <div class="modal-content-block col-sm-6">
                            <div class="modal-header">
                                <h4 class="modal-title">Register for a PicPolo Account</h4>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="firstname" placeholder="First Name" required />
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="lastname" placeholder="Last Name" required />
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="email" placeholder="Email" required />
                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control" id="userid" placeholder="PicPolo username" required />
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control" id="psw" placeholder="Password" required />
                                    </div>

                                    <div class="form-group">
                                        <input type="password" class="form-control" id="pswc" placeholder="Confirm Password" required />
                                    </div>

                                    <div class="form-group text-right">
                                        <input type="submit" class="btn btn-default" value="Create account" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Sign In & Sign Up Modal -->
        <?php include 'includes/footer.php'; ?>
    </body>
</html>
