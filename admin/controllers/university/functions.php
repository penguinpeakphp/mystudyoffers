<?php
    //Function for checking if the university id is provided or not
    function checkuniversityid()
    {
        if(isset($_POST["universityid"]) && $_POST["universityid"] == "")
        {
            return false;
        }
        return true;
    }

    //Function for checking and creating the directory if does not exists
    function createdir($universityid)
    {
        //Check if directory of particular location already exists, if not create directory with the name as university id
        if(!is_dir("../../universitydata/".$universityid))
        {
            //Create the directory with name as universityid
            if(mkdir("../../universitydata/".$universityid) == false)
            {
                return false;
            }
        }

        return true;
    }
?>