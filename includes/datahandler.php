<?php 

class DataHandler {
    //Stores cleaned and stripped first name
    private $fname;

    //Stores cleaned and stripped last name
    private $lname;
    private $hasLname = false; //True if user inputted last name

    //Stores cleaned and stripped email
    private $email;

    //Stores cleaned and stripped phone number
    private $number;
    private $hasNumber = false; //True if user inputted phone number


    //Stores generated hex id
    private $hexId;

    //DataHandler generates the hexID from the email 
    public function __construct($fname, $lname, $email, $number) {
        if(!isset($fname) || !isset($email)) {
            throw new InvalidArgumentException("First name and email not set");
        }

        $this->fname = $fname;
        $this->email = $email;

        if(isset($lname)) {
            $this->hasLname = true;
            $this->lname = $lname;
        }

        if(isset($number)) {
            $this->hasNumber = true;
            $this->number = $number;
        }

        //Generate hex code from email
        $this->hexId = bin2hex($this->email);
    }

    //Posts the data passed into the DataHandler object to the API endpoint
    //Returns 1 (true) if the post was successfully created, and 0 (false) if not
    function postData() {
        //Post data to: https://webhook.site/d419ed99-5060-49c1-bff0-c699a4af5da4
        $url = "https://webhook.site/d419ed99-5060-49c1-bff0-c699a4af5da4";
        $curl = curl_init($url);

        $data = [
            "first_name" => $this->fname,
            "email" => $this->email,
            "hex_id" => $this->hexId
        ];

        #echo $this->fname;
        #echo $this->email;
        #echo $this->hexId;

        if($this->hasLname) {
            $data["last_name"] = $this->lname;
            #echo $this->lname;
        }

        if($this->hasNumber) {
            $data["number"] = $this->number;
            #echo $this->number;
        }

        //Posting data to the API endpoint
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "APIKEY: 111111111111111111111111111",
            "Content-Type: application/json",
         ]);

        //If posted correctly, response should = 1
        $response = curl_exec($curl);
        curl_close($curl);

        //Response should equal to 1 if post was completed
        return $response;
    }

    //Redirects to results.php which will display the user input as well
    //as the hex id generated
    function displayResults() {
        //Redirecting to a page which will display results
        header('location: results.php');
        
        //Creating a session so data can be accessed by the results page
        session_start();
        $_SESSION["first_name"] = $this->fname;
        $_SESSION["email"] = $this->email;
        $_SESSION["hex_id"] = $this->hexId;
        
        if($this->hasLname) {
            $_SESSION["last_name"] = $this->lname;
            #echo $this->lname;
        }

        if($this->hasNumber) {
            $_SESSION["number"] = $this->number;
            #echo $this->number;
        }
    }
}
?>