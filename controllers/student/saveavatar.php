<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";
    require_once "../functions/validatepassword.php";

    try
    {
        $response["success"] = true;

        //Check in the session if the user has logged in
        if(checksession($response) == false)
        {
            goto end;
        }

        if(!isset($_POST["avatarid"]))
        {
            failure($response , "All fields are required");
            goto end;
        }

        $update = $db->prepare("UPDATE student SET avatarid = ? WHERE studentid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the avatar");
            goto end;
        }
        else
        {
            $update->bind_param("ii" , $_POST["avatarid"] , $_SESSION["studentid"]);

            //Execute the query
            if($update->execute() == false)
            {
                failure($response , "Error while updating the avatar");
                goto end;
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred : " . $e->getCode());
    }

    echo json_encode($response);
?>