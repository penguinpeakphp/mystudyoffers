<?php
    require_once "../../database/db.php";
    require_once "../globalfunctions.php";
    require_once "functions.php";

    try
    {
        $response["success"] = true;

        //Check session and go to end if session verification is failed
        if(checksession($response) == false)
        {
            goto end;
        }

        //Query the database to fetch the university data status
        $select = $db->prepare("SELECT * FROM universitydatastatus WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university data status");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {   
                failure($response , "Error while fetching university data status");
                goto end;
            }   

            $result = $select->get_result();
            $row = $result->fetch_assoc();
            $response["universitydatastatus"] = $row;
        }

        //Query the database to fetch the basic information of the university
        $select = $db->prepare("SELECT * FROM university WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university information");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university information");
                goto end;
            }

            //Get the result
            $result = $select->get_result();
            $row = $result->fetch_assoc();
            $response["university"] = $row;
        }

        $response["othercampusaddresses"] = [];
        //Query the database to fetch the other campus
        $select = $db->prepare("SELECT * FROM othercampusaddress WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university information");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university information");
                goto end;
            }

            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["othercampusaddresses"] , $row);
            }
        }

        //Declare array for storing level of courses of university
        $response["universitylevelofcourses"] = [];

        //Query the database to fetch the level of courses
        $select = $db->prepare("SELECT levelofcourseid FROM universitylevelofcourse WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university information");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university information");
                goto end;
            }

            //Loop through the result and push the data into the array
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["universitylevelofcourses"] , $row["levelofcourseid"]);
            }
        }
        
        //Query the database to fetch the university intellectual assets
        $select = $db->prepare("SELECT * FROM universityassets WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university assets");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university assets");
                goto end;
            }

            $result = $select->get_result();
            $row = $result->fetch_assoc();
            $response["universityassets"] = $row;
        }

        //Declare array for storing clubs and teams
        $response["clubsandteams"] = [];

        //Query the database to fetch other teams and clubs
        $select = $db->prepare("SELECT clubsandteams FROM universityclubsandteams WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university clubs and teams");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university clubs and teams");
                goto end;
            }

            //Loop through the result and push the data into the array
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["clubsandteams"] , $row["clubsandteams"]);
            }
        }

        //Declare array for storing university images
        $response["facilityimages"] = [];

        //Query the database to fetch facility images
        $select = $db->prepare("SELECT image FROM universityfacilityimages WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university facility images");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university facility images");
                goto end;
            }

            //Loop through the result and push the data into the array
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["facilityimages"] , $row["image"]);
            }
        }

        //Declare array for storing university accreditations
        $response["universityaccreditations"] = [];

        //Query the database for fetching university accreditations
        $select = $db->prepare("SELECT * FROM universityaccreditations WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university accreditations");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university accreditations");
                goto end;
            }

            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["universityaccreditations"] , $row);
            }
        }


        //Declare array for storing university rankings
        $response["universityrankings"] = [];

        //Query the database for storing universityrankings
        $select = $db->prepare("SELECT * FROM universityrankings WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university rankings");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university rankings");
                goto end;
            }

            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["universityrankings"] , $row);
            }
        }

        //Query the database to fetch statistics
        $select = $db->prepare("SELECT * FROM universitystatistics WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university statistics");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university statistics");
                goto end;
            }

            $result = $select->get_result();
            $row = $result->fetch_assoc();
            $response["universitystatistics"] = $row;
        }

        //Query the database to fetch university fees
        $select = $db->prepare("SELECT * FROM universityfees WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university fees");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university fees");
                goto end;
            }

            $result = $select->get_result();
            $row = $result->fetch_assoc();
            $response["universityfees"] = $row;
        }

        //Declare array for storing university other fees
        $response["universityotherfees"] = [];

        //Query the database for fetching university other fees
        $select = $db->prepare("SELECT * FROM universityotherfees WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university other fees");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university other fees");
                goto end;
            }

            //Loop through the result and push the data into the array
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["universityotherfees"] , $row);
            }
        }

        //Declare array for storing university financial aids
        $response["universityfinancialaids"] = [];

        //Query the database for fetching university financial aids
        $select = $db->prepare("SELECT * FROM universityfinancialaid WHERE universityid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching university financial aids");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("s" , $_GET["universityid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching university financial aids");
                goto end;
            }

            //Loop through the result and push the data into the array
            $result = $select->get_result();
            while($row = $result->fetch_assoc())
            {
                array_push($response["universityfinancialaids"] , $row);
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