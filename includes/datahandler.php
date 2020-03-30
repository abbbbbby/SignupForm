<?php 

class DataHandler {
    //TODO: Prevent SQL injections and make hex code generator

    private $fname;

    private $hasLname = false;
    private $lname;

    private $email;

    private $hasNumber = false;
    private $number;

    private $hexId;

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

        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "APIKEY: 111111111111111111111111111",
            "Content-Type: application/json",
         ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
?>