<?php
    require_once "../../admin/database/db.php";
    require_once "../functions/globalfunctions.php";

    try
    {
        $response["success"] = true;

        //Check if the user has already logged in
        if(checksession($response) == false)
        {
            goto end;
        }

        //Declare an array to store the countries
        $response["countries"] = [];

        //Query the database to get all the countries
        $result = $db->query("SELECT * FROM country WHERE status = 1");
        if($result == false)
        {
            failure($response , "Error while fetching the country list");
            goto end;
        }
        //Loop through the result and push the data into the array
        while($row = $result->fetch_assoc())
        {
            array_push($response["countries"] , $row);
        }

        //Declare an array to store the selected countries of the student
        $response["selectedcountries"] = [];
        $response["selectedcountrynamesflags"] = [];

        //Query the database to select countries selected by student
        $select = $db->prepare("SELECT s.countryid , countryname , flagimage FROM studentcountry s INNER JOIN country c ON s.countryid = c.countryid WHERE studentid = ?");
        if($select == false)
        {
            failure($response , "Error while fetching selected countries");
            goto end;
        }
        else
        {
            //Bind the parameters
            $select->bind_param("i" , $_SESSION["studentid"]);

            //Execute the query
            if($select->execute() == false)
            {
                failure($response , "Error while fetching selected countries");
                goto end;
            }

            //Loop through the result and push the data into the array
            $result = $select->get_result();

            while($row = $result->fetch_assoc())
            {
                array_push($response["selectedcountries"] , $row["countryid"]);

                $countryobj = [];
                $countryobj["countryname"] = $row["countryname"];
                $countryobj["flagimage"] = $row["flagimage"];
                array_push($response["selectedcountrynamesflags"] , $countryobj);
            }
            
        }
        end:;
    }
    catch(Exception $e)
    {
        failure($response , "Error Occurred while fetching country data - " . $e->getCode());
    }

    echo json_encode($response);

?>