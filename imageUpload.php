<?php

class imageUpload {

    private $sourceFile;
    private $imageId = array();
    private $destDir = 'assets/images';
    private $imageSize = array('medium' => 512, 'small' => 256);

    public function __construct($sourceFile, $imageId, $smallId, $mediumId, $largeId) {
        $this->sourceFile = $sourceFile;
        $this->imageId['largeId'] = "$imageId-$largeId";
        $this->imageId['mediumId'] = "$imageId-$mediumId";
        $this->imageId['smallId'] = "$imageId-$smallId";
    }

    public function uploadFile() {
        if ($this->checkFileSize() && $this->checkFileType()) {

            $tmp_name = $this->sourceFile["tmp_name"];
            $largeName = $this->imageId['largeId'] . '.' . $this->getFileType();
            $mediumName = $this->imageId['mediumId'] . '.' . $this->getFileType();
            $smallName = $this->imageId['smallId'] . '.' . $this->getFileType();
            move_uploaded_file($tmp_name, "$this->destDir/$largeName");
            if ($this->getFileType() === 'jpg' || $this->getFileType() === 'jpeg' || $this->getFileType() === 'png' || $this->getFileType() === 'gif') {
                $this->copyResizeImage("$this->destDir/$largeName", "$this->destDir/$mediumName", "$this->destDir/$smallName");
                return TRUE;
            } else {
                move_uploaded_file($tmp_name, "$this->destDir/$mediumName");
                move_uploaded_file($tmp_name, "$this->destDir/$smallName");
                return TRUE;
            }
        }
        echo "Sorry, your file was not uploaded.";
        return FALSE;
    }

    public function getFileType() {
        $imageFileType = strtolower(pathinfo($this->sourceFile['name'], PATHINFO_EXTENSION));
        return $imageFileType;
    }

    private function checkFileSize() {
        if ($this->sourceFile["size"] > 30340032) {
            echo "Sorry, your file is too large";
            return FALSE;
        }
        return TRUE;
    }

    private function isImage() {
        $check = getimagesize($this->sourceFile["tmp_name"]);
        if ($check !== false) {
            // echo "File is an image - " . $check["mime"] . ".";
            return TRUE;
        } else {
            echo "File is not an image.";
            return FALSE;
        }
    }

    private function checkFileType() {
        $fileExtension = strtolower(pathinfo($this->sourceFile['name'], PATHINFO_EXTENSION));
        if ($fileExtension != "jpg" && $fileExtension != "png" && $fileExtension != "jpeg" && $fileExtension != "gif" && $fileExtension != "mp4" && $fileExtension != "ogg") {
            echo "Sorry, only JPG, JPEG, PNG, GIF, MP4 & OGG files are allowed.";
            return FALSE;
        }
        return TRUE;
    }

    private function copyResizeImage($sourceFile, $mediumFile, $smallFile) {
        $imagickMedium = new \Imagick(realpath($sourceFile));
        $imagickMedium->setbackgroundcolor(new ImagickPixel("rgba(0,0,0,0.0)"));
        $imagickMedium->thumbnailImage($this->imageSize['medium'], $this->imageSize['medium'], true, true);
        $imagickMedium->writeimage($mediumFile);
        $imagickSmall = new \Imagick(realpath($sourceFile));
        $imagickSmall->setbackgroundcolor(new ImagickPixel("rgba(0,0,0,0.0)"));
        $imagickSmall->thumbnailImage($this->imageSize['small'], $this->imageSize['small'], true, true);
        $imagickSmall->writeimage($smallFile);
    }

}

?>