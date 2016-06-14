<?php

/*
 * To change  header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dbHandler
 *
 * @author ivan
 */
class dbHandler {

    private static $instance;
    private $conn;
    private $table = array(
        'image' => 'image',
        'user' => 'user',
        'artist' => 'seller',
        'size' => 'imageSize',
        'category' => 'imageCat',
        'license' => 'licType',
        'seller' => 'seller',
        'price' => 'imagePrice'
    );

    /**
     * Get an instance of the database
     * @return Instance
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     * 
     */
    public function __construct() {
        $conInfo = parse_ini_file("dbconfig.ini");
        try {
            // Create connection
            $this->conn = new PDO("mysql:host=" . $conInfo['host'] . ";dbname=" . $conInfo["dbname"], $conInfo["username"], $conInfo["password"]);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Check connection
            trigger_error("Database connection failed: " . $e->getMessage(), E_USER_ERROR);
        }
    }
    /**
     * Method clone is empty to prevent duplication of connection
     */
    private function __clone() {
        
    }

    /**
     * Get sql connection
     * @return sql connection object
     */
    public function getConnection() {
        return $this->conn;
    }
    
    /**
     * Function is used to protect from sql injection
     * @param String $input query term to that will convert to a term safe from sql injection
     * @return String $safe_input the converted query term
     */
    private function injectProt($input) {
        $safe_input = preg_replace('/[^\p{L}\p{N}\s]/u', '', $input);
        return $safe_input;
    }

    /*     * *************************** Image Info Session ********************************** */

    /**
     * This function inserts newly created data for uploaded image into database if no errors occur
     * 
     * @param int $artistId
     * @param string $title
     * @param string $description
     * @param int $status
     * @param int $category
     * @param string $type
     */
    public function insertImage($artistId, $title, $description, $category, $type) {
        $query = "INSERT INTO " . $this->table['image'] . " (artistId, imgTitle, descrip, catId, imgType) VALUE('$artistId', '$title', '$description', '$category', '$type')";

        try {
            $this->getConnection()->exec($query);
            echo "<script>alert(Thank You for Your Submission. \nYou have successfully submitted your artwork</script>";
            return TRUE;
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return FALSE;
        }
    }

    /**
     * This function inserts the price of the image with specific license, and size
     * 
     * @param int $imageId image id number
     * @param int $sizeId  size of the image
     * @param int $licenseId license corresponding to image and size
     * @param float $price 
     * @return boolean 
     */
    public function insertPrice($imageId, $sizeId, $licenseId, $price) {
        $query = "INSERT INTO " . $this->table['price'] . " (imgId, sizeId, licId, price) VALUE('$imageId', '$sizeId', '$licenseId', '$price')";

        try {
            $this->getConnection()->exec($query);
            return TRUE;
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return FALSE;
        }
    }

