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

        //Fetch the financialaid name and the status
        let financialaidname = $("#addfinancialaidname").val();
        let financialaidstatus = $("#addfinancialaidstatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new financialaid
        $.post("../controllers/financialaid/addfinancialaid.php" , {"financialaidname":financialaidname , "financialaidstatus":financialaidstatus} , function(data)
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
                    alert("Financial Aid inserted successfully");

                    //Repopulate the financialaid list
                    getfinancialaidlist();

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

        //Fetch the financialaidid , financialaid name and the status
        let financialaidid = $("#editfinancialaidid").val();
        let financialaidname = $("#editfinancialaidname").val();
        let financialaidstatus = $("#editfinancialaidstatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the financialaid
        $.post("../controllers/financialaid/editfinancialaid.php" , {"financialaidid":financialaidid , "financialaidname":financialaidname , "financialaidstatus":financialaidstatus} , function(data)
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
                    alert("Financial Aid updated successfully");

                    //Repopulate the financialaid list
                    getfinancialaidlist();

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

    //Function for getting the list of finanicial aid from the server and populating the table
    function getfinancialaidlist()
    {
        $.get("../controllers/financialaid/getfinancialaids.php" , {} , function(data)
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
                    $("#financialaidbody").html("");

                    //Loop through the financialaid array and populate the table
                    for(let i=0; i<response.financialaids.length; i++)
                    {
                        let financialaid = response.financialaids[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${financialaid.financialaidid}</th>
                            <td>${financialaid.financialaidname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(financialaid.financialaidstatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(financialaid.financialaidstatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the country details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${financialaid.financialaidid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${financialaid.financialaidid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</tr>";
    
                        //Append the table row in the table body
                        $("#financialaidbody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#editfinancialaidid").val(response.financialaids[index].financialaidid);
                        $("#editfinancialaidname").val(response.financialaids[index].financialaidname);
                        $("#editfinancialaidstatus").prop("checked" , response.financialaids[index].financialaidstatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the financialaid and return if user denied
                        if(confirm("Are you sure you want to delete this financial aid?") == false)
                        {
                            return;
                        }

                        let financialaidid = $(this).attr("data-id");
                        $.post("../controllers/financialaid/deletefinancialaid.php" , {"financialaidid":financialaidid} , function(data)
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
                                    alert("Financial Aid deleted successfully");

                                    //Repopulate the financial aid list
                                    getfinancialaidlist();
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

    //Populate the financial aid for the first time
    getfinancialaidlist();
});