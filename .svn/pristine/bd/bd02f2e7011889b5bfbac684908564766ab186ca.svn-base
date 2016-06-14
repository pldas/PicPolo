<?php
//start php session to store information
if (session_id() === '')
    session_start();

// session variable to track current page
$_SESSION['ACTIVE_PAGE'] = "artist";

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

        <!-- Header -->
        <?php include 'includes/header.php'; ?>
        <!-- /Header -->

        <!-- Body -->
        <div class="container push-bottom">
            <?php
            // require_once 'db/dbHandler.php';
            $artistDB = dbHandler::getInstance();

            $artistList = json_decode($artistDB->getArtist(), TRUE);

            sort($artistList);

            $tmpList;
            foreach ($artistList as $currentArtist) {
                $tmpList[] = strtoupper(substr($currentArtist['artistName'], 0, 1));
            }
            $tmpList = array_unique($tmpList);
            sort($tmpList);
            $hasNumber = is_numeric($tmpList[0]);
            $alphaList = array_filter($tmpList, function($arrayEntry) {
                return !is_numeric($arrayEntry);
            });

            echo '<div class="container col-sm-12 col-md-12">'
            . '<h3>Artist Directory</h3>';

            if ($hasNumber) {
                echo '<a class="btn btn-primary" href="#0-9">#</a>&nbsp&nbsp';
            }

            foreach ($alphaList as $character) {
                echo '<a class="btn btn-primary" href="#' . strtolower($character) . '">' . $character . '</a>&nbsp&nbsp';
            }
            echo '</div><hr>';

            echo '<div class="container col-sm-12 col-md-12">';

            if ($hasNumber) {
                echo '<div class="container col-sm-12 col-md-12">'
                . '<h3 id="0-9" class="bg-primary col-sm-12 col-md-12">#</h3><br>';
                foreach ($artistList as $currentArtist) {
                    if (is_numeric(substr($currentArtist['artistName'], 0, 1))) {
                        echo '<p><a class="btn btn-primary" href="artistinfo.php?artist=' . $currentArtist['artistId'] . '">' . $currentArtist['artistName'] . '</a></p>';
                    }
                }
                echo '</div>';
            }

            foreach ($alphaList as $character) {

                echo '<div class="container col-sm-12 col-md-12">'
                . '<h3 id="' . strtolower($character) . '" class="bg-primary col-sm-12 col-md-12"><span>' . strtoupper($character) . '</span></h3><br>';
                foreach ($artistList as $currentArtist) {
                    if (strtolower(substr($currentArtist['artistName'], 0, 1)) == strtolower($character)) {
                        echo '<p><a href="artistinfo.php?artist=' . $currentArtist['artistId'] . '">' . $currentArtist['artistName'] . '</a></p>';
                    }
                }
                echo '</div>';
            }
            echo '</div>';
            ?>


        </div>
        <!-- /Body -->

        <!-- Footer -->
<?php include 'includes/footer.php'; ?>
        <!-- /Footer -->

    </body>

</html>
