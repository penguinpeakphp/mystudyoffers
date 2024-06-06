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
        if(!isset($_POST["countryname"]) || !isset($_POST["status"]) || !isset($_FILES["flagimage"]) || $_POST["countryname"] == "" || $_POST["status"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        $filename = "";

        if(isset($_FILES["flagimage"]) && $_FILES["flagimage"]["name"] != "")
        {
            //Get the extension of image
            $extension = pathinfo($_FILES["flagimage"]["name"] , PATHINFO_EXTENSION);

            //Set the unique filename for the image
            $filename = uniqid() . "." . $extension;

            //Move the files to the directory
            if(move_uploaded_file($_FILES["flagimage"]["tmp_name"] , "flagimages/" . $filename) == false)
            {
                failure($response , "Error while uploading the flag image");
                goto end;
            }
        }

        //Query the database for inserting country into the database
        $insert = $db->prepare("INSERT INTO country(countryname , flagimage , status) VALUES(? , ? , ?)");
        if($insert == false)
        {
            failure($response , "Error while adding the country");
            goto end;
        }
        else
        {
            //Bind the country name and status
            $insert->bind_param("ssi" , $_POST["countryname"] , $filename , $_POST["status"]);
            if($insert->execute() == false)
            {
                failure($response , "Error while adding the country");
                goto end;
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