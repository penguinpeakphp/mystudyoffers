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

        //Fetch the test type name and the status
        let testname = $("#addtestname").val();
        let teststatus = $("#addteststatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new test type
        $.post("../controllers/testtype/addtesttype.php" , {"testname":testname , "teststatus":teststatus} , function(data)
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
                    alert("Test Type inserted successfully");

                    //Repopulate the test type list
                    gettesttypelist();

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

        //Fetch the testid , test name and the status
        let testid = $("#edittestid").val();
        let testname = $("#edittestname").val();
        let teststatus = $("#editteststatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the test type
        $.post("../controllers/testtype/edittesttype.php" , {"testid":testid , "testname":testname , "teststatus":teststatus} , function(data)
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
                    alert("Test Type updated successfully");

                    //Repopulate the test type list
                    gettesttypelist();

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

    //Function for getting the list of test types from the server and populating the table
    function gettesttypelist()
    {
        $.get("../controllers/testtype/gettesttypes.php" , {} , function(data)
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
                    $("#testtypebody").html("");

                    //Loop through the testtype array and populate the table
                    for(let i=0; i<response.testtypes.length; i++)
                    {
                        let testtype = response.testtypes[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${testtype.testid}</th>
                            <td>${testtype.testname}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(testtype.teststatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(testtype.teststatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the test type details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${testtype.testid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${testtype.testid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#testtypebody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#edittestid").val(response.testtypes[index].testid);
                        $("#edittestname").val(response.testtypes[index].testname);
                        $("#editteststatus").prop("checked" , response.testtypes[index].teststatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the test type and return if user denied
                        if(confirm("Are you sure you want to delete this test type?") == false)
                        {
                            return;
                        }

                        let testid = $(this).attr("data-id");
                        $.post("../controllers/testtype/deletetesttype.php" , {"testid":testid} , function(data)
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
                                    alert("Test Type deleted successfully");

                                    //Repopulate the test type list
                                    gettesttypelist();
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

    gettesttypelist();
});