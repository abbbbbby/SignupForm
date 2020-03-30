<?php
#HOME PAGE

include "includes/dataHandler.php";

//Errors that are displayed when invalid input is submitted
$fnameErr = $lnameErr = $emailErr = $numErr = "";

//Stores the user input, and eventually gets passed to the dataHandler
$fname = $lname = $email = $number = "";
//Ignore this--I used it for debugging
$successMessage = "";

//Used to clean and strip the data 
//NOTE: I'm not entirely sure how to 
//get rid of SQL injections without using
//a prepares statement so I didn't do that (sorry!)
function cleanInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

//When the user hits submit, this PHP code performs
//Form validation. If the input is valid, it will accept
//and put it into a DataHandler() object that will
//post to an API endpoint and will redirect to a page
//displaying the submission results.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //Boolean variables used to indicate whether data is valid or not
  $validFname = $validEmail = $validNumber = $validLname = false;

  //Validation of first name
  if (empty($_POST["first_name_input"])) {
    $fnameErr = "*Name required"; //First name is a required input
    $validFname = false;
  } else {
    $fname = cleanInput($_POST["first_name_input"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
      $fnameErr = "Invalid name";
      $validFname = false;
    } else {
      $validFname = true;
    }
  }

  //Last name validation
  if (empty($_POST["last_name_input"])) {
    $lname = null; //Last name is not required input
    $validLname = true;
  } else {
    $lname = cleanInput($_POST["last_name_input"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
      $lnameErr = "Invalid name";
      $validLname = false;
    } else {
      $validLname = true;
    }
  }

  //Email validation
  if (empty($_POST["email_input"])) {
    $emailErr = "*Email required"; //Email is required input
    $validEmail = false;
  } else {
    $email = cleanInput($_POST["email_input"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "*Invalid email";
      $validEmail = false;
    } else {
      $validEmail = true;
    }
  }

  //Phone number validation
  if (empty($_POST["number_input"])) {
    $number = null; //Phone number not required
    $validNumber = true;
  } else {
    $number = cleanInput($_POST["number_input"]);
    //check that number has 7 digits and no letters
    if(preg_match("/[a-zA-Z]/", $number)) { //Ensurign there are no letters
      $numErr = "*Invalid number";
      $validNumber = false;
    } else {
      $number = preg_replace("/[^0-9]/","", $number); //Stripping out additional characters that aren't numbers
      if(strlen($number) != 10) { //Checks to make sure number is 10 digits
        $numErr = "*Invalid number";
        $validNumber = false;
      } else {
        $validNumber = true;
      }
    }
  }

  //If all data is validated
  if($validEmail && $validFname && $validNumber && $validLname) {
    //Data handler will post the values to the API endpoint
    $dataHandler = new DataHandler($fname, $lname, $email, $number);
    //Posting data to endpoint
    $dataHandler->postData();

    //Redirecting to results page
    $dataHandler->displayResults();

    $successMessage = "Thank you for your submission!";
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Sign Up Form</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--CSS file-->
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body id=everything>
    
    <!--Sign Up Form: contains first/last name, email, and number input as well as a button to submit the form-->
    <div id=signup_form>
        <h1 class=title>Sign Up!</h1>

        <!--Form-posts to itself for data validation-->
        <form id=inputs method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
            <!--First name input - REQUIRED-->
            <label for="first_name_input">First name*:</label>
            <input type="text" name="first_name_input" placeholder="John" size="19"/>
            <span class="error"><?php echo $fnameErr;?></span><br><br>

            <!--Last name input - NOT REQUIRED-->
            <label for="last_name_input">Last Name:</label>
            <input type="text" name="last_name_input" placeholder="Doe"/>
            <span class="error"><?php echo $lnameErr;?></span><br><br>

            <!--Email input - REQUIRED-->
            <label for="email">Email*:</label>
            <input type="text" name="email_input" placeholder="example@example.com" size="24"/>
            <span class="error"><?php echo $emailErr;?></span><br><br>

            <!--Phone number input - NOT REQUIRED-->
            <label for="number_input">Phone Number:</label>
            <input type="text" name="number_input" placeholder="###-###-####" size="16"/>
            <span class="error"><?php echo $numErr;?></span><br><br><br>

            <!--Submit button-->
            <div id="button"><input type="submit" class="btn btn-info" value="Submit Form"></div>
        </form>
        <?echo $successMessage?>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--script type="text/javascript" src="validate.js"></script>
    <script type="text/javascript" src="transitions.js"></script-->
</body>
</html>
