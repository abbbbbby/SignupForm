<?php

include "includes/dataHandler.php";

// define variables and set to empty values
$fnameErr = $lnameErr = $emailErr = $numErr = "";
$fname = $lname = $email = $number = "";
$successMessage = "";

function cleanInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $validFname = $validEmail = $validNumber = $validLname = false;
  if (empty($_POST["first_name_input"])) {
    $fnameErr = "*Name required";
  } else {
    $fname = cleanInput($_POST["first_name_input"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
      $fnameErr = "No numbers/special characters";
    } else {
      $validFname = true;
    }
  }

  if (empty($_POST["last_name_input"])) {
    $lname = null;
    $validLname = true;
  } else {
    $lname = cleanInput($_POST["last_name_input"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
      $lnameErr = "No numbers/special characters";
    } else {
      $validLname = true;
    }
  }

  if (empty($_POST["email_input"])) {
    $emailErr = "*Email required";
  } else {
    $email = cleanInput($_POST["email_input"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "*Invalid email";
    } else {
      $validEmail = true;
    }
  }

  if (empty($_POST["number_input"])) {
    $number = null;
    $validNumber = true;
  } else {
    $number = cleanInput($_POST["number_input"]);
    //check that number has 7 digits and no letters
    if(preg_match("/^[^a-zA-Z]$/", $number)) {
      $numErr = "*Invalid phone number" . $number;
    } else {
      $number = preg_replace("/[^0-9]/","", $number);
      if(strlen($number) != 10) {
        $numErr = "*Expecting a 10-digit phone number";
      } else {
        $validNumber = true;
      }
    }
  }

  if($validEmail && $validFname) {
    $dataHandler = new DataHandler($fname, $lname, $email, $number);
    echo $dataHandler->postData();
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

    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body id=everything>
    
    <!--Sign Up Form: contains first/last name, email, and number input as well as a button to submit the form-->
    <div id=signup_form>
        <h1 class=title>Sign Up!</h1>
        <form id=inputs method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
            <label for="first_name_input">First name*:</label>
            <input type="text" name="first_name_input" placeholder="John" size="19"/>
            <span class="error"><?php echo $fnameErr;?></span><br><br>
            <label for="last_name_input">Last Name:</label>
            <input type="text" name="last_name_input" placeholder="Doe"/>
            <span class="error"><?php echo $lnameErr;?></span><br><br>
            <label for="email">Email*:</label>
            <input type="text" name="email_input" placeholder="example@example.com" size="24"/>
            <span class="error"><?php echo $emailErr;?></span><br><br>
            <label for="number_input">Phone Number:</label>
            <input type="text" name="number_input" placeholder="###-###-####" size="16"/>
            <span class="error"><?php echo $numErr;?></span><br><br><br>
            <div id="button"><input type="submit" class="btn btn-info" value="Submit Form"></div>
        </form>
        <?echo $successMessage?>
    <div/>
<!--
    <div id=results>
      <h1 class=title>Thank you for Submitting! Here's what we have:</h1>
      <div id=outputs>
          <div class=inp>
              First name: <?php //echo $fname; ?>
          </div>
          <div class=inp>
              Last name: <?php //echo $lname; ?>
          </div>
          <div class=inp>
              Email Address: <?php //echo $email; ?>
          </div>
          <div class=inp>
              Phone Number: <?php //echo $number; ?>
          </div>
          <div class=inp>
              Unique Hex Code: <?php //echo $hexCode; ?>
          </div>
      </div>
    </div>
-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--script type="text/javascript" src="validate.js"></script>
    <script type="text/javascript" src="transitions.js"></script-->
</body>
</html>
