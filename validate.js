//Initialize text inputs
var firstNameInput = document.getElementById("first_name_input");
var lastNameInput = document.getElementById("last_name_input");
var emailInput = document.getElementById("email_input");
var numberInput = document.getElementById("number_input");

//Initialize text warning flags
var firstNameWarning = document.getElementById("no_name_warning");
var noEmailWarning = document.getElementById("no_email_warning");
var invalidEmailWarning = document.getElementById("inv_email_warning");

function validateEmail() {

}

function validateInputs() {
    if(validateEmail()) {
        //TODO: accept input and move it to backend
        transitionForward();
    }
}
