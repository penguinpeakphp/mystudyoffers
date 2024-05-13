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

        //Fetch the rank awarding body name and the status
        let rankawardingbodyname = $("#addrankawardingbodyname").val();
        let rankawardingbodystatus = $("#addrankawardingbodystatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new rank awarding body
        $.post("../controllers/rankawardingbody/addrankawardingbody.php" , {"rankawardingbodyname":rankawardingbodyname , "rankawardingbodystatus":rankawardingbodystatus} , function(data)
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
                    alert("Rank Awarding Body inserted successfully");

                    //Repopulate the rank awarding body list
                    getrankawardingbodylist();

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

        //Fetch the rankawardingbodyid , rankawardingbody name and the rankwardingbodystatus
        let rankawardingbodyid = $("#editrankawardingbodyid").val();
        let rankawardingbodyname = $("#editrankawardingbodyname").val();
        let rankawardingbodystatus = $("#editrankawardingbodystatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the rankawardingbody
        $.post("../controllers/rankawardingbody/editrankawardingbody.php" , {"rankawardingbodyid":rankawardingbodyid , "rankawardingbodyname":rankawardingbodyname , "rankawardingbodystatus":rankawardingbodystatus} , function(data)
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
                    alert("Rank Awaring Body updated successfully");

                    //Repopulate the rank awarding body list
                    getrankawardingbodylist();

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

    //Function for getting the list of rank awarding bodies from the server and populating the table
    function getrankawardingbodylist()
    {
        $.get("../controllers/rankawardingbody/getrankawardingbodies.php" , {} , function(data)
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
                    $("#rankawardingbody").html("");

                    //Loop through the rank awarding body array and populate the table
                    for(let i=0; i<response.rankawardingbodies.length; i++)
                    {
                        let rankawardingbody = response.rankawardingbodies[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${rankawardingbody.rankawardingbodyid}</th>
                            <td>${rankawardingbody.rankawardingbodyname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(rankawardingbody.rankawardingbodystatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(rankawardingbody.rankawardingbodystatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the rankawardingbody details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${rankawardingbody.rankawardingbodyid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${rankawardingbody.rankawardingbodyid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</tr>";
    
                        //Append the table row in the table body
                        $("#rankawardingbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editrankawardingbodyid").val(response.rankawardingbodies[index].rankawardingbodyid);
                        $("#editrankawardingbodyname").val(response.rankawardingbodies[index].rankawardingbodyname);
                        $("#editrankawardingbodystatus").prop("checked" , response.rankawardingbodies[index].rankawardingbodystatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the rank awarding body and return if user denied
                        if(confirm("Are you sure you want to delete this rank awarding body?") == false)
                        {
                            return;
                        }

                        let rankawardingbodyid = $(this).attr("data-id");
                        $.post("../controllers/rankawardingbody/deleterankawardingbody.php" , {"rankawardingbodyid":rankawardingbodyid} , function(data)
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
                                    alert("Rank Awarding Body deleted successfully");

                                    //Repopulate the rank awarding body list
                                    getrankawardingbodylist();
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

    getrankawardingbodylist();
});