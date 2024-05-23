<?php
    require_once "../../database/db.php";
    require_once "../globalfunctions.php";
    require_once "functions.php";

    try
    {
        $response["success"] = true;

        function deleteolddata($tablename , $universityid)
        {
            global $db;

            //Query the database for deleting old course levels
            $delete = $db->prepare("DELETE FROM {$tablename} WHERE universityid = ?");
            if($delete == false)
            {
                failure($response , "Error while deleting old course levels");
                $db->rollback();
                return false;
            }
            else
            {
                //Bind the parameters
                $delete->bind_param("s" , $universityid);

                //Execute the query
                if($delete->execute() == false)
                {
                    failure($response , "Error while deleting old course levels");
                    $db->rollback();
                    return false;
                }
            }

            return true;
        }

        //Check session and go to end if session verification is failed
        if(checksession($response) == false)
        {
            goto end;
        }

        if(!isset($_POST["universityid"]) && $_POST["universityid"] == "")
        {
            failure($response , "University ID is missing");
            goto end;
        }

        $universityid = $_POST["universityid"];

        //First step of editing university
        if(isset($_POST["universityinformation"]))
        {
            //If the file has been attached, then assign the name to $_POST variable
            $filename = "";
            if(isset($_FILES["universityimage"]["name"]))
            {
                //Set the file name as time() with the same extension as before
                $filename = "universityimage.".pathinfo($_FILES["universityimage"]["name"] , PATHINFO_EXTENSION);
            }
            else
            {
                $filename = $_POST["olduniversityimagename"];
            }

            $db->begin_transaction();

            //Decode the json string
            $_POST["courselevelsoffered"] = json_decode($_POST["courselevelsoffered"]);
            $_POST["othercampus"] = json_decode($_POST["othercampus"]);

            //Query the database for updating university information
            $update = $db->prepare("UPDATE university SET universityname = ? , universitylicensenumber = ? , keycontactname = ? , keycontactdesignation = ? , keycontactemail = ? , yearestablishment = ? , overview = ? , maincampuscityid = ? , maincampusstreetaddress = ? , maincampuspostcode = ? , universityimage = ? , universitystatus = ? WHERE universityid = ?");
            if($update == false)
            {
                failure($response , "Error while updating university information");
                $db->rollback();
                goto end;
            }
            else
            {
                //Bind the parameters
                $update->bind_param("sssssssisssis" , $_POST["universityname"] , $_POST["universitylicensenumber"] , $_POST["keycontactname"] , $_POST["keycontactdesignation"] , $_POST["keycontactemail"] , $_POST["yearestablishment"] , $_POST["overview"] , $_POST["maincampuscity"] , $_POST["maincampusstreetaddress"] , $_POST["maincampuspostcode"], $filename , $_POST["universitystatus"] , $_POST["universityid"]);

                //Execute the query
                if($update->execute() == false)
                {
                    failure($response , "Error while updating university information");
                    $db->rollback();
                    goto end;
                }
            }

            //Check and create directory
            if(!createdir($universityid))
            {
                failure($response , "Error while creating university directory");
                $db->rollback();
                goto end;
            }

            //Check if the file has been attached
            if(isset($_FILES["universityimage"]))
            {
                //Upload the file with the new name
                if(move_uploaded_file($_FILES["universityimage"]["tmp_name"] , "../../universitydata/".$universityid."/".$filename) == false)
                {
                    failure($response , "Error while uploading university image");
                    $db->rollback();
                    goto end;
                }
            }

            //Delete old of course levels
            deleteolddata("universitylevelofcourse" , $universityid);

            //Loop through the course levels offered and insert into database
            foreach($_POST["courselevelsoffered"] as $levelofcourse)
            {
                //Query the database to insert level of courses
                $insert = $db->prepare("INSERT INTO universitylevelofcourse(universityid , levelofcourseid) VALUES(? , ?)");
                if($insert == false)
                {
                    failure($response , "Error while adding university level of courses");
                    $db->rollback();
                    goto end;
                }
                else
                {
                    //Bind the parameters
                    $insert->bind_param("si" , $universityid , $levelofcourse);

                    //Execute the query
                    if($insert->execute() == false)
                    {
                        failure($response , "Error while adding university level of courses");
                        $db->rollback();
                        goto end;
                    }
                }
            }

            //Delete old data of other campus
            deleteolddata("othercampusaddress" , $universityid);

            //Loop through all the other campus data and insert into the database
            foreach($_POST["othercampus"] as $othercampus)
            {
                //Query the database to insert other campus data
                $insert = $db->prepare("INSERT INTO othercampusaddress(universityid , othercampuscityid , othercampusstreetaddress , othercampuspostcode) VALUES(? , ? , ? , ?)");
                if($insert == false)
                {
                    failure($response , "Error while adding other campus data");
                    $db->rollback();
                    goto end;
                }
                else
                {
                    //Bind the parameters
                    $insert->bind_param("siss" , $universityid , $othercampus->othercampuscity , $othercampus->othercampusstreetaddress , $othercampus->othercampuspostcode);

                    //Execute the query
                    if($insert->execute() == false)
                    {
                        failure($response , "Error while adding other campus data");
                        $db->rollback();
                        goto end;
                    }
                }
            }    
        }

        //Second step of editing university
        if(isset($_POST["universityintellectualassets"]))
        {
            //Check for university id
            if(!checkuniversityid())
            {
                failure($response , "Error while editing university intellectual assets due to missing ID");
                goto end;
            }

            //Decode the json string
            $_POST["otherteamsandclubs"] = json_decode($_POST["otherteamsandclubs"]);

            $university = $_POST["universityid"];

            //Check and create directory
            if(!createdir($universityid))
            {
                failure($response , "Error while creating university directory");
                goto end;
            }

            //Set the logo image and mascot image if uploaded
            $logoimagename = "";
            $mascotimagename = "";
            if(isset($_FILES["logoimage"]))
            {
                //Set the file name as time() with the same extension as before
                $logoimagename = "logoimage.".pathinfo($_FILES["logoimage"]["name"] , PATHINFO_EXTENSION);

                //Upload the file with the new name
                if(move_uploaded_file($_FILES["logoimage"]["tmp_name"] , "../../universitydata/".$universityid."/".$logoimagename) == false)
                {
                    failure($response , "Error while uploading logo image");
                    goto end;
                }
            }
            else
            {
                $logoimagename = $_POST["oldlogoimagename"];
            }
            if(isset($_FILES["mascotimage"]))
            {
                //Set the file name as time() with the same extension as before
                $mascotimagename = "mascotimage.".pathinfo($_FILES["mascotimage"]["name"] , PATHINFO_EXTENSION);

                //Upload the file with the new name
                if(move_uploaded_file($_FILES["mascotimage"]["tmp_name"] , "../../universitydata/".$universityid."/".$mascotimagename) == false)
                {
                    failure($response , "Error while uploading mascot image");
                    goto end;
                }
            }
            else
            {
                $mascotimagename = $_POST["oldmascotimagename"];
            }

            $db->begin_transaction();

            //Query the database to update the university assets
            $update = $db->prepare("UPDATE universityassets SET logoimage = ? , mascotimage = ? WHERE universityid = ?");
            if($update == false)
            {
                failure($response , "Error while editing university assets");
                $db->rollback();
                goto end;
            }
            else
            {
                //Bind the parameters
                $update->bind_param("ssi" , $logoimagename , $mascotimagename , $universityid);

                //Execute the query
                if($update->execute() == false)
                {
                    failure($response , "Error while editing university assets");
                    $db->rollback();
                    goto end;
                }
            }

            //Delete old data of other teams and clubs
            deleteolddata("universityclubsandteams" , $universityid);

            //Loop through all the other teams and clubs data and insert into the database
            foreach($_POST["otherteamsandclubs"] as $teamandclub)
            {
                //Query the database to insert other teams and clubs
                $insert = $db->prepare("INSERT INTO universityclubsandteams(universityid , clubsandteams) VALUES(? , ?)");
                if($insert == false)
                {
                    failure($response , "Error while adding other teams and clubs");
                    $db->rollback();
                    goto end;
                }
                else
                {
                    //Bind the parameters
                    $insert->bind_param("ss" , $universityid , $teamandclub);

                    //Execute the query
                    if($insert->execute() == false)
                    {
                        failure($response , "Error while adding other teams and clubs");
                        $db->rollback();
                        goto end;
                    }
                }
            }

            if(isset($_FILES["facilityimages"]))
            {
                $i = $_POST["oldfacilityimagecount"];
                foreach($_FILES['facilityimages']["name"] as $facilityimage)
                {
                    $facilityimagename = "facilityimage{$i}.".pathinfo($facilityimage , PATHINFO_EXTENSION);
                    //Move the file to the directory
                    if(move_uploaded_file($_FILES["facilityimages"]["tmp_name"][$i] , "../../universitydata/".$universityid."/".$facilityimagename) == false)
                    {
                        failure($response , "Error while uploading facility images");
                        $db->rollback();
                        goto end;
                    }

                    //Query the database to insert facility images
                    $insert = $db->prepare("INSERT INTO universityfacilityimages(universityid , image) VALUES(? , ?)");
                    if($insert == false)
                    {
                        failure($response , "Error while adding facility images");
                        $db->rollback();
                        goto end;
                    }
                    else
                    {
                        //Bind the parameters
                        $insert->bind_param("ss" , $universityid , $facilityimagename);

                        //Execute the query
                        if($insert->execute() == false)
                        {
                            failure($response , "Error while adding facility images");
                            $db->rollback();
                            goto end;
                        }
                    }
                    $i++;
                }
            }

        }

        if($response["success"] == true)
        {
            $db->commit();
        }

        end:;
    }
    catch(Exception $e)
    {
        $response["success"] = false;
        $response["error"] = "Some Error Occurred - " . $e->getCode() . " - " . $e->getMessage();
    }

    echo json_encode($response);
?>