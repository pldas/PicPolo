<?php
ob_start();
if (session_id() === '') {
    session_start();
}
$_SESSION['ACTIVE_PAGE'] = "login";
if (isset($_GET['next_page'])) {
    setcookie('NEXT_PAGE', filter_input(INPUT_GET, 'next_page'));
    setcookie('CURRENT_PAGE', filter_input(INPUT_GET, 'next_page'));
}
if (isset($_SESSION['username'])) {
    header("Location: " . $_COOKIE['NEXT_PAGE']);
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
        <title>Account </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <!-- Header -->
        <?php include 'includes/header.php'; ?>
        <!-- /Header -->

        <div class="container push-bottom">
            <div class="col-sm-6 col-sm-offset-3s col-md-6 col-md-offset-3">
                <div class="jumbotron well">
                    <h4 style="color:black">
                        Already have an Account?
                    </h4>
                    <hr>
                    <form action="login.php" method="post" enctype="multipart/form-data" >
                        <div class="form-group">
                            <input placeholder="Username" type="text" class="form-control" id="userid" name="user" required />
                        </div>
                        <div class="form-group">
                            <input placeholder="Password" type="password" class="form-control" id="psw" name="pass" required />
                        </div>
                        <div class="form-group text-right">
                            <input type="submit" class="btn btn-primary" name="login" value="Sign In" />
                        </div>
                    </form>
                    <?php
                    /*
                     * checks user login information and if correct, leads user to member-area
                     */

                    include 'authorization.php';
                    if (isset($_POST["login"])) {
                        $username = $_POST["user"];
                        $password = $_POST["pass"];
                        // require_once 'db/dbHandler.php';
                        $dbsearch = dbHandler::getInstance();
                        $auth = new authentication();
                        $user = $dbsearch->findUser($username);
                        $correct = $dbsearch->findLogin($username, $password);
                        $exist = /* $auth->checkExistingUser($user); */ $user;

                        if ($auth->checkLogin($exist, $correct) === true) {
                            $auth->createSession($username);
                            $_SESSION['artistId'] = $dbsearch->getArtistId($username);
                            header("Location: profile.php");
                            exit();
                        }
                    }
                    ?>
                </div>
                <hr>
                <div class="jumbotron well">
                    <h4>
                        New to PicPolo?
                    </h4>
                    <br>
                    <div class="container-fluid text-center">
                        <a href="register.php?next_page=sell.php"><div class="btn btn-success">Create your PicPolo Account</div></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>
        <!-- /Footer -->

    </body>
</html>
