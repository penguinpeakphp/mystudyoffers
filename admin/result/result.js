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

        //Fetch the result name and the status
        let resultname = $("#addresultname").val();
        let resultstatus = $("#addresultstatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new result
        $.post("../controllers/result/addresult.php" , {"resultname":resultname , "resultstatus":resultstatus} , function(data)
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
                    alert("Result inserted successfully");

                    //Repopulate the result list
                    getresultlist();

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

        //Fetch the resultid , result name and the status
        let resultid = $("#editresultid").val();
        let resultname = $("#editresultname").val();
        let resultstatus = $("#editresultstatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the result
        $.post("../controllers/result/editresult.php" , {"resultid":resultid , "resultname":resultname , "resultstatus":resultstatus} , function(data)
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
                    alert("Result updated successfully");

                    //Repopulate the result list
                    getresultlist();

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

    //Function for getting the list of results from the server and populating the table
    function getresultlist()
    {
        $.get("../controllers/result/getresults.php" , {} , function(data)
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
                    $("#resultbody").html("");

                    //Loop through the result array and populate the table
                    for(let i=0; i<response.results.length; i++)
                    {
                        let result = response.results[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${result.resultid}</th>
                            <td>${result.resultname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(result.resultstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(result.resultstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the result details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${result.resultid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${result.resultid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#resultbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editresultid").val(response.results[index].resultid);
                        $("#editresultname").val(response.results[index].resultname);
                        $("#editresultstatus").prop("checked" , response.results[index].resultstatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the result and return if user denied
                        if(confirm("Are you sure you want to delete this result?") == false)
                        {
                            return;
                        }

                        let resultid = $(this).attr("data-id");
                        $.post("../controllers/result/deleteresult.php" , {"resultid":resultid} , function(data)
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
                                    alert("Result deleted successfully");

                                    //Repopulate the result list
                                    getresultlist();
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

    getresultlist();
});