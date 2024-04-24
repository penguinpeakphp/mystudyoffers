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

        //Fetch the qualificationsub name and the status
        let qualificationsubname = $("#addqualificationsubname").val();
        let qualificationsubstatus = $("#addqualificationsubstatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new qualification sub
        $.post("../controllers/qualificationsub/addqualificationsub.php" , {"qualificationsubname":qualificationsubname , "qualificationsubstatus":qualificationsubstatus} , function(data)
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
                    alert("Qualification Sub inserted successfully");

                    //Repopulate the qualificationsub list
                    getqualificationsublist();

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

        //Fetch the qualificationsubid , qualificationsub name and the status
        let qualificationsubid = $("#editqualificationsubid").val();
        let qualificationsubname = $("#editqualificationsubname").val();
        let qualificationsubstatus = $("#editqualificationsubstatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the qualificationsub
        $.post("../controllers/qualificationsub/editqualificationsub.php" , {"qualificationsubid":qualificationsubid , "qualificationsubname":qualificationsubname , "qualificationsubstatus":qualificationsubstatus} , function(data)
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
                    alert("Qualification Sub updated successfully");

                    //Repopulate the qualificationsub list
                    getqualificationsublist();

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

    //Function for getting the list of qualification subs from the server and populating the table
    function getqualificationsublist()
    {
        $.get("../controllers/qualificationsub/getqualificationsubs.php" , {} , function(data)
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
                    $("#qualificationsubbody").html("");

                    //Loop through the country array and populate the table
                    for(let i=0; i<response.qualificationsubs.length; i++)
                    {
                        let qualificationsub = response.qualificationsubs[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${qualificationsub.qualificationsubid}</th>
                            <td>${qualificationsub.qualificationsubname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(qualificationsub.qualificationsubstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(qualificationsub.qualificationsubstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the qualificationsub details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${qualificationsub.qualificationsubid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${qualificationsub.qualificationsubid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#qualificationsubbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editqualificationsubid").val(response.qualificationsubs[index].qualificationsubid);
                        $("#editqualificationsubname").val(response.qualificationsubs[index].qualificationsubname);
                        $("#editqualificationsubstatus").prop("checked" , response.qualificationsubs[index].qualificationsubstatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the qualification sub and return if user denied
                        if(confirm("Are you sure you want to delete this qualification sub?") == false)
                        {
                            return;
                        }

                        let qualificationsubid = $(this).attr("data-id");
                        $.post("../controllers/qualificationsub/deletequalificationsub.php" , {"qualificationsubid":qualificationsubid} , function(data)
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
                                    alert("Qualification sub deleted successfully");

                                    //Repopulate the qualificationsub list
                                    getqualificationsublist();
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

    getqualificationsublist();
});