<?php
    require_once "../../database/db.php";
    require_once "../globalfunctions.php";
    require_once "functions.php";

    try
    {
        $response["success"] = true;

        //Check session and go to end if session verification is failed
        if(checksession($response) == false)
        {
            goto end;
        }

        //Declare array for storing university information
        $response["university"] = [];

        //Query the database to fetch the basic information of the university
        $select = $db->prepare("SELECT * FROM university WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university information");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university information");
                goto end;
            }

            //Get the result
            $result = $select->get_result();
            $row = $result->fetch_assoc();
            $response["university"] = $row;
        }

        $response["othercampusaddresses"] = [];
        //Query the database to fetch the other campus
        $select = $db->prepare("SELECT * FROM othercampusaddress WHERE universityid = ?");
        if($select == false)
        {
            failure($resposne , "Error while fetching university information");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($resposne , "Error while fetching university information");
                goto end;
            }

            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["othercampusaddresses"] , $row);
            }
        }

        end:;
    }
    catch(Exception  $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>