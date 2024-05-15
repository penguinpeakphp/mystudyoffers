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
      

        if(isset($_POST["universityinformation"]))
        {
            $db->begin_transaction();

            $_POST["courselevelsoffered"] = json_decode($_POST["courselevelsoffered"]);
            $_POST["othercampus"] = json_decode($_POST["othercampus"]);

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
                $insert->bind_param("sssssssisss" , $_POST["universityname"] , $_POST["universitylicensenumber"] , $_POST["keycontactname"] , $_POST["keycontactdesignation"] , $_POST["keycontactemail"] , $_POST["yearestablishment"] , $_POST["overview"] , $_POST["maincampuscity"] , $_POST["maincampusstreetaddress"] , $_POST["maincampuspostcode"], $_POST["universityimage"]);

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