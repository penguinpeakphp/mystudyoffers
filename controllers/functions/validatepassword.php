<?php

    //Function for validating the password
    function validatePassword(&$response , $password) 
    {
        // Check if the password is at least 8 characters long
        if (strlen($password) < 8) {
            failure($response , "Password must be at least 8 characters long.");
            return false;
        }
    
        // Check if the password contains at least one number
        if (!preg_match('/\d/', $password)) {
            failure($response , "Password must contain at least one number.");
            return false;
        }
    
        // Check if the password contains at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            failure($response , "Password must contain at least one uppercase letter.");
            return false;
        }
    
        // Check if the password contains at least one special character
        if (!preg_match('/[\W_]/', $password)) {
            failure($response , "Password must contain at least one special character.");
            return false;
        }
    
        // If all checks pass, the password is valid
        return true;
    }
?>