<?php
ob_start();
//start php session to store information
if (session_id() === '')
    session_start();

// session variable to track current page
$_SESSION['ACTIVE_PAGE'] = "sell";

if (isset($_SESSION['username']))
    $current_user = $_SESSION['username'];

// signout
if (isset($_SESSION['username']) && isset($_GET['signout'])) {
    // remove all session variables
    session_unset();

    // destroy the session 
    session_destroy();

    // redirect to home page
    header('Location: ' . $_COOKIE['HOME']);
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
        <title>Pic Polo: #1 photo licensing site!</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- JQuery 1.12.0 -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

        <!-- Custom CSS -->
        <link type="text/css" href="css/1-col-portfolio.css" rel="stylesheet">
        <link type="text/css" href="css/stylesheet.css" rel="stylesheet">




        <!-- Custom JavaScript -->
        <script src="js/search.js" type="text/javascript"></script>
        <script src="js/characterLimit.js" type="text/javascript"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>


        <?php include 'includes/header.php'; ?>
        <link href="css/gallery.css" rel="stylesheet" type="text/css">
        <div class="container">
            <div class="row">
                <h3 style="margin-top: -80px">Latest Artworks</h3>
                <div id="gallery">
                    <?php
                    $connection = dbHandler::getInstance();
                    $images = json_decode($connection->getBrowseImageList(NULL, NULL, 1, 1), TRUE);
                    if ($images[0] > 0) {
                        foreach (array_slice($images, 1) as $each_image) {
                            if ($each_image['imageType'] !== 'mp4' && $each_image['imageType'] !== 'ogg') {
                                ?>
                                <a href="detail.php?q=<?php echo $each_image['imageId']; ?>"><img src="assets/images/<?php echo $each_image['imageId'] . '-' . $each_image['imageSize'][0]['sizeId'] . '.' . $each_image['imageType']; ?>" /></a>
                            <?php } else { ?>
                                <video width="300" height="200" controls>
                                    <source src="assets/images/<?php echo $image["imageId"] . '-' . $image["imageSize"][2]['sizeId'] . '.' . $image["imageType"]; ?>" type="video/mp4">
                                    <source src="assets/images/<?php $image["imageId"] . '-' . $image["imageSize"][2]['sizeId'] . '.' . $image["imageType"]; ?>" type="video/ogg">
                                    Your browser does not support the video tag.
                                </video>
                                <?php
                            }
                        }
                    } else {
                        echo "the folder was empty !";
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- /.container -->

        <!-- Footer -->
        <?php include 'includes/footer.php'; ?>

    </body>

</html>

