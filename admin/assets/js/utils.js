//Global variable for storing the country and state list
let countries;
let states;
let cities;
let academics;
let levelofcourses;
let otherfees;
let financialaids;

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

//Function for populating the options in a dropdown menu
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

//Function for populating other fees in a dropdown menu
function populateuniversityotherfees(elementid)
{
    $(elementid).html(`<option disabled selected value="">Select Other Fees</option>`);
    otherfees.forEach(function(otherfee)
    {
        $(elementid).append(`
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="levelofcourse-${otherfee.otherfeeid}" value="${otherfee.otherfeeid}">
            <label class="form-check-label" for="levelofcourse-${otherfee.otherfeeid}">${otherfee.otherfeename}</label>
        </div>
        `);
    });
}

//Function for populating financial aid in a dropdown menu
function populateuniversityfinancialaid(elementid)
{
    $(elementid).html(`<option disabled selected value="">Select Financial Aid</option>`);
    financialaids.forEach(function(financialaid)
    {
        $(elementid).append(`
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="levelofcourse-${financialaid.financialaidid}" value="${financialaid.financialaid}">
            <label class="form-check-label" for="levelofcourse-${financialaid.financialaidid}">${financialaid.financialaidname}</label>
        </div>
        `);
    });
}