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

        //Fetch the passing year name and the status
        let passingyear = $("#addpassingyear").val();
        let passingyearstatus = $("#addpassingyearstatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new passing year
        $.post("../controllers/passingyear/addpassingyear.php" , {"passingyear":passingyear , "passingyearstatus":passingyearstatus} , function(data)
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
                    alert("Passing year inserted successfully");

                    //Repopulate the passing year list
                    getpassingyearlist();

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

        //Fetch the passingyearid , passing year and the status
        let passingyearid = $("#editpassingyearid").val();
        let passingyear = $("#editpassingyear").val();
        let passingyearstatus = $("#editpassingyearstatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the passing year
        $.post("../controllers/passingyear/editpassingyear.php" , {"passingyearid":passingyearid , "passingyear":passingyear , "passingyearstatus":passingyearstatus} , function(data)
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
                    alert("Passing Year updated successfully");

                    //Repopulate the passing year list
                    getpassingyearlist();

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

    //Function for getting the list of passing years from the server and populating the table
    function getpassingyearlist()
    {
        $.get("../controllers/passingyear/getpassingyears.php" , {} , function(data)
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
                    $("#passingyearbody").html("");

                    //Loop through the passingyear array and populate the table
                    for(let i=0; i<response.passingyears.length; i++)
                    {
                        let passingyear = response.passingyears[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${passingyear.passingyearid}</th>
                            <td>${passingyear.passingyear}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(passingyear.passingyearstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(passingyear.passingyearstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the passing year details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${passingyear.passingyearid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${passingyear.passingyearid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#passingyearbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editpassingyearid").val(response.passingyears[index].passingyearid);
                        $("#editpassingyear").val(response.passingyears[index].passingyear);
                        $("#editpassingyearstatus").prop("checked" , response.passingyears[index].passingyearstatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the passing year and return if user denied
                        if(confirm("Are you sure you want to delete this passing year?") == false)
                        {
                            return;
                        }

                        let passingyearid = $(this).attr("data-id");
                        $.post("../controllers/passingyear/deletepassingyear.php" , {"passingyearid":passingyearid} , function(data)
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
                                    alert("Passing Year deleted successfully");

                                    //Repopulate the passing year list
                                    getpassingyearlist();
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

    getpassingyearlist();
});