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

        //Fetch the subject interest name and the subject interest status
        let subjectinterestname = $("#addsubjectinterestname").val();
        let subjectintereststatus = $("#addsubjectintereststatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new subject interest
        $.post("../controllers/subjectinterest/addsubjectinterest.php" , {"subjectinterestname":subjectinterestname , "subjectintereststatus":subjectintereststatus} , function(data)
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
                    alert("Subject Interest inserted successfully");

                    //Repopulate the subject interest list
                    getsubjectinterestlist();

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

        //Fetch the subjectinterestid , subject interest name and the subject interest status
        let subjectinterestid = $("#editsubjectinterestid").val();
        let subjectinterestname = $("#editsubjectinterestname").val();
        let subjectintereststatus = $("#editsubjectintereststatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the subject interest
        $.post("../controllers/subjectinterest/editsubjectinterest.php" , {"subjectinterestid":subjectinterestid , "subjectinterestname":subjectinterestname , "subjectintereststatus":subjectintereststatus} , function(data)
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
                    alert("Subject Interest updated successfully");

                    //Repopulate the subject interest list
                    getsubjectinterestlist();

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

    //Function for getting the list of subject interests from the server and populating the table
    function getsubjectinterestlist()
    {
        $.get("../controllers/subjectinterest/getsubjectinterests.php" , {} , function(data)
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
                    $("#subjectinterestbody").html("");

                    //Loop through the subject interest array and populate the table
                    for(let i=0; i<response.subjectinterests.length; i++)
                    {
                        let subjectinterest = response.subjectinterests[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${subjectinterest.subjectinterestid}</th>
                            <td>${subjectinterest.subjectinterestname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(subjectinterest.subjectintereststatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(subjectinterest.subjectintereststatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the country details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${subjectinterest.subjectinterestid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${subjectinterest.subjectinterestid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#subjectinterestbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editsubjectinterestid").val(response.subjectinterests[index].subjectinterestid);
                        $("#editsubjectinterestname").val(response.subjectinterests[index].subjectinterestname);
                        $("#editsubjectintereststatus").prop("checked" , response.subjectinterests[index].subjectintereststatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the subject interest and return if user denied
                        if(confirm("Are you sure you want to delete this subject interest?") == false)
                        {
                            return;
                        }

                        let subjectinterestid = $(this).attr("data-id");
                        $.post("../controllers/subjectinterest/deletesubjectinterest.php" , {"subjectinterestid":subjectinterestid} , function(data)
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
                                    alert("Subject Interest deleted successfully");

                                    //Repopulate the subject interest list
                                    getsubjectinterestlist();
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

    getsubjectinterestlist();
});