    /**
     * function to get next auto increment image id number
     * @return int new image id number
     */
    public function getNewImageId() {
        $query = 'SHOW TABLE STATUS LIKE "' . $this->table['image'] . '";';
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['Auto_increment'];
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * 
     * @return String
     */
    public function getSizes() {
        $query = "SELECT * FROM " . $this->table['size'] . ";";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            $result;
            if ($count > 0) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return $result;
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    public function getLicenses() {
        $query = "SELECT * FROM " . $this->table['license'] . ";";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * 
     * @param int $artist
     * @param int $category
     * @return String
     */
    public function getBrowseFilterList($artist, $category) {
        $query = "SELECT SQL_CALC_FOUND_ROWS I.*, A.userId, A.pseudonym FROM "
                . $this->table['image'] . " I INNER JOIN " . $this->table['artist']
                . " A ON I.artistId=A.userId";

        if (!empty($artist) || !empty($category)) {
            $query .= ' WHERE';
        }

        if (!empty($artist)) {
            foreach ($artist as $id) {
                $q[] = ' LOWER(userId) LIKE "' . strtolower($id) . '" ';
            }
            $query .= ' (' . implode(" OR ", $q) . ')';
        }

        if (!empty($category)) {
            foreach ($category as $id) {
                $q[] = ' catId LIKE "' . strtolower($id) . '" ';
            }
            $query .= ' ' . ((!empty($artist)) ? ' AND ' : '') . '(' . implode(" OR ", $q) . ')';
        }

        $query .= ";";

        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $results;
            if ($stmt->rowCount() > 0) {
                foreach ($stmt->fetchAll() as $row) {
                    $category = $this->getCategory($row['catId']);
                    $size = $this->getSizes();
                    $license = $this->getLicenses();
                    $results[] = array(
                        'artistId' => $row['artistId'],
                        'artistName' => $row['pseudonym'],
                        'imageCategory' => $category,
                        'imageSize' => $size,
                        'listingStatus' => $row['status'],
                        'visitCount' => $row['numVisit'],
                        'imageType' => $row['imgType']
                    );
                }
                return json_encode($results);
            } else {
                return;
            }
        } catch (Exception $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return;
        }
    }

    /**
     * 
     * @param int $artist
     * @param int $category
     * @param int $sort
     * @param int $page
     * @return String
     */
    public function getBrowseImageList($artist, $category, $sort, $page) {
        $resultPerPage = 10;
        $rowOffset = $page * $resultPerPage - $resultPerPage;
        $query = "SELECT SQL_CALC_FOUND_ROWS I.*, A.userId, A.pseudonym FROM "
                . $this->table['image'] . " I INNER JOIN " . $this->table['artist']
                . " A ON I.artistId=A.userId";

        if (!empty($artist) || !empty($category)) {
            $query .= ' WHERE';
        }

        if (!empty($artist)) {
            foreach ($artist as $art) {
                $artArray[] = ' LOWER(userId) LIKE "' . strtolower($art) . '" ';
            }
            $query .= ' (' . implode(" OR ", $artArray) . ')';
        }

        if (!empty($category)) {
            foreach ($category as $cat) {
                $catArray[] = ' catId LIKE "' . strtolower($cat) . '" ';
            }
            $query .= ' ' . ((!empty($artist)) ? ' AND ' : '') . '(' . implode(" OR ", $catArray) . ')';
        }

        if($sort === 1) {
            $query .= ' AND (imgType <> "mp4" AND imgType <> "ogg") ORDER BY I.imgId DESC';
        }
        $query .= " LIMIT $rowOffset, $resultPerPage;";

        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $results[] = $this->getConnection()->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
            if ($stmt->rowCount() > 0) {
                foreach ($stmt->fetchAll() as $row) {
                    $size = $this->getSizes();
                    $results[] = array(
                        'imageId' => $row['imgId'],
                        'artistName' => $row['pseudonym'],
                        'imageTitle' => $row['imgTitle'],
                        'imageDescription' => $row['descrip'],
                        'imageSize' => $size,
                        'listingStatus' => $row['status'],
                        'imageType' => $row['imgType']
                    );
                }
                return json_encode($results);
            } else {
                return;
            }
        } catch (Exception $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return;
        }
    }

    /**
     * 
     * @param String $keyword
     * @param int $artist
     * @param int $category
     * @return String 
     */
    public function getFilterList($keyword, $artist, $category) {
        $keyword = strtolower($keyword);
        $query = "SELECT SQL_CALC_FOUND_ROWS I.*, A.userId, A.pseudonym FROM "
                . $this->table['image'] . " I INNER JOIN " . $this->table['artist']
                . " A ON I.artistId=A.userId WHERE I.status <> 0 AND (LOWER(I.imgTitle) LIKE \"%" . $keyword
                . "%\" OR LOWER(I.descrip) LIKE \"%" . $keyword . "%\" OR LOWER(A.pseudonym) LIKE \"%" . $keyword . "%\")";

        if (!empty($artist)) {
            foreach ($artist as $art) {
                $artArray[] = ' LOWER(userId) LIKE "%' . strtolower($art) . '%" ';
            }
            $query .= ' AND (' . implode(" OR ", $artArray) . ')';
        }

        if (!empty($category)) {
            foreach ($category as $cat) {
                $catArray[] = ' catId LIKE "' . strtolower($cat) . '" ';
            }
            $query .= ' AND (' . implode(" OR ", $catArray) . ')';
        }

        $query .= " ORDER BY CASE "
                . "WHEN (LOWER(I.imgTitle) LIKE \"" . $keyword . "%\" OR LOWER(I.descrip) LIKE \""
                . $keyword . "%\" OR LOWER(A.pseudonym) LIKE \"" . $keyword . "%\") THEN 1 "
                . "WHEN (LOWER(I.imgTitle) LIKE \"%" . $keyword . "\" OR LOWER(I.descrip) LIKE \"%"
                . $keyword . "\" OR LOWER(A.pseudonym) LIKE \"%" . $keyword . "\") THEN 3 "
                . "ELSE 2 END;";

        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $results;
            if ($stmt->rowCount() > 0) {
                foreach ($stmt->fetchAll() as $row) {
                    $category = $this->getCategory($row['catId']);
                    $size = $this->getSizes();
                    $license = $this->getLicenses();
                    $results[] = array(
                        'artistId' => $row['artistId'],
                        'artistName' => $row['pseudonym'],
                        'imageCategory' => $category,
                        'imageSize' => $size,
                        'listingStatus' => $row['status'],
                        'visitCount' => $row['numVisit'],
                        'imageType' => $row['imgType']
                    );
                }
                return json_encode($results);
            } else {
                return;
            }
        } catch (Exception $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return;
        }
    }

