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
        <?php
        /*            if (!isset($_SESSION["username"])) {
          echo '<META http-equiv="refresh" content="3;URL=login.php">';
          } */
        ?>
    </head>
    <body>
        <!-- Navigation Bar -->
        <?php
        include "includes/header.php";
        // require_once 'db/dbHandler.php';
        $recordNewImage = dbHandler::getInstance();
        ?>
        <script>
            if (!signedIn)
                window.location = "login.php?next_page=sell.php"
        </script>

        <!-- End of Navigation Bar -->
        <div class="container">
            <div class="row">
                <h2 style="margin-top: -80px">Upload Artwork</h2>
                <?php include 'includes/accountTabs.php'; ?>

                <!--<div class="col-sm-7 col-sm-offset-1 col-md-8 col-md-offset-1">-->
                <div class="col-sm-12  col-md-12">
                    <div class="container">
                        <div class="row">
                            <!--<div class="col-lg-8">-->
                            <div class="col-lg-12">
                                <div style="color:black" class="photo_upload_area">
                                    <form action="sell.php" name='uploadForm' id="uploadForm" method="POST" enctype="multipart/form-data" role="form">
                                        <div class="col-lg-12 push-bottom-sm">
                                            <div class="row">
                                                <fieldset>
                                                    <legend><h3>Select Artwork to Upload</h3></legend>
                                                    <!--
                                                    <div class="well-lg bg-primary">
                                                        <label for='fileToUpload'><span id='selectBtn' class="btn btn-default">Click here to select an artwork</span></label>
                                                        &nbsp;&nbsp;&nbsp;&nbsp;<span id='selectedFile'></span>
                                                        <p>Allowed File Type: gif, jpg, jpeg, png</p>
                                                        <p>Maximum File Size: 7MB</p>
                                                    </div>
                                                    <input required class="form-control" type="file" name="fileToUpload" class="file" id="fileToUpload" style="display: none; position: absolute;" accept="image/gif, image/jpeg, image/x-png" multiple="false"> -->
                                                    <input required class="btn btn-primary" type="file" name="fileToUpload" class="file" id="fileToUpload" accept="image/gif, image/jpeg, image/x-png" multiple="false">
                                                    <hr>
                                                </fieldset>
                                            </div>
                                            <div class="row">
                                                <br>
                                                <fieldset>
                                                    <legend><h3>Add File Information</h3></legend>
                                                    <div class="form-group">
                                                        <label for="fileTitle" required>Title</label>
                                                        <input required type="text" id="fileTitle" class="form-control" name="uploadData[fileTitle]"
                                                               maxlength="30" placeholder="A Creative Caption." pattern="[a-zA-Z0-9-\s]+" oninvalid="setCustomValidity('Letters, numbers, and white space only.')" onchange="try {
                                                                            setCustomValidity('')
                                                                        } catch (e) {
                                                                        }">
                                                        <br>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fileTags">Category</label>
                                                        <select id='fileTags' name="uploadData[categoryId]" class="form-control">
                                                            <option selected disabled>Select a PicPolo's Category (Or Select Other to add your own category tag)</option>
                                                            <?php
                                                            $categoryList = $recordNewImage->getCategory(NULL);
                                                            foreach ($categoryList as $categories) {
                                                                echo "<option value='" . $categories['catId'] . "' >" . $categories['name'] . "</option>";
                                                            }
                                                            ?>
                                                            <option value="other">Other</option>
                                                        </select>
                                                        <div id="otherCategory">
                                                            <label><h3>Add your own category</h3></label>
                                                            <input type="text" id="otherTags" name="uploadData[userCategoryId]" class="form-control" maxlength="120" placeholder="fun, party, sports"
                                                                   pattern="[a-zA-Z0-9-\s]+" oninvalid="setCustomValidity('Letters, numbers, and white space only.')" onchange="try {
                                                                    setCustomValidity('')
                                                                } catch (e) {
                                                                }">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="fileDescription">Description</label>
                                                        <textarea style="resize: none" class="form-control" rows="3" cols="2" maxlength="200" name="uploadData[fileDescription]" id="fileDescription" placeholder="Describe your Masterpiece!"></textarea>
                                                        <div id="fileDescriptionCount"></div>
                                                    </div>
                                                    <hr>
                                                </fieldset>
                                            </div>
                                            <div class="row">
                                                <br>
                                                <fieldset>
                                                    <legend><h3>Define Prices for License Types</h3></legend>
                                                    <div class="col-md-6">
                                                        <div class="text-center"><label>Standard License</label></div>
                                                        <div class="row"><div class="col-md-11"></div></div>
                                                        <div class="row">
                                                            <div class="col-md-11">
                                                                <label class="col-md-3">Small</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" name="price[0]" class="form-control" id="filePrice" min="0.00" step="0.01" max="999" value="1.99">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-11">
                                                                <label class="col-md-3">Medium</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" name="price[1]" class="form-control" id="filePrice" min="0.00" step="0.01" max="999" value="1.99">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-11">
                                                                <label class="col-md-3">Large</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" name="price[2]" class="form-control" id="filePrice" min="0.00" step="0.01" max="999" value="1.99">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="text-center"><label>Extended License</label></div>
                                                        <div class="row"><div class="col-md-11"></div></div>
                                                        <div class="row">
                                                            <div class="col-md-11">
                                                                <label class="col-md-3">Small</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" name="price[3]" class="form-control" id="filePrice" min="0.00" step="0.01" max="999" value="2.99">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-11">
                                                                <label class="col-md-3">Medium</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" name="price[4]" class="form-control" id="filePrice" min="0.00" step="0.01" max="999" value="2.99">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-11">
                                                                <label class="col-md-3">Large</label>
                                                                <div class="col-md-9">
                                                                    <input type="number" name="price[5]" class="form-control" id="filePrice" min="0.00" step="0.01" max="999" value="2.99">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <br>
                                            <div class="upload-buttons pull-left" style="margin-left:-15px">
                                                <button class="btn btn-warning" type="reset" value="Reset" id="cancelUploadBtn">Cancel</button>
                                            </div>
                                            <div class="upload-buttons inner-addon right-addon pull-right">
                                                <input type="submit" class="btn btn-primary" value="Publish Art" id="publishBtn" name="submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="well-lg col-sm-10 col-md-10 col-sm-offset-1 col-md-offset-1 text-center">
                    <?php
                    include 'imageUpload.php';
                    if (isset($_POST['submit'])) {
                        $imageId = $recordNewImage->getNewImageId();
                        $sizes = $recordNewImage->getSizes();
                        $licenses = $recordNewImage->getLicenses();
                        $artistId = $_SESSION['artistId'];
                        $prices = $_POST['price'];
                        $imageTitle = $_POST['uploadData']['fileTitle'];
                        $imageDescription = $_POST['uploadData']['fileDescription'];
                        $imageCategory = $_POST['uploadData']['categoryId'];
                        $uploadImage = new imageUpload($_FILES['fileToUpload'], $recordNewImage->getNewImageId(), $sizes[0]['sizeId'], $sizes[1]['sizeId'], $sizes[2]['sizeId']);

                        if ($uploadImage->uploadFile()) {
                            $recordNewImage->insertImage($artistId, $imageTitle, $imageDescription, $imageCategory, $uploadImage->getFileType());
                            $i = 0;
                            $j = 0;
                            $size = array($sizes[2]['sizeId'], $sizes[1]['sizeId'], $sizes[0]['sizeId']);
                            foreach ($licenses as $license) {
                                while ($i < 3) {
                                    $recordNewImage->insertPrice($imageId, $size[$i], $license['licId'], $prices[$j]);
                                    $i++;
                                    $j++;
                                }
                                $i = 0;
                            }
                            if ($uploadImage->getFileType() !== 'mp4' && $uploadImage->getFileType() !== 'ogg') {
                                echo '<h3>Preview</h3>'
                                . '<img src="assets/images/' . $imageId . '-' . $sizes[2]['sizeId'] . '.' . $uploadImage->getFileType() . '" />';
                            } else {
                                echo '<h3>Preview</h3>'
                                . '<video width="320" height="240" controls>
                                   <source src="assets/images/' . $imageId . '-' . $sizes[2]['sizeId'] . '.' . $uploadImage->getFileType() . '" type="video/mp4">
                                   <source src="assets/images/' . $imageId . '-' . $sizes[2]['sizeId'] . '.' . $uploadImage->getFileType() . '" type="video/ogg">
                                   Your browser does not support the video tag.
                                   </video>';
                            }
                        }
                    }
                    ?>

                </div>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </body>
</html>
