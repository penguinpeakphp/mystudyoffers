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

        //Fetch the accreditation name and the status
        let accreditationname = $("#addaccreditationname").val();
        let accreditationstatus = $("#addaccreditationstatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new accreditation
        $.post("../controllers/accreditation/addaccreditation.php" , {"accreditationname":accreditationname , "accreditationstatus":accreditationstatus} , function(data)
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
                    alert("Accreditation inserted successfully");

                    //Repopulate the accreditation list
                    getaccreditationlist();

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

        //Fetch the accreditationid , accreditation name and the status
        let accreditationid = $("#editaccreditationid").val();
        let accreditationname = $("#editaccreditationname").val();
        let accreditationstatus = $("#editaccreditationstatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the accreditation
        $.post("../controllers/accreditation/editaccreditation.php" , {"accreditationid":accreditationid , "accreditationname":accreditationname , "accreditationstatus":accreditationstatus} , function(data)
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
                    alert("Accreditation updated successfully");

                    //Repopulate the accreditation list
                    getaccreditationlist();

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

    //Function for getting the list of countries from the server and populating the table
    function getaccreditationlist()
    {
        $.get("../controllers/accreditation/getaccreditations.php" , {} , function(data)
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
                    $("#accreditationbody").html("");

                    //Loop through the accreditation array and populate the table
                    for(let i=0; i<response.accreditations.length; i++)
                    {
                        let accreditation = response.accreditations[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${accreditation.accreditationid}</th>
                            <td>${accreditation.accreditationname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(accreditation.accreditationstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(accreditation.accreditationstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the accreditation details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${accreditation.accreditationid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${accreditation.accreditationid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</tr>";
    
                        //Append the table row in the table body
                        $("#accreditationbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editaccreditationid").val(response.accreditations[index].accreditationid);
                        $("#editaccreditationname").val(response.accreditations[index].accreditationname);
                        $("#editaccreditationstatus").prop("checked" , response.accreditations[index].accreditationstatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the accreditation and return if user denied
                        if(confirm("Are you sure you want to delete this accreditation?") == false)
                        {
                            return;
                        }

                        let accreditationid = $(this).attr("data-id");
                        $.post("../controllers/accreditation/deleteaccreditation.php" , {"accreditationid":accreditationid} , function(data)
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
                                    alert("Accreditation deleted successfully");

                                    //Repopulate the accreditation list
                                    getaccreditationlist();
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

    //Populate the table for the first time
    getaccreditationlist();
});