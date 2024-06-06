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
        if(!isset($_POST["countryid"]) || !isset($_POST["countryname"]) || !isset($_POST["status"]) || !isset($_FILES["flagimage"]) || $_POST["countryname"] == "" || $_POST["status"] == "" || $_POST["countryid"] == "")
        {
            failure($response , "Please fill all the fields");
            goto end;
        }

        $filename = "";

        if(isset($_FILES["flagimage"]) && $_FILES["flagimage"]["name"] != "")
        {
            //Query the database to fetch the existing filename
            $select = $db->prepare("SELECT flagimage FROM country WHERE countryid = ?");
            if($select == false)
            {
                failure($response , "Error while fetching the country flag image");
                goto end;
            }
            else
            {
                //Bind the country id
                $select->bind_param("i" , $_POST["countryid"]);

                //Execute the query
                if($select->execute() == false)
                {
                    failure($response , "Error while fetching the country flag image");
                    goto end;
                }

                //Get the result
                $result = $select->get_result();
                $row = $result->fetch_assoc();

                $oldfilename = $row["flagimage"];

                //Delete the old image
                if($oldfilename != "")
                {
                    if(unlink("flagimages/" . $oldfilename) == false)
                    {
                        failure($response , "Error while deleting the old flag image");
                        goto end;
                    }
                }
            }

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

        //Query the database to update the existing country based on the country id
        $update = $db->prepare("UPDATE country SET countryname = ? , flagimage = ? , status = ? WHERE countryid = ?");
        if($update == false)
        {
            failure($response , "Error while updating the country");
            goto end;
        }
        else
        {
            //Bind the data with the query
            $update->bind_param("ssii" , $_POST["countryname"] , $filename , $_POST["status"] , $_POST["countryid"]);

            //Execute the query
            if($update->execute() == false)
            {
                failure($response , "Error while updating the country");
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