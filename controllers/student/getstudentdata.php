<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check in the session if the user has logged in
        if(checksession($response) == false)
        {
            goto end;
        }

        //Declare array for storing student data
        $response["studentdata"] = [];

        //Query the database for fetching the basic student details
        $select = $db->prepare("SELECT studentid , name , surname , phone , email , pincode , activationtoken , profilestatus FROM student WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while getting student details");
            goto end;
        }
        else
        {
            $select->bind_param("i" , $_SESSION["studentid"]);
            if($select->execute() == false)
            {
                failure($response , "Error while getting student details");
                goto end;
            }
            $result = $select->get_result();
            $row = $result->fetch_assoc();

            //Put the data in the response
            $response["studentdata"] = $row;
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching student data - " . $e->getCode());
    }

    echo json_encode($response);
?>