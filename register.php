<?php
ob_start();
if (session_id() === '') {
    session_start();
}
$_SESSION['ACTIVE_PAGE'] = "register";
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
                    <h4>New Seller Create Account</h4>
                    <hr>

                    <?php
                    /**
                     * Checking if user is entering correct information during registration
                     */

                    // initialization  of variables
                    $firstNameErr = $lastNameErr = $usernameErr = $passwordErr = $pswcErr = $emailErr = "";
                    $firstName = $lastName = $username = $password = $pswc = $email = "";

                    include_once 'formValidation.php';
                    $fv = new formValidation();

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {

                        $firstName = $fv->test_input($_POST["firstname"]);
                        $lastName = $fv->test_input($_POST["lastname"]);
                        $username = $fv->test_input($_POST["userid"]);
                        $password = $fv->test_input($_POST["psw"]);
                        $pswc = $fv->test_input($_POST["pswc"]);
                        $email = $fv->test_input($_POST["email"]);

                        $firstNameErr = $fv->lettersOnly($firstName);
                        $lastNameErr = $fv->lettersOnly($lastName);
                        $usernameErr = $fv->alphanumeric($username);
                        $passwordErr = $fv->alphanumeric($password);
                        $pswcErr = $fv->passwordCheck($password, $pswc);
                        $emailErr = $fv->emailFormat($email);
                    }
                    ?>
                    <form action="register.php#formAnchor" method="post" enctype="multipart/form-data" id="formAnchor">
                        <div class="form-group">
                            <input type="text" class="form-control" pattern="[a-zA-Z\s]*" oninvalid="setCustomValidity('Letters and white space only.')" onchange="try {
                                        setCustomValidity('')
                                    } catch (e) {
                                    }" name="firstname" id="firstname" value="<?php echo $firstName; ?>"placeholder="First Name" required />
                            <span class="error"> <?php echo $firstNameErr; ?></span>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" pattern="[a-zA-Z\s]*" oninvalid="setCustomValidity('Letters and white space only.')" onchange="try {
                                        setCustomValidity('')} catch (e) {
                                    }" name="lastname"id="lastname" value="<?php echo $lastName; ?>"placeholder="Last Name" required />
                            <span class="error"> <?php echo $lastNameErr; ?></span>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$" oninvalid="setCustomValidity('Please enter a valid email.')" onchange="try {
                                        setCustomValidity('')
                                    } catch (e) {
                                    }" name="email"id="email" value="<?php echo $email; ?>"placeholder="Email" required />
                            <span class="error"> <?php echo $emailErr; ?></span>
                        </div>

                        <div class="form-group">
                            <input type="text" pattern="[a-z A-Z 0-9 \s]*" oninvalid="setCustomValidity('Letters, numbers, and white space only.')" onchange="try {
                                        setCustomValidity('')
                                    } catch (e) {
                                    }" class="form-control" name="userid" id="userid" value="<?php echo $username; ?>"placeholder="PicPolo username" required />
                            <span class="error"> <?php echo $usernameErr; ?></span>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" name="psw" id="psw" placeholder="Password" required />
                            <span class="error"> <?php echo $passwordErr; ?></span>
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" name="pswc" id="pswc" placeholder="Confirm Password" required />
                            <span class="error"> <?php echo $pswcErr; ?></span>
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
                            <input type="submit" name="createAcc" class="btn btn-success" value="Create account" />
                        </div>
                    </form>
                    <?php
                    /*
                     * handles user account creation
                     */
                    
                    include_once 'authorization.php';
                    // require_once 'db/dbHandler.php';
                    $dbsearch = dbHandler::getInstance();
                    $auth = new authentication();
                    if (isset($_POST["createAcc"])) {
                        $username = $_POST["userid"];
                        $password = $_POST["psw"];
                        $pswc = $_POST["pswc"];
                        $firstname = $_POST["firstname"];
                        $lastname = $_POST["lastname"];
                        $email = $_POST["email"];

                        $exist = $dbsearch->findUser($username);
                        if ($emailErr == "" && $firstNameErr == "" && $lastNameErr == "" && $usernameErr == "" && $passwordErr == "" && $pswcErr == "") {
                            if ($auth->createErrors($exist) === false && $auth->passwordConfirmation($password, $pswc) === true) {
                                $dbsearch->createAccount($username, $password, $firstname, $lastname, $email);
                                if (isset($_POST['artist'])) {
                                    $userId = $dbsearch->getArtistId($username);
                                    $dbsearch->createSeller($userId, $firstname);
                                }
                                echo "<script type='text/javascript'>location.href='index.php';</script>";
                            }
                        }
                    }
                    ?>

                </div>
                <hr>
                <div class="container-fluid text-center" style="color: black;">
                    Already have an account? <a href="login.php">login in</a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>
        <!-- /Footer -->

    </body>
</html>
