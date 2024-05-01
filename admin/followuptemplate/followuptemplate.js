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

        //Fetch the followuptemplate name and the status
        let followuptemplatename = $("#addfollowuptemplatename").val();
        let followuptemplatebody = $("#addfollowuptemplatebody").val();
        let followuptemplatestatus = $("#addfollowuptemplatestatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new followuptemplate
        $.post("../controllers/followuptemplate/addfollowuptemplate.php" , {"followuptemplatename":followuptemplatename , "followuptemplatebody":followuptemplatebody , "followuptemplatestatus":followuptemplatestatus} , function(data)
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
                    alert("Follow Up Template inserted successfully");

                    //Repopulate the followuptemplate list
                    getfollowuptemplatelist();

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

        //Fetch the followuptemplate , followup template name and the status
        let followuptemplateid = $("#editfollowuptemplateid").val();
        let followuptemplatename = $("#editfollowuptemplatename").val();
        let followuptemplatebody = $("#editfollowuptemplatebody").val();
        let followuptemplatestatus = $("#editfollowuptemplatestatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the followup template
        $.post("../controllers/followuptemplate/editfollowuptemplate.php" , {"followuptemplateid":followuptemplateid , "followuptemplatename":followuptemplatename , "followuptemplatestatus":followuptemplatestatus , "followuptemplatebody":followuptemplatebody} , function(data)
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
                    alert("Follow Up Template updated successfully");

                    //Repopulate the followup template list
                    getfollowuptemplatelist();

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

    //Function for getting the list of followuptemplates from the server and populating the table
    function getfollowuptemplatelist()
    {
        $.get("../controllers/followuptemplate/getfollowuptemplates.php" , {} , function(data)
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
                    $("#followuptemplatebody").html("");

                    //Loop through the followuptemplate array and populate the table
                    for(let i=0; i<response.followuptemplates.length; i++)
                    {
                        let followuptemplate = response.followuptemplates[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${followuptemplate.followuptemplateid}</th>
                            <td>${followuptemplate.followuptemplatename}</td>
                            <td>${followuptemplate.followuptemplatebody}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(followuptemplate.followuptemplatestatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(followuptemplate.followuptemplatestatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the followuptemplate details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${followuptemplate.followuptemplateid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${followuptemplate.followuptemplateid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</tr>";
    
                        //Append the table row in the table body
                        $("#followuptemplatebody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editfollowuptemplateid").val(response.followuptemplates[index].followuptemplateid);
                        $("#editfollowuptemplatename").val(response.followuptemplates[index].followuptemplatename);
                        $("#editfollowuptemplatebody").val(response.followuptemplates[index].followuptemplatebody);
                        $("#editfollowuptemplatestatus").prop("checked" , response.followuptemplates[index].followuptemplatestatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the followuptemplate and return if user denied
                        if(confirm("Are you sure you want to delete this follow up template?") == false)
                        {
                            return;
                        }

                        let followuptemplateid = $(this).attr("data-id");
                        $.post("../controllers/followuptemplate/deletefollowuptemplate.php" , {"followuptemplateid":followuptemplateid} , function(data)
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
                                    alert("Follow Up deleted successfully");

                                    //Repopulate the followup template list
                                    getfollowuptemplatelist();
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

    getfollowuptemplatelist();
});