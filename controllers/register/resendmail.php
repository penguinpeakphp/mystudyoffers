<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";
    require_once "../functions/mailfunction.php";

    try
    {
        $response["success"] = true;

        //Generate the unique activation token which will be used for activating the account
        $activationtoken = uniqid();

        //Update the activation code of the student
        $update = $db->prepare("UPDATE student SET activationtoken = ? WHERE studentid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the activation token");
            goto end;
        }
        else
        {
            $update->bind_param("si" , $activationtoken , $_POST["id"]);
            if($update->execute() == false)
            {
                failure($response , "Error while updating the activation token");
                goto end;
            }
        }

        if(sendactivationmail($_POST["email"] , "Verify your email - MyStudyOffers.com" , $activationtoken , $_POST["id"]) == false)
        {
            failure($response , "Error sending activation email");
            goto end;
        }
        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error while updating the activation token - " . $e->getCode());
    }

    echo json_encode($response);
?>