<?php
//start php session to store information
if (session_id() === '')
    session_start();

// session variable to track current page
$_SESSION['ACTIVE_PAGE'] = "artistinfo";
$SIGNED_IN = isset($_SESSION['username']);

// restore username to display welcome message
if (isset($_SESSION['username'])) {
    $current_user = $_SESSION["username"];
}

$artist = array();
if (isset($_GET['artist'])) {
    setcookie('selectedArtist', $_GET['artist']);
    $artist[0] = $_GET['artist'];
} else {
    $artist[0] = $_COOKIE['selectedArtist'];
}

$category = array();
if (isset($_GET['category'])) {
    $category = (isset($_GET['r_category'])) ? array_diff($_GET['category'], array($_GET['r_category'])) : $_GET['category'];
}

$sort = 0;
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}

if (isset($_GET['r_filter'])) {
    $category = array();
    $sort = array();
}
$pageNum = 1;
if (isset($_GET['page'])) {
    $pageNum = $_GET['page'];
}

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
        <!-- include header file -->
        <?php
        include 'includes/header.php';
        // require_once 'db/dbHandler.php';
        $dbsearch = dbHandler::getInstance();
        $images = json_decode($dbsearch->getBrowseImageList($artist, $category, $sort, $pageNum), TRUE);
        $filters = json_decode($dbsearch->getBrowseFilterList($artist, $category), TRUE);
        ?>

        <!-- Page Content -->
        <div class="container push-bottom">

            <div class="row">
                <h3 style="margin-top: -80px">Artist: <?php echo $filters[0]['artistName']; ?></h3>
                <div class="col-sm-12 col-md-12">
                    <br>

                    <?php
                    $artistInfo = json_decode($dbsearch->getArtist($artist[0]), TRUE);
                    echo '<h4>A little bit about ' . $artistInfo[0]['artistName'] . '</h4>'
                    . '<p>' . $artistInfo[0]['bio'] . '</p><br><br>';
                    ?>
                </div>
            </div>

            <div>

                <?php
                if ($images[0] > 0) {

                    echo '<hr><form style="display: none;" id="browseForm" action="artistinfo.php" method="GET"></form>';

                    // filter list
                    echo '<div class="col-sm-4 col-md-3">'
                    . '<div class="well">'
                    . '<ul class="nav navbar-collapse" ></li><hr><li>'
                    . '<strong>Filter by Category</strong>'
                    . '<ul class="nav" style="padding-left: 10%">';

                    $categories = array_combine(
                            array_map(function($element) {
                                $cat = $element['imageCategory'];
                                return $cat['catId'];
                            }, $filters), array_map(function($element) {
                                $cat = $element['imageCategory'];
                                return $cat['name'];
                            }, $filters));

                    $categories = array_unique($categories);



                    foreach ($categories as $categoryId => $categoryName) {
                        echo '<li><label class="btn">';
                        if (in_array($categoryId, $category)) {
                            echo '<input form="browseForm" type="checkbox" onchange="submitForm(browseForm)" name="category[]" value="' . $categoryId . '" checked>&nbsp;';
                        } else {
                            echo '<input form="browseForm" type="checkbox" onchange="submitForm(browseForm)" name="category[]" value="' . $categoryId . '" >&nbsp;';
                        }
                        echo $categoryName . '</label></li>';
                    }
                    echo '</ul></li><hr>';

                    echo '</ul></div></div>';


                    // image result list
                    echo '<div class="col-sm-8 col-md-offset-1 col-md-8">'
                    . '<div>';
                    if (!empty($category)) {
                        echo '<div class="panel panel-default">'
                        . '<div class="panel-body">'
                        . '<span class="text-left">'
                        . '<strong>Filters:&nbsp</strong>';

                        if (!empty($category)) {
                            echo '<span class="bg-success" style="padding: 5px;">Category:&nbsp;&nbsp;';
                            foreach ($category as $key) {
                                echo '&nbsp;' . $categories[$key] . '<button form="browseForm" type="submit" name="r_category" value="' . $key . '" style="background: none; border: none;">&times;</button>';
                            }
                            echo '</span>&nbsp;&nbsp;';
                        }

                        echo '<button class="btn btn-success btn-sm" form="browseForm" type="submit" name="r_filter" value="1">Clear All Filter</button>&nbsp;';

                        echo '</span></div></div>';
                    }
                    echo '<div class=" container-fluid text-center">';
                    foreach (array_slice($images, 1) as $image) {
                        // output data of each row
                        echo '<div style="color:black;" class="container-fluid push-bottom text-left">'
                        . '<div class="col-sm-offset-1 col-sm-7 col-md-offset-1 col-md-7">';
                        if ($image['imageType'] !== 'mp4' && $image['imageType'] !== 'ogg') {
                                echo '<a href="detail.php?q=' . $image["imageId"] . '">'
                                . '<img id="picture-preview" src="assets/images/' . $image["imageId"] . '-' . $image["imageSize"][0]['sizeId'] . '.' . $image["imageType"] . '" alt="" class="img-responsive" width="300" height="200">'
                                . '</a>';
                            } else {
                                echo '<video width="300" height="200" controls>
                                   <source src="assets/images/' . $image["imageId"] . '-' . $image["imageSize"][2]['sizeId'] . '.' . $image["imageType"] . '" type="video/mp4">
                                   <source src="assets/images/' . $image["imageId"] . '-' . $image["imageSize"][2]['sizeId'] . '.' . $image["imageType"] . '" type="video/ogg">
                                   Your browser does not support the video tag.
                                   </video>';
                            }
                        echo '</div>'
                        . '<div class="col-sm-3 col-md-3">'
                        . '<h3>' . $image["imageTitle"] . '</h3>'
                        . '<div>'
                        . '<p><a class="form-control btn btn-md btn-success" href="detail.php?q=' . $image["imageId"] . '">Product Info <span class="glyphicon glyphicon-info-sign"></span></a></p>'
                        . '<p><a id="quick-buy-btn" class="form-control btn btn-md btn-primary" onclick="quickBuy('
                        . $image["imageId"] . ',' . "'" . $image["imageTitle"] . "'" . ')">Buy Now <span class="glyphicon glyphicon-chevron-right"></span></a></p>'
                        . '</div></div></div>'
                        . '<hr>';
                    }

                    // Pagination
                    $resultsPerPage = 10;
                    if (intval($images[0] / $resultsPerPage)) {
                        echo '<div class="row text-center">'
                        . '<div class="col-lg-12">'
                        . '<ul class="pagination">'
                        . '<li ' . (($pageNum < 2) ? 'class="disabled"' : '') . '><a href="' . (($pageNum < 2) ? '#' : '?page=' . ($pageNum - 1)) . '">&laquo;</a></li>';
                        for ($i = 1; $i <= intval(ceil($images[0] / $resultsPerPage)); $i++) {
                            echo '<li ' . (($i === intval($pageNum)) ? 'class="active"' : '') . '><a href="?page=' . $i . '">' . $i . '</li>';
                        }
                        echo '<li ' . (($pageNum >= intval(ceil($images[0] / $resultsPerPage))) ? 'class="disabled"' : '') . '>'
                        . '<a href="' . (($pageNum >= intval(ceil($images[0] / $resultsPerPage))) ? '#' : '?page=' . ($pageNum + 1)) . '">&raquo;</a></li>'
                        . '</ul></div></div>';
                    }
                    echo '</div></div>';
                } /* else {

                    echo '<div class="col-sm-6 col-md-6"><h4> Search Tips </h4><ul>'
                    . '<li> Reduce the number of keywords used, or use more general words. </li>'
                    . '<li> Try to use the full name, not just an acronym. </li>'
                    . '<li> Check if the spelling is correct. </li>'
                    . ' </ul></div>';
                } */
                echo '</div>';
                ?>
        </div>
            <!-- Quick Buy Modal -->
            <div id="quick-buy-modal" class="modal fade" role="dialog"></div>    
    </div>
    <!-- /.container -->
    

    <!-- Include footer file -->
    <?php include 'includes/footer.php'; ?>
</body>

</html>
