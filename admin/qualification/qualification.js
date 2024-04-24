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

        //Fetch the qualification name and the status
        let qualificationname = $("#addqualificationname").val();
        let qualificationstatus = $("#addqualificationstatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new qualification
        $.post("../controllers/qualification/addqualification.php" , {"qualificationname":qualificationname , "qualificationstatus":qualificationstatus} , function(data)
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
                    alert("Qualification inserted successfully");

                    //Repopulate the qualification list
                    getqualificationlist();

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

        //Fetch the qualificationid , qualification name and the status
        let qualificationid = $("#editqualificationid").val();
        let qualificationname = $("#editqualificationname").val();
        let qualificationstatus = $("#editqualificationstatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the qualification
        $.post("../controllers/qualification/editqualification.php" , {"qualificationid":qualificationid , "qualificationname":qualificationname , "qualificationstatus":qualificationstatus} , function(data)
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
                    alert("Qualification updated successfully");

                    //Repopulate the qualification list
                    getqualificationlist();

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

    //Function for getting the list of qualifications from the server and populating the table
    function getqualificationlist()
    {
        $.get("../controllers/qualification/getqualifications.php" , {} , function(data)
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
                    $("#qualificationbody").html("");

                    //Loop through the qualification array and populate the table
                    for(let i=0; i<response.qualifications.length; i++)
                    {
                        let qualification = response.qualifications[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${qualification.qualificationid}</th>
                            <td>${qualification.qualificationname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(qualification.qualificationstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(qualification.qualificationstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the qualification details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${qualification.qualificationid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${qualification.qualificationid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#qualificationbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editqualificationid").val(response.qualifications[index].qualificationid);
                        $("#editqualificationname").val(response.qualifications[index].qualificationname);
                        $("#editqualificationstatus").prop("checked" , response.qualifications[index].qualificationstatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the qualification and return if user denied
                        if(confirm("Are you sure you want to delete this qualification?") == false)
                        {
                            return;
                        }

                        let qualificationid = $(this).attr("data-id");
                        $.post("../controllers/qualification/deletequalification.php" , {"qualificationid":qualificationid} , function(data)
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
                                    alert("Qualification deleted successfully");

                                    //Repopulate the qualification list
                                    getqualificationlist();
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

    getqualificationlist();
});