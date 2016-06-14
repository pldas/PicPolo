<?php
//start php session to store information
if (session_id() === '')
    session_start();

// session variable to track current page
$_SESSION['ACTIVE_PAGE'] = "detial";

// restore username to display welcome message
if (isset($_SESSION['username']))
    $current_user = $_SESSION["username"];

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

//if (isset($_POST['imgId']))
//  $imgId = $_POST['imgId'];
//else
//   $imgId = "1000";
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Detail</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>

        <!-- include header file -->
        <?php
        include 'includes/header.php';
        // require_once 'db/dbHandler.php';
        $dbHamdeler = dbHandler::getInstance();
        $imgId = $_GET['q'];
        ?>

        <!-- This page shows information about each image and lets the user to buy the image
            in different size and License.
        -->

        <div class="container">
            <?php
            $imgName = $dbHamdeler->getImageName($imgId);
            $tmpArray = json_decode($dbHamdeler->getImageInfo($imgId), TRUE);
            $imgInfo = $tmpArray[0];
            $source = "assets/images/" . $imgName['imgId'] . "-" . $imgInfo['imageSize'][1]['sizeId'] . "." . $imgName['imgType'];
            $vidSource = "assets/images/" . $imgName['imgId'] . "-" . $imgInfo['imageSize'][2]['sizeId'] . "." . $imgName['imgType'];
            ?>
            <h2 style="margin-top: -80px "> Detail Page: <?php echo $imgName['imgTitle']; ?><br><br></h2>
            <div class="row">

                <div class="col-sm-6">
                    <?php
                    if ($imgName['imgType'] !== 'mp4' && $imgName['imgType'] !== 'ogg') {
                    echo '<img src="'.$source.'" class="img-responsive" >';
                    }else{
                        echo '<video width="500" height="500" controls>
                                   <source src="'.$vidSource.'" type="video/mp4">
                                   <source src="'.$vidSource.'" type="video/ogg">
                                   Your browser does not support the video tag.
                                   </video>';
                    }
                            ?>
                </div>

                <div class="col-sm-5">
                    <div class="row">
                        <?php
                        echo '<h4><strong>Artwork Title: </strong>' . $imgInfo['imageTitle'] . '</h4><br>'
                        . '<h4><strong>Artist Name: </strong>' . $imgInfo['artistName'] . '</h4><br>'
                        . '<h4><strong>Category: </strong>' . $imgInfo['imageCategory'] . '</h4><br>'
                        . '<h4><strong>Description: </strong>' . $imgInfo['imageDescription'] . '</h4><br>'
                        . '<b><p class="pull-left" style="color:red" id="radio-error">&nbsp</p></b>';
                        ?>
                    </div>

                    <div class="row">
                        <h4><br><strong>Size / Price / License:</strong></h4>
                        <div class="col-sm-5">
                            <br>
                            <form action=""  id="license-form" class="img-thumbnail" data-toggle="tooltip" title="Personal: This is for personal use.">
                                <legend><center>Personal</center></legend>
                                <?php
                                $prices = $dbHamdeler->getImagePrices($imgId, "Personal");
                                foreach ($prices as $row) {
                                    echo '<h4><input type="radio" id="personal" name="radio" onclick="uncheck(this.name, this.value)" value="License: Personal<br>Size:' .
                                    $row['name'] . '<br>Price: ' . $row['price'] . '$">' . $row['name'] . ' / ' . $row['price'] . '$</h4>';
                                }
                                ?>
                              </form>
                        </div>
                        <div class="col-sm-5">
                            <br>
                            <form action="" id="license-form" class="img-thumbnail" data-toggle="tooltip" title="Commercial: This is for Commercial use.">
                                <legend><center>Commercial</center></legend>
                                <?php
                                $prices = $dbHamdeler->getImagePrices($imgId, "Commercial");
                                foreach ($prices as $row) {
                                    echo '<h4><input type="radio" id="commercial" name="radio" onclick="uncheck(this.name, this.value)" value="License: Commercial<br>Size:' .
                                    $row['name'] . '<br>Price: ' . $row['price'] . '$">' . $row['name'] . ' / ' . $row['price'] . '$</h4>';
                                }
                                ?>
                            </form>
                        </div>
                        <div class="row">
                            <?php
                            echo '  <div class="row-fluid pull-right">
                                    <br>
                                    <a class="buy-btn btn btn-primary btn-lg">Buy Now <span class="glyphicon glyphicon-chevron-right"></span></a>
                                    </div>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'includes/footer.php'; ?>
        <!-- This script must be included here or else it won't be in the scope at runtime for radio buttons. -->
        <script src="js/buyDialogBoxes.js"></script>
    </body>
</html>
