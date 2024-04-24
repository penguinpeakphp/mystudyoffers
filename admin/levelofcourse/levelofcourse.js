$(function()
{
    //Open Add Modal on clicking the Add Button
    $(".add").on("click" , function()
    {
        $("#addmodal").modal("show");
    });

    $("#addform").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the level of course name and the status
        let levelofcoursename = $("#addlevelofcoursename").val();
        let levelofcoursestatus = $("#addlevelofcoursestatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new level of course
        $.post("../controllers/levelofcourse/addlevelofcourse.php" , {"levelofcoursename":levelofcoursename , "levelofcoursestatus":levelofcoursestatus} , function(data)
        {
            try
            {
                //Parse the data received from the server
                let response = JSON.parse(data);

                //If the response is not successful, then show the error in alert
                if(response.success == false)
                {
                    alert(response.error);

                    //Redirect to login page if the user is required to be login again
                    if(response.login == true)
                    {
                        window.location.href = "../login/login.php";
                    }
                }
                else
                {
                    //Alert the success message
                    alert("Level of Course inserted successfully");

                    //Repopulate the level of course list
                    getlevelofcourselist();

                    //Close the modal
                    $("#addmodal").modal("hide");
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    });

    $("#editform").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the levelofcourseid , level of course name and the status
        let levelofcourseid = $("#editlevelofcourseid").val();
        let levelofcoursename = $("#editlevelofcoursename").val();
        let levelofcoursestatus = $("#editlevelofcoursestatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the level of course
        $.post("../controllers/levelofcourse/editlevelofcourse.php" , {"levelofcourseid":levelofcourseid , "levelofcoursename":levelofcoursename , "levelofcoursestatus":levelofcoursestatus} , function(data)
        {
            try
            {
                //Parse the data received from the server
                let response = JSON.parse(data);

                //If the response is not successful, then show the error in alert
                if(response.success == false)
                {
                    alert(response.error);

                    //Redirect to login page if the user is required to be login again
                    if(response.login == true)
                    {
                        window.location.href = "../login/login.php";
                    }
                }
                else
                {
                    //Alert the success message
                    alert("Level of Course updated successfully");

                    //Repopulate the country list
                    getlevelofcourselist();

                    //Close the modal
                    $("#editmodal").modal("hide");
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    });

    //Function for getting the list of level of courses from the server and populating the table
    function getlevelofcourselist()
    {
        $.get("../controllers/levelofcourse/getlevelofcourses.php" , {} , function(data)
        {
            try
            {
                //Parse the data received from the server
                let response = JSON.parse(data);

                //If the response is not successful, then show the error in alert
                if(response.success == false)
                {
                    alert(response.error);

                    //Redirect to login page if the user is required to be login again
                    if(response.login == true)
                    {
                        window.location.href = "../login/login.php";
                    }
                }
                else
                {
                    //Reset the table body for repopulating the table
                    $("#levelofcoursebody").html("");

                    //Loop through the level of course array and populate the table
                    for(let i=0; i<response.levelofcourses.length; i++)
                    {
                        let levelofcourse = response.levelofcourses[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${levelofcourse.levelofcourseid}</th>
                            <td>${levelofcourse.levelofcoursename}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(levelofcourse.levelofcoursestatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(levelofcourse.levelofcoursestatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the leve of course details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${levelofcourse.levelofcourseid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${levelofcourse.levelofcourseid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#levelofcoursebody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editlevelofcourseid").val(response.levelofcourses[index].levelofcourseid);
                        $("#editlevelofcoursename").val(response.levelofcourses[index].levelofcoursename);
                        $("#editlevelofcoursestatus").prop("checked" , response.levelofcourses[index].levelofcoursestatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the level of course and return if user denied
                        if(confirm("Are you sure you want to delete this level of course?") == false)
                        {
                            return;
                        }

                        let levelofcourseid = $(this).attr("data-id");
                        $.post("../controllers/levelofcourse/deletelevelofcourse.php" , {"levelofcourseid":levelofcourseid} , function(data)
                        {
                            try
                            {
                                //Parse the data received from the server
                                let response = JSON.parse(data);

                                //If the response is not successful, then show the error in alert
                                if(response.success == false)
                                {
                                    alert(response.error);

                                    //Redirect to login page if the user is required to be login again
                                    if(response.login == true)
                                    {
                                        window.location.href = "../login/login.php";
                                    }
                                }
                                else
                                {
                                    //Alert the success message
                                    alert("Level of Course deleted successfully");

                                    //Repopulate the country list
                                    getlevelofcourselist();
                                }
                            }
                            catch(error)
                            {
                                alert("Error occurred while trying to read server response");
                            }
                        });
                    });
                }
            }
            catch(error)
            {
                alert("Error occurred while trying to read server response");
            }
        });
    }

    getlevelofcourselist();
});