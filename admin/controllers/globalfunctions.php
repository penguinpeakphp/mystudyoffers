<?php
    //Function for updating the response variable for the error
    function failure(&$response , $error)
    {
        $response["success"] = false;
        $response["error"] = $error;
    }

    //Function for checking the session and taking action accordingly
    function checksession(&$response = null)
    {
        //Start the session if the session is not
        if (!isset($_SESSION)) 
        {
            session_start();
        }

        //Check if the email in the session is set
        if (!isset($_SESSION["email"])) 
        {
            //If the response variable is null, that means this
            //function is called at the page itself and we just
            //need to redirect to login page
            if(!is_null($response))
            {
                $response["success"] = false;
                $response["error"] = "You are not logged in";
                $response["login"] = true;
                return false;
            }
            else
            {
                //Redirect to the login page
                header("Location: ../login/login.php");
            }
        }
    
        return true;
    }

    function getcountries(&$response , &$countries)
    {
        global $db;
        $result = $db->query("SELECT * FROM country");
        if($result == false)
        {
            failure($response , "Error while fetching countries");
            return false;
        }
        while($row = $result->fetch_assoc())
        {
            array_push($countries , $row);
        }

        return true;
    }

    function getstates(&$response , &$states)
    {
        global $db;
        $result = $db->query("SELECT * FROM state");
        if($result == false)
        {
            failure($response , "Error while fetching states");
            return false;
        }
        while($row = $result->fetch_assoc())
        {
            array_push($states , $row);
        }

        return true;
    }
?>