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

        //Fetch the business nature name and the status
        let businessname = $("#addbusinessname").val();
        let businessstatus = $("#addbusinessstatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new business nature
        $.post("../controllers/businessnature/addbusinessnature.php" , {"businessname":businessname , "businessstatus":businessstatus} , function(data)
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
                    alert("Business Nature inserted successfully");

                    //Repopulate the test type list
                    getbusinessnaturelist();

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

        //Fetch the businessid , business name and the status
        let businessid = $("#editbusinessid").val();
        let businessname = $("#editbusinessname").val();
        let businessstatus = $("#editbusinessstatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the business type
        $.post("../controllers/businessnature/editbusinessnature.php" , {"businessid":businessid , "businessname":businessname , "businessstatus":businessstatus} , function(data)
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
                    alert("Business Nature updated successfully");

                    //Repopulate the test type list
                    getbusinessnaturelist();

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

    //Function for getting the list of business nature from the server and populating the table
    function getbusinessnaturelist()
    {
        $.get("../controllers/businessnature/getbusinessnatures.php" , {} , function(data)
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
                    $("#businessnaturebody").html("");

                    //Loop through the testtype array and populate the table
                    for(let i=0; i<response.businessnatures.length; i++)
                    {
                        let businessnature = response.businessnatures[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${businessnature.businessid}</th>
                            <td>${businessnature.businessname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(businessnature.businessstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(businessnature.businessstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the business nature details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${businessnature.businessid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${businessnature.businessid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#businessnaturebody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editbusinessid").val(response.businessnatures[index].businessid);
                        $("#editbusinessname").val(response.businessnatures[index].businessname);
                        $("#editbusinessstatus").prop("checked" , response.businessnatures[index].businessstatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the business nature and return if user denied
                        if(confirm("Are you sure you want to delete this business nature?") == false)
                        {
                            return;
                        }

                        let businessid = $(this).attr("data-id");
                        $.post("../controllers/businessnature/deletebusinessnature.php" , {"businessid":businessid} , function(data)
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
                                    alert("Business Nature deleted successfully");

                                    //Repopulate the business nature list
                                    getbusinessnaturelist();
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

    getbusinessnaturelist();
});