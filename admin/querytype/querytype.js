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

        //Fetch the query type name and the status
        let querytypename = $("#addquerytypename").val();
        let querytypestatus = $("#addquerytypestatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new querytype
        $.post("../controllers/querytype/addquerytype.php" , {"querytypename":querytypename , "querytypestatus":querytypestatus} , function(data)
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
                    alert("Query Type inserted successfully");

                    //Repopulate the querytype list
                    getquerytypelist();

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

        //Fetch the query type id , query type name and the status
        let querytypeid = $("#editquerytypeid").val();
        let querytypename = $("#editquerytypename").val();
        let querytypestatus = $("#editquerytypestatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the query type
        $.post("../controllers/querytype/editquerytype.php" , {"querytypeid":querytypeid , "querytypename":querytypename , "querytypestatus":querytypestatus} , function(data)
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
                    alert("Query Type updated successfully");

                    //Repopulate the query type list
                    getquerytypelist();

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

    //Function for getting the list of query types from the server and populating the table
    function getquerytypelist()
    {
        $.get("../controllers/querytype/getquerytypes.php" , {} , function(data)
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
                    $("#querytypebody").html("");

                    //Loop through the country array and populate the table
                    for(let i=0; i<response.querytypes.length; i++)
                    {
                        let querytype = response.querytypes[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${querytype.querytypeid}</th>
                            <td>${querytype.querytypename}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(querytype.querytypestatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(querytype.querytypestatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the querytype details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${querytype.querytypeid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${querytype.querytypeid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</tr>";
    
                        //Append the table row in the table body
                        $("#querytypebody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editquerytypeid").val(response.querytypes[index].querytypeid);
                        $("#editquerytypename").val(response.querytypes[index].querytypename);
                        $("#editquerytypestatus").prop("checked" , response.querytypes[index].querytypestatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the query type and return if user denied
                        if(confirm("Are you sure you want to delete this query type?") == false)
                        {
                            return;
                        }

                        let querytypeid = $(this).attr("data-id");
                        $.post("../controllers/querytype/deletequerytype.php" , {"querytypeid":querytypeid} , function(data)
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
                                    alert("Query Type deleted successfully");

                                    //Repopulate the query type list
                                    getquerytypelist();
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

    getquerytypelist();
}); 