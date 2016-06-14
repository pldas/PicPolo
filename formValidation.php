<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class formValidation {

    public function __construct() {
        
    }

    public function test_input($data) {
        $dataTrim = trim($data);
        $dataStrip = stripslashes($dataTrim);
        $dataHSC = htmlspecialchars($dataStrip);
        return $dataHSC;
    }

    public function lettersOnly($data) {
        $err = "";
        if (!preg_match("/^[a-zA-Z ]*$/", $data)) {
            $err = "Only letters and white space allowed";
        }
        return $err;
    }

    public function emailFormat($data) {
        $err = "";
        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            $err = "Invalid email format";
        }
        return $err;
    }

    public function passwordCheck($data1, $data2) {
        $err = "";
        if ($data1 !== $data2) {
            $err = "Password you entered does not match";
        }
        return $err;
    }
    
        public function alphanumeric($data) {
        $err = "";
        if (!preg_match("/^[a-zA-Z\d ]*$/", $data)) {
            $err = "Only letters, numbers and white space allowed";
        }
        return $err;
    }

}

?>
