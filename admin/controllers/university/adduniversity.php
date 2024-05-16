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
      

        //First step of adding university
        if(isset($_POST["universityinformation"]))
        {            
            //Check if the university is not provided. If provided, then the user has already added current university on this page
            if(isset($_POST["universityid"]) && $_POST["universityid"] != "")
            {
                failure($response , "You need to reload to add new university or go to edit section to update current university");
                goto end;
            }

            //If the file has been attached, then assign the name to $_POST variable
            $filename = "";
            if(isset($_FILES["universityimage"]["name"]))
            {
                //Set the file name as time() with the same extension as before
                $filename = "universityimage.".pathinfo($_FILES["universityimage"]["name"] , PATHINFO_EXTENSION);
            }

            $db->begin_transaction();

            //Decode the json string
            $_POST["courselevelsoffered"] = json_decode($_POST["courselevelsoffered"]);
            $_POST["othercampus"] = json_decode($_POST["othercampus"]);

            //Query the database for inserting university
            $insert = $db->prepare("INSERT INTO university(universityname , universitylicensenumber,
            keycontactname,
            keycontactdesignation,
            keycontactemail,
            yearestablishment,
            overview,
            maincampuscityid ,
            maincampusstreetaddress,
            maincampuspostcode,
            universityimage) VALUES(? , ? , ? , ? , ? , ? , ? , ? , ? , ? , ?)");

            if($insert == false)
            {
                failure($response , "Error while adding university information");
                $db->rollback();
                goto end;
            }
            else
            {
                //Bind the parameters
                $insert->bind_param("sssssssisss" , $_POST["universityname"] , $_POST["universitylicensenumber"] , $_POST["keycontactname"] , $_POST["keycontactdesignation"] , $_POST["keycontactemail"] , $_POST["yearestablishment"] , $_POST["overview"] , $_POST["maincampuscity"] , $_POST["maincampusstreetaddress"] , $_POST["maincampuspostcode"], $filename);

                //Execute the query
                if($insert->execute() == false)
                {
                    failure($response , "Error while adding university information");
                    $db->rollback();
                    goto end;
                }
            }

            //Query the database for fetching last insert id of university
            $select = $db->query("SELECT (next_id-1) AS nextid FROM id_generator WHERE prefix = 'university'");
            if($select == false)
            {
                failure($response , "Error while fetching university ID");
                $db->rollback();
                goto end;
            }

            //Get the last insert id
            $row = $select->fetch_assoc();
            $universityid = "university-".$row["nextid"];

            //Append university id in the response
            $response["universityid"] = $universityid;

            //Check if directory of particular location already exists, if not create directory with the name as university id
            if(!is_dir("../../universitydata/".$universityid))
            {
                //Create the directory with name as universityid
                if(mkdir("../../universitydata/".$universityid) == false)
                {
                    failure($response , "Error while creating university directory");
                    $db->rollback();
                    goto end;
                }

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
            }

            //Loop through all the course levels offered and insert into the database
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

        //Second step of adding university
        if(isset($_POST["universityintellectualassets"]))
        {
            
            if(isset($_POST["universityid"]) && $_POST["universityid"] == "")
            {
                failure($response , "Error while adding unversity intellectual assets due to missing ID");
                goto end;
            }

            //Decode the json string
            $_POST["otherteamsandclubs"] = json_decode($_POST["otherteamsandclubs"]);

            //Check if directory of particular location already exists, if not create directory with the name as university id
            $universityid = $_POST["universityid"];
            if(!is_dir("../../universitydata/".$universityid))
            {
                //Create the directory with name as universityid
                if(mkdir("../../universitydata/".$universityid) == false)
                {
                    failure($response , "Error while creating university directory");
                    $db->rollback();
                    goto end;
                }
            }

            //Set the logo image and mascot image names if uploaded
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
                    $db->rollback();
                    goto end;
                }
            }
            if(isset($_FILES["mascotimage"]))
            {
                //Set the file name as time() with the same extension as before
                $mascotimagename = "mascotimage.".pathinfo($_FILES["mascotimage"]["name"] , PATHINFO_EXTENSION);

                //Upload the file with the new name
                if(move_uploaded_file($_FILES["mascotimage"]["tmp_name"] , "../../universitydata/".$universityid."/".$mascotimagename) == false)
                {
                    failure($response , "Error while uploading mascot image");
                    $db->rollback();
                    goto end;
                }
            }

            $db->begin_transaction();

            //Query the database for inserting data into university assets
            $insert = $db->prepare("INSERT INTO universityassets(universityid , logoimage , mascotimage) VALUES(? , ? , ?)");
            if($insert == false)
            {
                failure($response , "Error while adding university intellectual assets");
                $db->rollback();
                goto end;
            }
            else
            {
                //Bind the parameters
                $insert->bind_param("sss" , $universityid , $logoimagename , $mascotimagename);

                //Execute the query
                if($insert->execute() == false)
                {
                    failure($response , "Error while adding university intellectual assets");
                    $db->rollback();
                    goto end;
                }
            }

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
                $i = 0;
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

        //Third step of adding university
        if(isset($_POST["universityrankings"]))
        {
            
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