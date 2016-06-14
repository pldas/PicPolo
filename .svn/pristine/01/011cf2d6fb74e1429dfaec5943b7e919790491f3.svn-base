<?php
// require_once 'db/dbHandler.php';

if (isset($_POST['currentImageID'])) {
    $currentImageID = $_POST['currentImageID'];
} else {
    $_POST['currentImageID'] = "";
}

$dbquery = dbHandler::getInstance();
?>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header modal-header-style">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h2 class="modal-title"><i class="glyphicon glyphicon-picture" style="float:left"></i><font id="quick-buy-item"></font></h2>
        </div>
        <div class="modal-content-block">
            <div class="modal-body" style="color:black">
                <h4 style="text-align:center; font-weight:bold">Please select a License type</h4>
                <br>
                <div class="row">
                    <div class="col-sm-5">
                        <form action="" id="license-form" class="img-thumbnail" data-toggle="tooltip" title="Personal: This is for Personal use.">
                            <legend><center>Personal</center></legend>
                            <?php
                            $prices = $dbquery->getImagePrices($_POST['currentImageID'], "Personal");
                            foreach ($prices as $row) {
                                echo '<h4><input type="radio" id="personal" name="radio" onclick="uncheck(this.name, this.value)" value="License: Personal<br>Size:' .
                                    $row['name'] . '<br>Price: ' . $row['price'] . '$">' . $row['name'] . ' / ' . $row['price'] . '$</h4>';
                            }
                            ?>
                        </form>
                    </div>
                    <div class="col-sm-5" style="float:right">
                        <form action="" id="license-form" class="img-thumbnail" data-toggle="tooltip" title="Commercial: This is for Commercial use.">
                            <legend><center>Commercial</center></legend>
                            <?php
                            $prices = $dbquery->getImagePrices($_POST['currentImageID'], "Commercial");
                            foreach ($prices as $row) {
                                echo '<h4><input type="radio" id="commercial" name="radio" onclick="uncheck(this.name, this.value)" value="License: Commercial<br>Size:' .
                                    $row['name'] . '<br>Price: ' . $row['price'] . '$">' . $row['name'] . ' / ' . $row['price'] . '$</h4>';
                            }
                            ?>
                        </form>
                    </div>
                    <b><p class="pull-left" style="margin-left:170px;color:red" id="radio-error">&nbsp</p></b>
                </div>
                <br>
                    <div class="form-group">
                        <input type="button" class="btn btn-warning" data-dismiss="modal" style="float:left" value="Cancel" >
                        <a class="buy-btn btn btn-primary" style="float:right; margin-right:10px">Confirm Buy<span class="glyphicon glyphicon-chevron-right"></span></a>
                    </div>
                <script src="js/buyDialogBoxes.js"></script>
            </div>
        </div>
    </div>
</div>
