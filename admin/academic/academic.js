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

        //Fetch the academic name and the status
        let academicname = $("#addacademicname").val();
        let academicstatus = $("#addacademicstatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new academic
        $.post("../controllers/academic/addacademic.php" , {"academicname":academicname , "academicstatus":academicstatus} , function(data)
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
                    alert("Academic inserted successfully");

                    //Repopulate the academic list
                    getacademiclist();

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

        //Fetch the acadmicid , academic name and the status
        let academicid = $("#editacademicid").val();
        let academicname = $("#editacademicname").val();
        let academicstatus = $("#editacademicstatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the academic
        $.post("../controllers/academic/editacademic.php" , {"academicid":academicid , "academicname":academicname , "academicstatus":academicstatus} , function(data)
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
                    alert("Academic Qualification updated successfully");

                    //Repopulate the academic list
                    getacademiclist();

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

    //Function for getting the list of academic qualifications from the server and populating the table
    function getacademiclist()
    {
        $.get("../controllers/academic/getacademics.php" , {} , function(data)
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
                    $("#academicbody").html("");

                    //Loop through the academic array and populate the table
                    for(let i=0; i<response.academics.length; i++)
                    {
                        let academic = response.academics[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${academic.academicid}</th>
                            <td>${academic.academicname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(academic.academicstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(academic.academicstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the academic details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${academic.academicid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${academic.academicid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#academicbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editacademicid").val(response.academics[index].academicid);
                        $("#editacademicname").val(response.academics[index].academicname);
                        $("#editacademicstatus").prop("checked" , response.academics[index].academicstatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the academic and return if user denied
                        if(confirm("Are you sure you want to delete this academic qualification?") == false)
                        {
                            return;
                        }

                        let academicid = $(this).attr("data-id");
                        $.post("../controllers/academic/deleteacademic.php" , {"academicid":academicid} , function(data)
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
                                    alert("Academic Qualification deleted successfully");

                                    //Repopulate the academic list
                                    getacademiclist();
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

    getacademiclist();
});