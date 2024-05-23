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

        //Query the database to fetch the university data status
        $select = $db->prepare("SELECT * FROM universitydatastatus WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university data status");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university data status");
                goto end;
            }
            else
            {
                //Fetch the result and add it to the response
                $result = $select->get_result();
                $row = $result->fetch_assoc();
                $response["universitydatastatus"] = $row;
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