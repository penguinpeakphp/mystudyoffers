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

        //Fetch the otherfee name and the status
        let otherfeename = $("#addotherfeename").val();
        let otherfeestatus = $("#addotherfeestatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new otherfee
        $.post("../controllers/otherfee/addotherfee.php" , {"otherfeename":otherfeename , "otherfeestatus":otherfeestatus} , function(data)
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
                    alert("Other Fee inserted successfully");

                    //Repopulate the otherfee list
                    getotherfeelist();

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

        //Fetch the otherfeeid , otherfee name and the status
        let otherfeeid = $("#editotherfeeid").val();
        let otherfeename = $("#editotherfeename").val();
        let otherfeestatus = $("#editotherfeestatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the other fee
        $.post("../controllers/otherfee/editotherfee.php" , {"otherfeeid":otherfeeid , "otherfeename":otherfeename , "otherfeestatus":otherfeestatus} , function(data)
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
                    alert("Other Fee updated successfully");

                    //Repopulate the otherfee list
                    getotherfeelist();

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

    //Function for getting the list of otherfees from the server and populating the table
    function getotherfeelist()
    {
        $.get("../controllers/otherfee/getotherfees.php" , {} , function(data)
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
                    $("#otherfeebody").html("");

                    //Loop through the other fee array and populate the table
                    for(let i=0; i<response.otherfees.length; i++)
                    {
                        let otherfee = response.otherfees[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${otherfee.otherfeeid}</th>
                            <td>${otherfee.otherfeename}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(otherfee.otherfeestatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(otherfee.otherfeestatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the otherfee details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${otherfee.otherfeeid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${otherfee.otherfeeid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</tr>";
    
                        //Append the table row in the table body
                        $("#otherfeebody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editotherfeeid").val(response.otherfees[index].otherfeeid);
                        $("#editotherfeename").val(response.otherfees[index].otherfeename);
                        $("#editotherfeestatus").prop("checked" , response.otherfees[index].otherfeestatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the otherfee and return if user denied
                        if(confirm("Are you sure you want to delete this other fee?") == false)
                        {
                            return;
                        }

                        let otherfeeid = $(this).attr("data-id");
                        $.post("../controllers/otherfee/deleteotherfee.php" , {"otherfeeid":otherfeeid} , function(data)
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
                                    alert("Other Fee deleted successfully");

                                    //Repopulate the other fee list
                                    getotherfeelist();
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

    //Populate the other fee list for the first time
    getotherfeelist();
});