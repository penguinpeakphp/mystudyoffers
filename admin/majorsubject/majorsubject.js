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

        //Fetch the major subject name , majorsubjectid and the status
        let majorsubjectname = $("#addmajorsubjectname").val();
        let majorsubjectstatus = $("#addmajorsubjectstatus").prop("checked") ? 1 : 0;
        let academicid = $("#addacademic").find(":selected").val();

        //Send the post request for adding the new major subject
        $.post("../controllers/majorsubject/addmajorsubject.php" , {"majorsubjectname":majorsubjectname , "majorsubjectstatus":majorsubjectstatus , "academicid":academicid} , function(data)
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
                    alert("Major Subject inserted successfully");

                    //Repopulate the major subject list
                    getmajorsubjectlist();

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

        //Fetch the majorsubjectid , major subject name, major subject status and academicid
        let majorsubjectid = $("#editmajorsubjectid").val();
        let majorsubjectname = $("#editmajorsubjectname").val();
        let majorsubjectstatus = $("#editmajorsubjectstatus").prop("checked") ? 1 : 0;
        let academicid = $("#editacademic").find(":selected").val();

        //Send the post request for updating the major subject
        $.post("../controllers/majorsubject/editmajorsubject.php" , {"majorsubjectid":majorsubjectid , "majorsubjectname":majorsubjectname , "majorsubjectstatus":majorsubjectstatus , "academicid":academicid} , function(data)
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
                    alert("Major Subject updated successfully");

                    //Repopulate the state list
                    getmajorsubjectlist();

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

    //Function for getting the list of states from the server and populating the table
    function getmajorsubjectlist()
    {
        $.get("../controllers/majorsubject/getmajorsubjects.php" , {} , function(data)
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
                    //Assign academic list to global variable for further use on this page
                    academics = response.academics;

                    //Populate the select options in add and edit select
                    populateacademics("#addacademic");
                    populateacademics("#editacademic");

                    //Reset the table body for repopulating the table
                    $("#majorsubjectbody").html("");

                    //Loop through the major subject array and populate the table
                    for(let i=0; i<response.majorsubjects.length; i++)
                    {
                        let majorsubject = response.majorsubjects[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${majorsubject.majorsubjectid}</th>
                            <td>${majorsubject.majorsubjectname}</td>
                            <td>${majorsubject.academicname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(majorsubject.majorsubjectstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(majorsubject.majorsubjectstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the majorsubject details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${majorsubject.majorsubjectid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${majorsubject.majorsubjectid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#majorsubjectbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editmajorsubjectid").val(response.majorsubjects[index].majorsubjectid);
                        $("#editmajorsubjectname").val(response.majorsubjects[index].majorsubjectname);
                        $("#editmajorsubjectstatus").prop("checked" , response.majorsubjects[index].majorsubjectstatus == "1" ? true : false);
                        $(`#editacademic option[value='${response.majorsubjects[index].academicid}']`).prop("selected" , true);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the major subject and return if user denied
                        if(confirm("Are you sure you want to delete this major subject?") == false)
                        {
                            return;
                        }

                        let majorsubjectid = $(this).attr("data-id");
                        $.post("../controllers/majorsubject/deletemajorsubject.php" , {"majorsubjectid":majorsubjectid} , function(data)
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
                                    alert("Major Subject deleted successfully");

                                    //Repopulate the major state list
                                    getmajorsubjectlist();
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

    getmajorsubjectlist();
});