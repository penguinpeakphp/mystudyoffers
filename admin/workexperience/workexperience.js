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

        //Fetch the work experience name and the status
        let workexperiencename = $("#addworkexperiencename").val();
        let workexperiencestatus = $("#addworkexperiencestatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new work experience
        $.post("../controllers/workexperience/addworkexperience.php" , {"workexperiencename":workexperiencename , "workexperiencestatus":workexperiencestatus} , function(data)
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
                    alert("Work Experience inserted successfully");

                    //Repopulate the work experience list
                    getworkexperiencelist();

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

        //Fetch the workexperienceid , work experience name and the status
        let workexperienceid = $("#editworkexperienceid").val();
        let workexperiencename = $("#editworkexperiencename").val();
        let workexperiencestatus = $("#editworkexperiencestatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the workexperience
        $.post("../controllers/workexperience/editworkexperience.php" , {"workexperienceid":workexperienceid , "workexperiencename":workexperiencename , "workexperiencestatus":workexperiencestatus} , function(data)
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
                    alert("Work Experience updated successfully");

                    //Repopulate the workexperience list
                    getworkexperiencelist();

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

    //Function for getting the list of work experience from the server and populating the table
    function getworkexperiencelist()
    {
        $.get("../controllers/workexperience/getworkexperiences.php" , {} , function(data)
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
                    $("#workexperiencebody").html("");

                    //Loop through the work experience array and populate the table
                    for(let i=0; i<response.workexperiences.length; i++)
                    {
                        let workexperience = response.workexperiences[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${workexperience.workexperienceid}</th>
                            <td>${workexperience.workexperiencename}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(workexperience.workexperiencestatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(workexperience.workexperiencestatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the work experience details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${workexperience.workexperienceid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${workexperience.workexperienceid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#workexperiencebody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editworkexperienceid").val(response.workexperiences[index].workexperienceid);
                        $("#editworkexperiencename").val(response.workexperiences[index].workexperiencename);
                        $("#editworkexperiencestatus").prop("checked" , response.workexperiences[index].workexperiencestatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the work experience and return if user denied
                        if(confirm("Are you sure you want to delete this work experience?") == false)
                        {
                            return;
                        }

                        let workexperienceid = $(this).attr("data-id");
                        $.post("../controllers/workexperience/deleteworkexperience.php" , {"workexperienceid":workexperienceid} , function(data)
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
                                    alert("Work Experience deleted successfully");

                                    //Repopulate the work experience list
                                    getworkexperiencelist();
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

    getworkexperiencelist();
});