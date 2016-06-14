<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of authorization
 * This class is used to handle user login and user account creation.
 * 
 * @author raymond
 */
class authentication {

    public function __construct() {
        
    }

    /**
     * This function is used to verify weather or not use has entered the same
     * password twice during account creation
     * 
     * @param String $psw password entered during account creation
     * @param String $pswc password confirmation entered during account creation
     * @return boolean returns true if both entered passwords are the same or
     * false if they are not the same
     */
    public function passwordConfirmation($psw, $pswc) {
        if ($psw !== $pswc) {
            echo "The password you have entered does not match<br>";
            return false;
        } else {
            return true;
        }
    }

    /**
     * This fucntion creates a session for logged in user
     * 
     * @param String $username used to create session with current user
     */
    public function createSession($username) {

        $_SESSION['username'] = $username;
    }

    /**
     * This function is used to check and display errors during user registration
     * 
     * @param boolean $exist used to check if username already exists in database
     * @return boolean returns true if username already exists or false if username
     * does not exist
     */
    public function createErrors($exist) {
        if ($exist === true) {
            $alreadyExist = "Username already exist.\\nTry again.";
            echo "<script type='text/javascript'>alert('$alreadyExist');</script>";
            return true;
        } else {
            return false;
        }
    }

    /**
     * This function is used to verify user login information
     * 
     * @param boolean $exist variable used for checking if username entered exists
     * @param boolean $correct variable used for checking if username and password match
     * @return boolean
     */
    public function checkLogin($exist, $correct) {
        if ($correct === true) {
            return true;
        } else if ($exist === false) {
            $notExist = "The Username you entered does not exist.\\nTry again.";
            echo "<script type='text/javascript'>alert('$notExist');</script>";
        } else {
            $typeError = "Username and/or Password incorrect.\\nTry again.";
            echo "<script type='text/javascript'>alert('$typeError');</script>";
        }
        return false;
    }

}
