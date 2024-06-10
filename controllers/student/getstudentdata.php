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
        $select = $db->prepare("SELECT studentid , name , surname , phone , email , pincode , activationtoken , profilestatus , phoneverified , profilepic, address, parentname, parentemail, parentphone, gender, birthdate, staticcountryid, staticstateid, staticcityid FROM student WHERE studentid = ?");
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

        $select = $db->prepare("SELECT avatarimage FROM student s INNER JOIN avatar a ON s.avatarid = a.avatarid WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while getting student avatar");
            goto end;
        }
        else
        {
            $select->bind_param("i" , $_SESSION["studentid"]);
            if($select->execute() == false)
            {
                failure($response , "Error while getting student avatar");
                goto end;
            }
            $result = $select->get_result();
            $row = $result->fetch_assoc();
            $response["studentdata"]["avatarimage"] = $row["avatarimage"];
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching student data");
    }

    echo json_encode($response);
?>