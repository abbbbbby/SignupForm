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
            <label for="fname">First name*:</label>
            <input 
              type="text" 
              name="first_name_input" 
              placeholder="John" 
              size="19" 
              oninvalid="this.setCustomValidity('Please enter your first name')" 
              required
            /><br><br>
            <label for="last_name_input">Last Name:</label>
            <input type="text" name="last_name_input" placeholder="Doe"/><br><br>
            <label for="email_input">Email*:</label>
            <input 
              type="email" 
              name="email_input" 
              placeholder="example@example.com" 
              size="24" 
              oninvalid="this.setCustomValidity('Please enter valid email')" 
              required
            /><br><br>
            <label for="number_input">Phone Number:</label>
            <input type="text" name="number_input" placeholder="###-###-####" size="16"/><br><br><br>
            <div id="button"><input type="submit" class="btn btn-info" value="Submit Form"></div>
        </form>
    <div/>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!--script type="text/javascript" src="validate.js"></script>
    <script type="text/javascript" src="transitions.js"></script-->
</body>
</html>

<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $websiteErr = "";
$name = $email = $gender = $comment = $website = "";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
}
?>
