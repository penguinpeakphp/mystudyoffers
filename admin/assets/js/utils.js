//Global variable for storing the country and state list
let countries;
let states;
let cities;
let academics;
let levelofcourses;

//Function for populating the options in a select/option menu
function populatecountries(elementid)
{
    $(elementid).html(`<option disabled selected value="">Select Country</option>`);
    countries.forEach(function(country)
    {
        $(elementid).append(`
            <option value="${country.countryid}">${country.countryname}</option>
        `);
    });
}

//Function for populating the options in a select/option menu
function populatestates(elementid)
{
    $(elementid).html(`<option disabled selected value="">Select State</option>`);
    states.forEach(function(state)
    {
        $(elementid).append(`
            <option value="${state.stateid}">${state.statename}</option>
        `);
    });
}

//Function for populating the options in a select/option menu
function populatecities(elementid)
{
    $(elementid).html(`<option disabled selected value="">Select City</option>`)
    cities.forEach(function(city)
    {
        $(elementid).append(`
            <option value="${city.cityid}">${city.cityname}</option>
        `);
    });
}

//Function for populating the options in a select/option menu
function populateacademics(elementid)
{
    $(elementid).html(`<option disabled selected value="">Select Academic Qualification</option>`);
    academics.forEach(function(academic)
    {
        $(elementid).append(`
            <option value="${academic.academicid}">${academic.academicname}</option>
        `)
    });
}

//Function for populating the options in a select/option menu
function populatelevelofcourses(elementid)
{
    $(elementid).html(`<option disabled selected value="">Select Level of Courses</option>`);
    levelofcourses.forEach(function(levelofcourse)
    {
        $(elementid).append(`
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="levelofcourse-${levelofcourse.levelofcourseid}" value="${levelofcourse.levelofcourseid}">
            <label class="form-check-label" for="levelofcourse-${levelofcourse.levelofcourseid}">${levelofcourse.levelofcoursename}</label>
        </div>
        `);
    });
}