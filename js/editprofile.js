$(function() {
    $(".currentpage").text("Edit Profile");
    let studentdata = {};

    function getstudentdata() {
        $.ajax({
            type: "POST",
            url: "controllers/student/getstudentdata.php",
            processData: false,
            contentType: false,
            success: function(data) {
                try {
                    // Parse the data received from the server
                    let response = JSON.parse(data);

                    // If the response is not successful, then show the error in alert
                    if (response.success == false) {
                        showalert(response.error);
                        if (response.login == true) {
                            window.location.href = "login.php";
                        }
                    } else {
                        studentdata = response.studentdata;

                        // Set the data received from the server
                        $("#editname").val(response.studentdata.name);
                        $("#editemail").val(response.studentdata.email);
                        $("#editphone").val(response.studentdata.phone);
                        $("#editpincode").val(response.studentdata.pincode);
                        $("#editsurname").val(response.studentdata.surname);
                        $("#editparentname").val(response.studentdata.parentname);
                        $("#editparentemail").val(response.studentdata.parentemail);
                        $("#editparentphone").val(response.studentdata.parentphone);
                        $("#editaddress").val(response.studentdata.address);
                        $("#editbirthdate").val(response.studentdata.birthdate);
                        $("#editgender option[value='" + response.studentdata.gender + "']").prop("selected", true);
                    }
                } catch (error) {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
    }

    getstudentdata();

    function getCountries() {
        $.get("controllers/student/getcountries.php", {}, function(data) {
            try {
                // Parse the data received from the server
                let response = JSON.parse(data);

                // If the response is not successful, then show the error in alert
                if (response.success == false) {
                    showalert(response.error);
                    if (response.login == true) {
                        window.location.href = "login.php";
                    }
                } else {
                    $("#editcountry").html(`<option selected hidden disabled value="">Select Country</option>`);

                    // Set the data received from the server
                    for (let i = 0; i < response.countries.length; i++) {
                        let country = response.countries[i];
                        $("#editcountry").append(`<option value="${country.id}" ${country.id == studentdata.staticcountryid ? "selected" : ""}>${country.name}</option>`);
                    }

                    // If a country is selected, get the states
                    if (studentdata.staticcountryid) {
                        getStates(studentdata.staticcountryid);
                    }
                }
            } catch (error) {
                alert("Error occurred while trying to read server response");
            }
        });
    }

    getCountries();

    function getStates(countryid) {
        $.get("controllers/student/getstates.php", { "countryid": countryid }, function(data) {
            try {
                // Parse the data received from the server
                let response = JSON.parse(data);

                // If the response is not successful, then show the error in alert
                if (response.success == false) {
                    showalert(response.error);
                    if (response.login == true) {
                        window.location.href = "login.php";
                    }
                } else {
                    $("#editstate").html(`<option selected hidden disabled value="">Select State</option>`);

                    // Set the data received from the server
                    for (let i = 0; i < response.states.length; i++) {
                        let state = response.states[i];
                        $("#editstate").append(`<option value="${state.id}" ${state.id == studentdata.staticstateid ? "selected" : ""}>${state.name}</option>`);
                    }

                    // If a state is selected, get the cities
                    if (studentdata.staticstateid && $("#editstate").val() != null && $("#editstate").val() != "") {
                        getCities(studentdata.staticstateid);
                    } else if ($("#editstate").val() == null || $("#editstate").val() == "") {
                        $("#editcity").html(`<option selected hidden disabled value="">Select City</option>`);
                    } 
                    // else {
                    //     getCities($("#editstate").val());
                    // }
                }
            } catch (error) {
                alert("Error occurred while trying to read server response");
            }
        });
    }

    $("#editcountry").change(function() {
        getStates($("#editcountry").val());
    });

    function getCities(stateid) {
        $.get("controllers/student/getcities.php", { "stateid": stateid }, function(data) {
            try {
                // Parse the data received from the server
                let response = JSON.parse(data);

                // If the response is not successful, then show the error in alert
                if (response.success == false) {
                    showalert(response.error);
                    if (response.login == true) {
                        window.location.href = "login.php";
                    }
                } else {
                    $("#editcity").html(`<option selected hidden disabled value="">Select City</option>`);

                    // Set the data received from the server
                    for (let i = 0; i < response.cities.length; i++) {
                        let city = response.cities[i];
                        $("#editcity").append(`<option value="${city.id}" ${city.id == studentdata.staticcityid ? "selected" : ""}>${city.name}</option>`);
                    }
                }
            } catch (error) {
                alert("Error occurred while trying to read server response");
            }
        });
    }

    $("#editstate").change(function() {
        getCities($("#editstate").val());
    });

    $('#editprofilepic').change(function(event) {
        let input = event.target;
        let reader = new FileReader();
        reader.onload = function() {
            let dataURL = reader.result;
            $('#viewprofilepic').attr('src', dataURL);
        };
        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    });

    $("#editprofile").on("submit", function(e) {
        e.preventDefault();

        let formdata = new FormData(this);
        formdata.append("oldprofilepic", $(".profilepic").get(0).src.split("/").pop());
        $.ajax({
            type: "POST",
            url: "controllers/student/updateprofile.php",
            data: formdata,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
                try {
                    // Parse the data received from the server
                    let response = JSON.parse(data);

                    // If the response is not successful, then show the error in alert
                    if (response.success == false) {
                        showalert(response.error);
                        if (response.login == true) {
                            window.location.href = "login.php";
                        }
                    } else {
                        showalert("Your Profile updated successfully");

                        $("#alertModal").on("hidden.bs.modal", function() {
                            window.location.href = "dashboard.php";
                        });
                    }
                } catch (error) {
                    alert("Error occurred while trying to read server response");
                }
            }
        });
    });
});
