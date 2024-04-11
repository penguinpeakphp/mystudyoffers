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
        if (!isset($_SESSION["adminemail"])) 
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

    //Function for fetching the list of countries into the variable
    function getcountries(&$response , &$countries)
    {
        //Access the global variable
        global $db;

        //Query the database for fetching all the countries
        $result = $db->query("SELECT * FROM country");
        if($result == false)
        {
            failure($response , "Error while fetching countries");
            return false;
        }

        //Push data into the array variable
        while($row = $result->fetch_assoc())
        {
            array_push($countries , $row);
        }

        return true;
    }

    //Function for fetching the list of states into the variable
    function getstates(&$response , &$states)
    {
        //Access the global variable
        global $db;

        //Query the database for fetching all the states
        $result = $db->query("SELECT * FROM state");
        if($result == false)
        {
            failure($response , "Error while fetching states");
            return false;
        }

        //Push data into the array variable
        while($row = $result->fetch_assoc())
        {
            array_push($states , $row);
        }

        return true;
    }

    //Function for fetching the list of academics into the variable
    function getacademics(&$response , &$academics)
    {
        //Access the global variable
        global $db;

        //Query the database for fetching all the academics
        $result = $db->query("SELECT * FROM academic");
        if($result == false)
        {
            failure($response , "Error while fetching academic qualifications");
            return false;
        }

        //Push data into the array variable
        while($row = $result->fetch_assoc())
        {
            array_push($academics , $row);
        }

        return true;
    }
?>