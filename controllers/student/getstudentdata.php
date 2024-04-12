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

        $response["studentdata"];
        $select = $db->prepare("SELECT * FROM student WHERE studentid = ?");
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
            $response["studentdata"] = $row;
        }

        end:;
    }
    catch(Exception $e)
    {

    }
?>