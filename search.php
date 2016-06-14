<?php
//start php session to store information
if (session_id() === '')
    session_start();
// session variable to track current page
$_SESSION['ACTIVE_PAGE'] = "search";

// restore username to display welcome message
if (isset($_SESSION['username'])) {
    $current_user = $_SESSION["username"];
}

//  store form variable in cookies to use after sign in or sign out.
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    setcookie('KEYWORD', $keyword);
} else {
    $keyword = $_COOKIE['KEYWORD'];
}

$artist = array();
if (isset($_GET['artist'])) {
    $artist = (isset($_GET['r_artist'])) ? array_diff($_GET['artist'], array($_GET['r_artist'])) : $_GET['artist'];
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
    $artist = array();
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
        <!-- Need to remove duplicate <script> includes.
             Recommendation: All general framework <script> includes should be done in the header file.
             Only page specific <script> includes should belong in search.php. reviewed by Tony Tran-->

        <title>Welcome to PicPolo</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <!-- include header file -->
        <?php include 'includes/header.php'; ?>

        <!-- Page Content -->
        <div class="container push-bottom">

            <div class="row">
                <h2 style="margin-top: -80px">Search Results</h2>
                <div class="col-sm-12 col-md-12">
                    <br>
                    <h4 style="color: black;">
                        <!-- General coding style is very good. Understandable variable names and good indentations,
                        Follows camel case coding convention.
                        reviewed by Tony Tran-->
                        <?php
                        // require_once 'db/dbHandler.php';
                        $dbsearch = dbHandler::getInstance();
                        $images = json_decode($dbsearch->getImageList($keyword, $artist, $category, $sort, $pageNum), TRUE);
                        $filters = json_decode($dbsearch->getFilterList($keyword, $artist, $category), TRUE);
                        echo $images[0] . ' result' . (($images[0] > 1) ? 's' : '') . ' found for "' . $keyword . '"';
                        ?>
                    </h4>
                    <hr>
                </div>
            </div>

            <div>

                <?php
                if ($keyword !== "") {

                    if ($images[0] > 0) {

                        // filter list
                        echo '<div class="col-sm-4 col-md-3">'
                        . '<div class="well">'
                        . '<ul class="nav navbar-collapse" ><li>'
                        . '<strong>Filter by Artist</strong>'
                        . '<ul class="nav" style="padding-left: 10%">';

                        $artists = array_combine(
                                array_map(function($element) {
                                    return $element['artistId'];
                                }, $filters), array_map(function($element) {
                                    return $element['artistName'];
                                }, $filters));

                        $artists = array_unique($artists);

                        foreach ($artists as $artistId => $artistName) {
                            echo '<li><label class="btn">';
                            if (in_array($artistId, $artist)) {
                                echo '<input form="searchForm" type="checkbox" onchange="submitForm(searchForm)" name="artist[]" value="' . $artistId . '" checked>&nbsp;';
                            } else {
                                echo '<input form="searchForm" type="checkbox" onchange="submitForm(searchForm)" name="artist[]" value="' . $artistId . '" >&nbsp;';
                            }
                            echo $artistName . '</label></li>';
                        }
                        echo '</ul></li><hr class="gray-div"><li>'
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
                                echo '<input form="searchForm" type="checkbox" onchange="submitForm(searchForm)" name="category[]" value="' . $categoryId . '" checked>&nbsp;';
                            } else {
                                echo '<input form="searchForm" type="checkbox" onchange="submitForm(searchForm)" name="category[]" value="' . $categoryId . '" >&nbsp;';
                            }
                            echo $categoryName . '</label></li>';
                        }
                        echo '</ul></li><hr>';

                        echo '</ul></div></div>';


                        // image result list
                        echo '<div class="col-sm-8 col-md-offset-1 col-md-8">'
                        . '<div class="panel panel-default">';
                        if (!empty($artist) || !empty($category)) {
                            echo '<div class="panel-heading" style="background: none;">'
                            . '<span>'
                            . '<strong>Filters:&nbsp</strong>';
                            if (!empty($artist)) {
                                echo '<span class="bg-success" style="padding: 5px;">Artist:&nbsp;&nbsp;';
                                foreach ($artist as $key) {
                                    echo '&nbsp;' . $artists[$key] . '<button form="searchForm" type="submit" onchange="submitForm(searchForm)" name="r_artist" value="' . $key . '" style="background: none; border: none;">&times;</button>';
                                }
                                echo '</span>&nbsp;&nbsp;';
                            }
                            if (!empty($category)) {
                                echo '<span class="bg-success" style="padding: 5px;">Category:&nbsp;&nbsp;';
                                foreach ($category as $key) {
                                    echo '&nbsp;' . $categories[$key] . '<button form="searchForm" type="submit" onchange="submitForm(searchForm)" name="r_category" value="' . $key . '" style="background: none; border: none;">&times;</button>';
                                }
                                echo '</span>&nbsp;&nbsp;';
                            }

                            echo '<button class="btn btn-success btn-sm" form="searchForm" type="submit" name="r_filter" value="1">Clear All Filter</button>&nbsp;';

                            echo '</span></div>';
                        }
                        echo '<div id="search-panel" class="panel-body">';

                        function highlightKeyword($word, $string) {
                            return str_replace($word, "<span class='text-primary'><b>" . $word . "</b></span>", $string);
                        }

                        foreach (array_slice($images, 1) as $image) {
                            // output data of each row
                            echo '<br><br><div class="container-fluid push-bottom text-left">'
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
                            echo'</div>'
                                    . '<div class="col-sm-3 col-md-3">'
                                    . '<h3>' . highlightKeyword($keyword, $image["imageTitle"]) . '</h3>'
                                    . '<div>'
                                    . '<p ><a class="form-control btn btn-md btn-success" href="detail.php?q=' . $image["imageId"] . '">Product Info <span class="glyphicon glyphicon-info-sign"></span></a></p>'
                                    . '<p><a id="quick-buy-btn" class="form-control btn btn-md btn-primary" onclick="quickBuy('
                                    . $image["imageId"] . ',' . "'" . $image["imageTitle"] . "'" . ')">Buy Now <span class="glyphicon glyphicon-chevron-right"></span></a></p>'
                                    . '</div></div></div>'
                                    . '<hr class=gray-div>';
                        }

                        function pageButtonSwitch($word, $string) {
                            return str_replace($word, "<strong><span class='text-success'>" . $word . "</span></strong>", $string);
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
                    } else {

                        echo '<div class="col-sm-6 col-md-6"><h4> Search Tips </h4><ul>'
                        . '<li> Reduce the number of keywords used, or use more general words. </li>'
                        . '<li> Try to use the full name, not just an acronym. </li>'
                        . '<li> Check if the spelling is correct. </li>'
                        . ' </ul></div>';
                    }
                } else {
                    return FALSE;
                }
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
