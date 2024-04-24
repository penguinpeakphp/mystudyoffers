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

        //Fetch the planning year name and the status
        let planningyear = $("#addplanningyear").val();
        let planningyearstatus = $("#addplanningyearstatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new planning year
        $.post("../controllers/planningyear/addplanningyear.php" , {"planningyear":planningyear , "planningyearstatus":planningyearstatus} , function(data)
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
                    alert("Year of Planning inserted successfully");

                    //Repopulate the planning year list
                    getplanningyearlist();

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

        //Fetch the planningyearid , planning year name and the status
        let planningyearid = $("#editplanningyearid").val();
        let planningyear = $("#editplanningyear").val();
        let planningyearstatus = $("#editplanningyearstatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the planning year
        $.post("../controllers/planningyear/editplanningyear.php" , {"planningyearid":planningyearid , "planningyear":planningyear , "planningyearstatus":planningyearstatus} , function(data)
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
                    alert("Year of Planning updated successfully");

                    //Repopulate the country list
                    getplanningyearlist();

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

    //Function for getting the list of planning years from the server and populating the table
    function getplanningyearlist()
    {
        $.get("../controllers/planningyear/getplanningyears.php" , {} , function(data)
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
                    $("#planningyearbody").html("");

                    //Loop through the planning year array and populate the table
                    for(let i=0; i<response.planningyears.length; i++)
                    {
                        let planningyear = response.planningyears[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${planningyear.planningyearid}</th>
                            <td>${planningyear.planningyear}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(planningyear.planningyearstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(planningyear.planningyearstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the planning year details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${planningyear.planningyearid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${planningyear.planningyearid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#planningyearbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editplanningyearid").val(response.planningyears[index].planningyearid);
                        $("#editplanningyear").val(response.planningyears[index].planningyear);
                        $("#editplanningyearstatus").prop("checked" , response.planningyears[index].planningyearstatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the planning year and return if user denied
                        if(confirm("Are you sure you want to delete this planning of year?") == false)
                        {
                            return;
                        }

                        let planningyearid = $(this).attr("data-id");
                        $.post("../controllers/planningyear/deleteplanningyear.php" , {"planningyearid":planningyearid} , function(data)
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
                                    alert("Year of Planning deleted successfully");

                                    //Repopulate the planning year list
                                    getplanningyearlist();
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

    getplanningyearlist();
});