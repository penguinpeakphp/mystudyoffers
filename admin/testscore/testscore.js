$(function()
{
    $(".add").on("click" , function()
    {
        $("#addmodal").modal("show");
    });

    $("#addform").on("submit" , function(e)
    {
        e.preventDefault();

        //Fetch the testscore name and the status
        let testscore = $("#addtestscore").val();
        let testscorestatus = $("#addtestscorestatus").prop("checked") ? 1 : 0;

        //Send the post request for adding the new test score
        $.post("../controllers/testscore/addtestscore.php" , {"testscore":testscore , "testscorestatus":testscorestatus} , function(data)
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
                    alert("Test Score inserted successfully");

                    //Repopulate the testscore list
                    gettestscorelist();

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

        //Fetch the testscoreid , test score and the status
        let testscoreid = $("#edittestscoreid").val();
        let testscore = $("#edittestscore").val();
        let testscorestatus = $("#edittestscorestatus").prop("checked") ? 1 : 0;

        //Send the post request for updating the test score
        $.post("../controllers/testscore/edittestscore.php" , {"testscoreid":testscoreid , "testscore":testscore , "testscorestatus":testscorestatus} , function(data)
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
                    alert("Test Score updated successfully");

                    //Repopulate the testscore list
                    gettestscorelist();

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

    //Function for getting the list of test scores from the server and populating the table
    function gettestscorelist()
    {
        $.get("../controllers/testscore/gettestscores.php" , {} , function(data)
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
                    $("#testscorebody").html("");

                    //Loop through the test score array and populate the table
                    for(let i=0; i<response.testscores.length; i++)
                    {
                        let testscore = response.testscores[i];

                        //Build the table row and its content
                        let tr = `
                        <tr>
                            <th scope="row">${testscore.testscoreid}</th>
                            <td>${testscore.testscore}</td>
                        `;
    
                        //Render badge based on the status flag
                        if(testscore.testscorestatus == 1)
                        {
                            tr += `<td><span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Active</span></td>`;
                        }
                        if(testscore.testscorestatus == 0)
                        {
                            tr += `<td><span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> Inactive</span></td>`;
                        }
    
                        //Render buttons and have index in the data-index attribute to fetch the testscore details for editing
                        tr += `<td>
                            <button type="button" class="btn btn-warning edit" data-index="${i}" data-id="${testscore.testscoreid}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete" data-id="${testscore.testscoreid}"><i class="bi-trash"></i></button>
                        </td>`;
    
                        tr += "</td>";
    
                        //Append the table row in the table body
                        $("#testscorebody").append(tr);
                    }

                    //Event for opening the edit modal on clicking the edit button
                    $(".edit").on("click" , function()
                    {
                        //Open the modal
                        $("#editmodal").modal("show");

                        //Fetch and fill the details from the response that we have got with the help of the index
                        let index = $(this).attr("data-index");
                        $("#edittestscoreid").val(response.testscores[index].testscoreid);
                        $("#edittestscore").val(response.testscores[index].testscore);
                        $("#edittestscorestatus").prop("checked" , response.testscores[index].testscorestatus == "1" ? true : false);
                    });

                    //Event for making deleting request to the server on click
                    $(".delete").on("click" , function()
                    {
                        //Get the confirmation from the user for deleting the test score and return if user denied
                        if(confirm("Are you sure you want to delete this test score?") == false)
                        {
                            return;
                        }

                        let testscoreid = $(this).attr("data-id");
                        $.post("../controllers/testscore/deletetestscore.php" , {"testscoreid":testscoreid} , function(data)
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
                                    alert("Test Score deleted successfully");

                                    //Repopulate the testscore list
                                    gettestscorelist();
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

    gettestscorelist();
});