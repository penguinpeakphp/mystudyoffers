<?php
    require_once "../admin/database/db.php";
    require_once "globalfunctions.php";

    try
    {
        $response["success"] = true;

        if(checksession($response) == false)
        {
            goto end;
        }

        $insert = $db->prepare("INSERT INTO student(name , surname , phone , email , pincode) VALUES(? , ? , ? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error Occurred while creating student account");
            goto end;
        }
        else
        {
            $insert->bind_param("sssss" , $_POST["name"] , $_POST["surname"] , $_POST["phone"] , $_POST["email"] , $_POST["pincode"]);
            if($insert->execute() == false)
            {
                failure($response , "Error Occurred while creating student account");
                goto end;
            }
        }

        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage());
    }

    echo json_encode($response);
?>