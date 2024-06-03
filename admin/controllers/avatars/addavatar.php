<?php
    require_once "../../database/db.php";
    require_once "../globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check session and go to end if session verification is failed
        if(checksession($response) == false)
        {
            goto end;
        }

        //Check if all the fields are set and have some value
        if(!isset($_POST["avatarname"]) || !isset($_POST["avatarstatus"]) || !isset($_POST["avatargender"]) || $_POST["avatargender"] == "" || $_POST["avatarname"] == "" || $_POST["avatarstatus"] == "" || $_FILES["avatarimage"]["name"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        $db->begin_transaction();

        $filename;

        //Upload the files to the server
        if(isset($_FILES["avatarimage"]) && $_FILES["avatarimage"]["name"] != "")
        {
            //Extract the file extension
            $ext = pathinfo($_FILES["avatarimage"]["name"] , PATHINFO_EXTENSION);
            if($ext != "jpg" && $ext != "jpeg" && $ext != "png")
            {
                failure($response , "Only jpg, jpeg and png files are allowed");
                $db->rollback();
                goto end;
            }

            //Create unique avatar name with uuid()
            $filename = uniqid() . "." . $ext;

            //Move uploaded file
            if(move_uploaded_file($_FILES["avatarimage"]["tmp_name"] , "../../avatarimages/" . $filename) == false)
            {
                failure($response , "Error while uploading avatar image");
                $db->rollback();
                goto end;
            }
        }

        //Query the database for inserting avatar into the database
        $insert = $db->prepare("INSERT INTO avatar(avatarname , avatargender , avatarimage , avatarstatus) VALUES(? , ? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the avatar");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the country name and status
            $insert->bind_param("sssi" , $_POST["avatarname"] , $_POST["avatargender"] , $filename , $_POST["avatarstatus"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the avatar");
                $db->rollback();
                goto end;
            }
        }

        if($response["success"] == true)
        {
            $db->commit();
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