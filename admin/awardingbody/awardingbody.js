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

        //Fetch the awarding body name , academicid and the status
        let awardingbodyname = $("#addawardingbodyname").val();
        let awardingbodystatus = $("#addawardingbodystatus").prop("checked") ? 1 : 0;
        let academicid = $("#addacademic").find(":selected").val();

        //Send the post request for adding the new awarding body
        $.post("../controllers/awardingbody/addawardingbody.php" , {"awardingbodyname":awardingbodyname , "awardingbodystatus":awardingbodystatus , "academicid":academicid} , function(data)
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
                    alert("Awarding body inserted successfully");

                    //Repopulate the awarding body list
                    getawardingbodylist();

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

        //Fetch the awardingbodyid , awarding body name, state status and academicid
        let awardingbodyid = $("#editawardingbodyid").val();
        let awardingbodyname = $("#editawardingbodyname").val();
        let awardingbodystatus = $("#editawardingbodystatus").prop("checked") ? 1 : 0;
        let academicid = $("#editacademic").find(":selected").val();

        //Send the post request for updating the awarding body
        $.post("../controllers/awardingbody/editawardingbody.php" , {"awardingbodyid":awardingbodyid , "awardingbodyname":awardingbodyname , "awardingbodystatus":awardingbodystatus , "academicid":academicid} , function(data)
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
                    alert("Awarding Body updated successfully");

                    //Repopulate the awarding body list
                    getawardingbodylist();

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


    //Function for getting the list of states from the server and populating the table
    function getawardingbodylist()
    {
        $.get("../controllers/awardingbody/getawardingbodies.php" , {} , function(data)
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
                    //Assign academic list to global variable for further use on this page
                    academics = response.academics;

                    //Populate the select options in add and edit select
                    populateacademics("#addacademic");
                    populateacademics("#editacademic");

                    //Reset the table body for repopulating the table
                    $("#awardingbodybody").html("");

                    //Loop through the state array and populate the table
                    for(let i=0; i<response.awardingbodies.length; i++)
                    {
                        let awardingbody = response.awardingbodies[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${awardingbody.awardingbodyid}</th>
                            <td>${awardingbody.awardingbodyname}</td>
                            <td>${awardingbody.academicname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(awardingbody.awardingbodystatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(awardingbody.awardingbodystatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the awarding body details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${awardingbody.awardingbodyid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${awardingbody.awardingbodyid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#awardingbodybody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editawardingbodyid").val(response.awardingbodies[index].awardingbodyid);
                        $("#editawardingbodyname").val(response.awardingbodies[index].awardingbodyname);
                        $("#editawardingbodystatus").prop("checked" , response.awardingbodies[index].awardingbodystatus == "1" ? true : false);
                        $(`#editacademic option[value='${response.awardingbodies[index].academicid}']`).prop("selected" , true);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the awarding body and return if user denied
                        if(confirm("Are you sure you want to delete this awarding body?") == false)
                        {
                            return;
                        }

                        let awardingbodyid = $(this).attr("data-id");
                        $.post("../controllers/awardingbody/deleteawardingbody.php" , {"awardingbodyid":awardingbodyid} , function(data)
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
                                    alert("Awarding Body deleted successfully");

                                    //Repopulate the awardig body list
                                    getawardingbodylist();
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

    getawardingbodylist();
});