    /**
     * function get image data that match specific keyword, artist, category
     * @param String $keyword
     * @param int $artist
     * @param int $category
     * @param int $sort
     * @param int $page
     * @return String
     */
    public function getImageList($keyword, $artist, $category, $sort, $page) {
        $keyword = strtolower($keyword);
        $resultPerPage = 10;
        $rowOffset = $page * $resultPerPage - $resultPerPage;
        $query = "SELECT SQL_CALC_FOUND_ROWS I.*, A.userId, A.pseudonym FROM "
                . $this->table['image'] . " I INNER JOIN " . $this->table['artist']
                . " A ON I.artistId=A.userId WHERE I.status <> 0 AND (LOWER(I.imgTitle) LIKE \"%" . $keyword
                . "%\" OR LOWER(I.descrip) LIKE \"%" . $keyword . "%\" OR LOWER(A.pseudonym) LIKE \"%" . $keyword . "%\")";

        if (!empty($artist)) {
            foreach ($artist as $art) {
                $artArray[] = ' LOWER(userId) LIKE "%' . strtolower($art) . '%" ';
            }
            $query .= ' AND (' . implode(" OR ", $artArray) . ')';
        }

        if (!empty($category)) {
            foreach ($category as $cat) {
                $catArray[] = ' catId LIKE "' . strtolower($cat) . '" ';
            }
            $query .= ' AND (' . implode(" OR ", $catArray) . ')';
        }

        if($sort === 1) {
            $query .= ' ORDER BY I.imgId DESC';
        } else {
        $query .= " ORDER BY CASE "
                . "WHEN (LOWER(I.imgTitle) LIKE \"" . $keyword . "%\" OR LOWER(I.descrip) LIKE \""
                . $keyword . "%\" OR LOWER(A.pseudonym) LIKE \"" . $keyword . "%\") THEN 1 "
                . "WHEN (LOWER(I.imgTitle) LIKE \"%" . $keyword . "\" OR LOWER(I.descrip) LIKE \"%"
                . $keyword . "\" OR LOWER(A.pseudonym) LIKE \"%" . $keyword . "\") THEN 3 "
                . "ELSE 2 END ";
        }
        
        $query .= "LIMIT $rowOffset, $resultPerPage;";

        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $results[] = $this->getConnection()->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
            if ($stmt->rowCount() > 0) {
                foreach ($stmt->fetchAll() as $row) {
                    $size = $this->getSizes();
                    $results[] = array(
                        'imageId' => $row['imgId'],
                        'artistName' => $row['pseudonym'],
                        'imageTitle' => $row['imgTitle'],
                        'imageDescription' => $row['descrip'],
                        'imageSize' => $size,
                        'listingStatus' => $row['status'],
                        'imageType' => $row['imgType']
                    );
                }
                return json_encode($results);
            } else {
                return;
            }
        } catch (Exception $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return;
        }
    }

    /**
     * prints all info about the pictur
     * 
     * @param int imgId
     */
    public function getImageInfo($imgId) {

        $query = "SELECT * FROM " . $this->table['image'] . " I INNER JOIN " . $this->table['artist']
                . " A ON I.artistId=A.userId WHERE  I.status <> 0 AND  I.imgId = '$imgId';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $results;
            if ($stmt->rowCount() > 0) {
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    $category = $this->getCategory($row['catId']);
                    $size = $this->getSizes();
                    $license = $this->getLicenses();

                    $results[] = array(
                        'imageId' => $row['imgId'],
                        'artistId' => $row['artistId'],
                        'artistName' => $row['pseudonym'],
                        'imageTitle' => $row['imgTitle'],
                        'imageDescription' => $row['descrip'],
                        'imageCategory' => $category['name'],
                        'imageLicense' => $license,
                        'imageSize' => $size,
                        'visitCount' => $row['numVisit'],
                        'listingStatus' => $row['status'],
                        'imageType' => $row['imgType']
                    );
                }
                return json_encode($results);
            } else {
                return;
            }
        } catch (Exception $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return;
        }
    }

    /**
     * returns name.typ of the image
     * 
     * @param int imgId
     * @return String returns name.typ
     */
    public function getImageName($imgId) {

        $query = "SELECT imgId, imgTitle, imgType FROM " . $this->table['image'] . " WHERE imgId =  '$imgId';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {

                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row;
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * returns all prices for an image
     * 
     * @param int imgId
     * @return image price
     */
    public function getImagePrices($imgId, $lic) {
        $query = "SELECT S.name, P.price FROM " . $this->table['price'] . " P, " . $this->table['license'] . " L, imageSize S " .
                "WHERE P.imgId =  '$imgId' AND P.licId = L.licId AND P.sizeId = S.sizeId AND L.name = '$lic';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * function get the license name associated with license id number
     * @param type $licenseId
     * @return String array of license names
     */
    public function getLicenseType($licenseId) {

        $query = "SELECT * FROM " . $this->table['license'] . " WHERE licId = $licenseId;";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['name'];
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * function get the category name associated with the category id number
     * @param int $categoryId
     * @return String array of category name that match the category id number
     */
    public function getCategory($categoryId) {

        $query = "SELECT * FROM " . $this->table['category'];
        if (isset($categoryId)) {
            $query .=" WHERE catId = $categoryId";
        }
        $query .= " ORDER BY name;";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 1) {
                $result;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result[] = $row;
                }
                return $result;
            } else if ($count > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * returns image type name
     * 
     * @param int sizeId
     * @return String name
     */
    public function getSizeType($sizeId) {

        $query = "SELECT * FROM " . $this->table['size'] . " WHERE sizeId = $sizeId;";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['name'];
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * Runing search query to artist column of the image table in the database.
     * 
     * @param String $keyword
     */
    public function getArtist($artist = NULL) {

        $query = "SELECT * FROM " . $this->table['artist'];

        if (isset($artist)) {
            $query .= " WHERE userId=$artist";
        }
        $query .= " ORDER BY pseudonym ASC;";

        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            $result;
            if ($count > 0) {
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                    $result[] = array(
                        'artistId' => $row['userId'],
                        'artistName' => $row['pseudonym'],
                        'bio' => $row['bio']
                    );
                }
                return json_encode($result);
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /*     * ******************** End of Image Info Session ********************************** */


    /*     * **************************** User Info Session ********************************** */

    /**
     * Searchs db to find data that contains entered username and password
     * 
     * @param String $username
     * @param String $password
     * @return boolean returns true if account exist and false if not
     */
    public function findLogin($username, $password) {
        $query = "SELECT UserID FROM " . $this->table['user'] . " WHERE Username =  '$username' AND Password = '$password';";
        $result = $this->getConnection()->query($query);

        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count === 1) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return false;
        }
        return false;
    }

    /**
     * Checks to see if entered username exists in database
     * 
     * @param String $username
     * @return boolean returns true if username exists and false if it doesn't
     */
    public function findUser($username) {
        $query = "SELECT Username FROM " . $this->table['user'] . " WHERE Username =  '$username';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return false;
        }
        return false;
    }

    /**
     * Checks to see if entered username exists in database and displays information
     * 
     * @param String $username string to search for account information
     * @return Boolean
     */
    public function displayUserProfile($username) {
        $query = "SELECT * FROM " . $this->table['user'] . " WHERE Username =  '$username';";
        $result = $this->getConnection()->query($query);
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo '<h2>Welcome ' . $row['FirstName'] . '</h2><br>'
                . '<table class="table table-hover">'
                . '<thead>'
                . '<tr>'
                . '<th>Account Settings</th>'
                . '<th></th>'
                . '<th></th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>'
                . '<tr>'
                . '<td class="col-md-4">Name</td>'
                . '<td class="col-md-6">' . $row['FirstName'] . ' ' . $row['LastName'] . '</td>'
                . '<td class="col-md-2"><a href="#" data-toggle="modal" data-target="#editName" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>'
                . '</tr>'
                . '<tr>'
                . '<td class="col-md-4">Username</td>'
                . '<td class="col-md-6">' . $row['Username'] . '</td>'
                . '<td class="col-md-2"><p style="color:gray"><span class="glyphicon glyphicon-lock"></span> Locked</p></td>'
                . '</tr>'
                . '<tr>'
                . '<td class="col-md-4">Email</td>'
                . '<td class="col-md-6">' . $row['Email'] . '</td>'
                . '<td class="col-md-2"><a href="#" data-toggle="modal" data-target="#editEmail" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>'
                . '</tr>'
                . '<tr>'
                . '<td class="col-md-4">Password</td>'
                . '<td class="col-md-6">Change password</td>'
                . '<td class="col-md-2"><a href="#" data-toggle="modal" data-target="#editPassword" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>'
                . '</tr>'
                . '<td class="col-md-4">Phone</td>'
                . '<td class="col-md-6">(' . substr($row['Phone'], 0, 3) . ') ' . substr($row['Phone'], 3, 3) . '-' . substr($row['Phone'], 6, 4) . '</td>'
                . '<td class="col-md-2"><a href="#" data-toggle="modal" data-target="#editPhone" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>'
                . '</tr>'
                . '</tbody>'
                . '</table>';
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return FALSE;
        }
        return TRUE;
    }

    /**
     * checks to see if user has artist information and displays it
     * @param type $userId need to search for seller information
     * @return boolean
     */
    public function displayArtistDetail($userId) {
        $query = "SELECT * FROM " . $this->table['seller'] . " WHERE userId =  '$userId';";
        $result = $this->getConnection()->query($query);
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                echo '<table class="table table-hover">'
                . '<thead>'
                . '<tr>'
                . '<th>Artist details</th>'
                . '<th></th>'
                . '<th></th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>'
                . '<tr>'
                . '<td class="col-md-4">Pseudonym</td>'
                . '<td class="col-md-6">' . $row['pseudonym'] . '</td>'
                . '<td class="col-md-2"><a href="#" data-toggle="modal" data-target="#editPseudonym" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>'
                . '</tr>'
                . '<tr>'
                . '<td class="col-md-4">Biography</td>'
                . '<td class="col-md-6">' . $row['bio'] . '</td>'
                . '<td class="col-md-2"><a href="#" data-toggle="modal" data-target="#editBio" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>'
                . '</tr>'
                . '</tbody>'
                . '</table>';
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return FALSE;
        }
        return TRUE;
    }

    /**
     * checks to see if user has artist information and displays it
     * @param type $userId need to search for seller information
     * @return String image data related to specifed artist in JSON string
     */
    public function getArtistItemsList($userId) {
        $query = "SELECT * FROM " . $this->table['image'] . " WHERE artistId =  '$userId';";
        // $result = $this->getConnection()->query($query);

        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $results[] = $this->getConnection()->query('SELECT FOUND_ROWS();')->fetch(PDO::FETCH_COLUMN);
            $size = $this->getSizes();
            if ($stmt->rowCount() > 0) {
                foreach ($stmt->fetchAll() as $row) {
                    $size = $this->getSizes();
                    $results[] = array(
                        'imageId' => $row['imgId'],
                        'artistId' => $row['artistId'],
                        // 'artistName' => $row['pseudonym'],
                        'imageTitle' => $row['imgTitle'],
                        // 'imageDescription' => $row['descrip'],
                        'imageSize' => $size,
                        // 'listingStatus' => $row['status'],
                        'imageType' => $row['imgType']
                    );
                }
                return json_encode($results);
            }
        } catch (Exception $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * This function gets the user's first name given the user's username
     * @param type $username
     * @return String user's first name
     */

    public function getUserFirstName($username) {
        $query = "SELECT * FROM " . $this->table['user'] . " WHERE Username =  '$username';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['FirstName'];
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * 
     * @param String $username 
     * @return int Seller's user id
     */
    public function getArtistId($username) {
        $query = "SELECT UserID, Username FROM " . $this->table['user'] . " WHERE Username =  '$username';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['UserID'];
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /** This function gets the user's first name given the user's username
     * 
     */
    public function getUserInitials($username) {
        $query = "SELECT * FROM " . $this->table['user'] . " WHERE Username =  '$username';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $initials = strtoupper(substr($row['FirstName'], 0, 1) . substr($row['LastName'], 0, 1));
                return $initials;
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return false;
        }
        return false;
    }

    /**
     * This function inserts newly created data into database if no errors occur
     * 
     * @param String $username
     * @param String $password
     * @param String $firstname
     * @param String $lastname
     * @param String $email
     */
    public function createAccount($username, $password, $firstname, $lastname, $email) {
        $query = "INSERT INTO " . $this->table['user'] . "(Username,Password,FirstName,LastName,Email) VALUES('$username','$password','$firstname','$lastname','$email')";

        try {
            $this->getConnection()->exec($query);
            $success = "Account has been successfully.\\nYou can now login.";
            $auth = new authentication();
            $auth->createSession($username);
            ob_start();
            if (session_id() === '')
                session_start();
            //echo "<script type='text/javascript'>location.href='index.php';</script>";
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }

    }

    /**
     * This function insert newly created seller data into database
     * @param int $userId seller's user id
     * @param String $pseudonym artist's nickname
     */
    public function createSeller($userId, $pseudonym) {
        $query = "INSERT INTO " . $this->table['seller'] . "(userId,pseudonym) VALUES('$userId','$pseudonym')";

        try {
            $this->getConnection()->exec($query);
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }

    }

    /**
     * This function inserts newly created user data into database if no errors occur
     * 
     * @param String $username
     * @param String $password
     * @param String $firstname
     * @param String $lastname
     * @param String $email
     * @param String $phone
     * @param String $usertype
     */
    public function insertUser($username, $password, $firstname, $lastname, $email, $phone, $usertype) {
        $query = "INSERT INTO " . $this->table['user'] . " (Username, Password, FirstName, LastName, Email, Phone, UserType) VALUE('$username', '$password', '$firstname', '$lastname', '$email', '$phone', '$usertype')";

        try {
            $this->getConnection()->exec($query);
            $success = "Account has been created successfully.\\nYou can now login.";
            $auth = new authentication();
            $auth->createSession($username);
            ob_start();
            if (session_id() === '')
                session_start();
            echo "<script type='text/javascript'>location.href='index.php';</script>";
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }

    }

    /**
     * This function allows users to edit their first name
     * @param type $username string needed to check account
     * @param type $newFirstName new name string to replace old name
     */
    public function editFirstName($username, $newFirstName) {

        $query = "UPDATE " . $this->table['user'] . " SET FirstName='$newFirstName' WHERE Username='$username'";
        $result = $this->getConnection()->query($query);
        try {
            $this->getConnection()->exec($query);
            echo "<meta http-equiv='refresh' content='0'>";
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * This function returns user's first name
     * @param type $username string used to look for first name
     * @return boolean returns first name if it exists
     */
    public function getFirstName($username) {
        $query = "SELECT FirstName FROM " . $this->table['user'] . " WHERE Username =  '$username';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['FirstName'];
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return false;
        }
        return false;
    }

    /**
     * This function allows users to edit their last name
     * @param type $username string needed to check account
     * @param type $newLastName new last name string to replace old
     */
    public function editLastName($username, $newLastName) {

        $query = "UPDATE " . $this->table['user'] . " SET LastName='$newLastName' WHERE Username='$username'";
        $result = $this->getConnection()->query($query);
        try {
            $this->getConnection()->exec($query);
            echo "<meta http-equiv='refresh' content='0'>";
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * This function returns user's last name
     * @param type $username string used to look for last name
     * @return boolean returns last name if it exists
     */
    public function getLastName($username) {
        $query = "SELECT LastName FROM " . $this->table['user'] . " WHERE Username =  '$username';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['LastName'];
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return false;
        }
        return false;
    }

    /**
     * This function allows user to edit their email information
     * @param type $username string needed to check account
     * @param type $newEmail new email string to replace old
     */
    public function editEmail($username, $newEmail) {

        $query = "UPDATE " . $this->table['user'] . " SET Email='$newEmail' WHERE Username='$username'";
        $result = $this->getConnection()->query($query);
        try {
            $this->getConnection()->exec($query);
            echo "<meta http-equiv='refresh' content='0'>";
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * This function returns user's email
     * @param type $username string used to look for email
     * @return boolean returns email if it exists
     */
    public function getEmail($username) {
        $query = "SELECT Email FROM " . $this->table['user'] . " WHERE Username =  '$username';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['Email'];
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return false;
        }
        return false;
    }

    /**
     * This function allows users to edit their phone number 
     * @param type $username string needed to check account
     * @param type $newPhoneNumber new number string to replace old
     */
    public function editPhoneNumber($username, $newPhoneNumber) {

        $query = "UPDATE " . $this->table['user'] . " SET Phone='$newPhoneNumber' WHERE Username='$username'";
        $result = $this->getConnection()->query($query);
        try {
            $this->getConnection()->exec($query);
            echo "<meta http-equiv='refresh' content='0'>";
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * This function returns user's phone number
     * @param type $username string used to look for phone number
     * @return boolean returns phone number if it exists
     */
    public function getPhone($username) {
        $query = "SELECT Phone FROM " . $this->table['user'] . " WHERE Username =  '$username';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['Phone'];
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return false;
        }
        return false;
    }

    /**
     * This function returns user's password
     * @param type $username string needed to check account
     * @return boolean returns the password if it exists
     */
    public function getPassword($username) {
        $query = "SELECT Password FROM " . $this->table['user'] . " WHERE Username =  '$username';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['Password'];
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return false;
        }
        return false;
    }

    /**
     * This function allows users to edit their password
     * @param type $username string needed to check account
     * @param type $newPassword new string password to replace old
     */
    public function editPassword($username, $newPassword) {

        $query = "UPDATE " . $this->table['user'] . " SET Password='$newPassword' WHERE Username='$username'";
        $result = $this->getConnection()->query($query);
        try {
            $this->getConnection()->exec($query);
            echo "Your Password has succuessfully updated";
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * This function allows users to edit their pseudonym name
     * @param type $userId id needed to check seller account
     * @param type $newPseudonym new pseudonym string to repalce old
     */
    public function editPseudonym($userId, $newPseudonym) {

        $query = "UPDATE " . $this->table['seller'] . " SET pseudonym='$newPseudonym' WHERE userId='$userId'";
        $result = $this->getConnection()->query($query);
        try {
            $this->getConnection()->exec($query);
            echo "<meta http-equiv='refresh' content='0'>";
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * This function returns user's pseudonym
     * @param type $userId string used to look for pseudonym
     * @return boolean returns pseudonym if it exists
     */
    public function getPseudonym($userId) {
        $query = "SELECT pseudonym FROM " . $this->table['seller'] . " WHERE userId =  '$userId';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['pseudonym'];
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return false;
        }
        return false;
    }

    /**
     * This function allows users to edit their biography 
     * @param type $userId id need to check seller accounts
     * @param type $newBiography new biography string to replace old
     */
    public function editBiography($userId, $newBiography) {

        $query = "UPDATE " . $this->table['seller'] . " SET bio='$newBiography' WHERE userId='$userId'";
        $result = $this->getConnection()->query($query);
        try {
            $this->getConnection()->exec($query);
            echo "<meta http-equiv='refresh' content='0'>";
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
        }
    }

    /**
     * This function returns user's biography
     * @param type $userId string used to look for biography
     * @return boolean returns biography if it exists
     */
    public function getBiography($userId) {
        $query = "SELECT bio FROM " . $this->table['seller'] . " WHERE userId =  '$userId';";
        try {
            $stmt = $this->getConnection()->prepare($query);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row['bio'];
            }
        } catch (PDOException $e) {
            echo "Query failed:  " . $query . "<br>" . $e->getMessage();
            return false;
        }
        return false;
    }

    /*     * ********************* End of User Info Session ********************************** */
}
