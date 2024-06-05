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
        if(!isset($_POST["avatarid"]) || !isset($_POST["avatarname"]) || !isset($_POST["avatarstatus"]) || $_POST["avatarname"] == "" || $_POST["avatarstatus"] == "" || $_POST["avatarid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        $db->begin_transaction();

        $oldfilename = "";

        $select = $db->prepare("SELECT avatarimage FROM avatar WHERE avatarid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching avatar");
            $db->rollback();
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("i" , $_POST["avatarid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching avatar");
                $db->rollback();
                goto end;
            }

            //Get the result
            $result = $select->get_result();
            $row = $result->fetch_assoc();
            $oldfilename = $row["avatarimage"];
        }

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

            //Delete the old image
            if($oldfilename != "")
            {
                if(unlink("../../avatarimages/" . $oldfilename) == false)
                {
                    failure($response , "Error while deleting old image");
                    $db->rollback();
                    goto end;
                }
            }

            //Query the database to update the existing avatar based on the avatar id
            $update = $db->prepare("UPDATE avatar SET avatarname = ? , avatarimage = ? , avatarstatus = ? WHERE avatarid = ?");
            //Bind the data with the query
            $update->bind_param("ssii" , $_POST["avatarname"] , $filename , $_POST["avatarstatus"] , $_POST["avatarid"]);
        }
        else
        {
            //Query the database to update the existing avatar based on the avatar id
            $update = $db->prepare("UPDATE avatar SET avatarname = ? , avatarstatus = ? WHERE avatarid = ?");
            //Bind the data with the query
            $update->bind_param("sii" , $_POST["avatarname"] , $_POST["avatarstatus"] , $_POST["avatarid"]);
        }
        
        if($update->execute() == false)
        {
            failure($response , "Error while updating the avatar");
            $db->rollback();
            goto end;
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