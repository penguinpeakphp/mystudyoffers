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

        //Fetch the institute name and the status
        let institutename = $("#addinstitutename").val();
        let institutestatus = $("#addinstitutestatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new test type
        $.post("../controllers/institutetype/addinstitutetype.php" , {"institutename":institutename , "institutestatus":institutestatus} , function(data)
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
                    alert("Institute Type inserted successfully");

                    //Repopulate the institute type list
                    getinstitutetypelist();

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

        //Fetch the instituteid , institute name and the status
        let instituteid = $("#editinstituteid").val();
        let institutename = $("#editinstitutename").val();
        let institutestatus = $("#editinstitutestatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the institute type
        $.post("../controllers/institutetype/editinstitutetype.php" , {"instituteid":instituteid , "institutename":institutename , "institutestatus":institutestatus} , function(data)
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
                    alert("Institute Type updated successfully");

                    //Repopulate the institute type list
                    getinstitutetypelist();

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

    //Function for getting the list of institute types from the server and populating the table
    function getinstitutetypelist()
    {
        $.get("../controllers/institutetype/getinstitutetypes.php" , {} , function(data)
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
                    $("#institutetypebody").html("");

                    //Loop through the testtype array and populate the table
                    for(let i=0; i<response.institutetypes.length; i++)
                    {
                        let institutetype = response.institutetypes[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${institutetype.instituteid}</th>
                            <td>${institutetype.institutename}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(institutetype.institutestatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(institutetype.institutestatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the institute type details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${institutetype.instituteid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${institutetype.instituteid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#institutetypebody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editinstituteid").val(response.institutetypes[index].instituteid);
                        $("#editinstitutename").val(response.institutetypes[index].institutename);
                        $("#editinstitutestatus").prop("checked" , response.institutetypes[index].institutestatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the institute type and return if user denied
                        if(confirm("Are you sure you want to delete this institute type?") == false)
                        {
                            return;
                        }

                        let instituteid = $(this).attr("data-id");
                        $.post("../controllers/institutetype/deleteinstitutetype.php" , {"instituteid":instituteid} , function(data)
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
                                    alert("Institute Type deleted successfully");

                                    //Repopulate the institute type list
                                    getinstitutetypelist();
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

    getinstitutetypelist();
});