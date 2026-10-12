<?php
    // Functie: classdefinitie User 
    // Auteur: Nimrod

    class User{

        // Eigenschappen 
        public string $username = "";
        public string $email = "";
        private string $password = "";
        
        function setPassword($password){
            $this->password = $password;
        }
        function getPassword(){
            return $this->password;
        }

        public function showUser() {
            echo "<br>Username: $this->username<br>";
            echo "<br>Password: $this->password<br>";
            echo "<br>Email: $this->email<br>";
            
        }

        public function registerUser() : array {
    $errors = [];

    if($this->username != ""){

        // Connect database
        $conn = $this->dbConnect();

        // Check user exist in database
        $sql = "SELECT * FROM user WHERE username = :username";

        $statement = $conn->prepare($sql);
        $statement->execute([
            'username' => $this->username
        ]);

        if($statement->rowCount() > 0){

            array_push($errors, "Username bestaat al.");

        } else {

            $sql = "INSERT INTO user (username, password)
                    VALUES (:username, :password)";

            $statement = $conn->prepare($sql);

            $statement->execute([
                'username' => $this->username,
                'password' => password_hash($this->getPassword(), PASSWORD_DEFAULT)
            ]);
        }
    }

    return $errors;
}

       function validateUser(): array
   {
    $errors = [];

    if (empty($this->username)) {
        array_push($errors, "Invalid username");
    } elseif (strlen($this->username) < 3 || strlen($this->username) > 50) {
        array_push($errors, "Username moet tussen 3 en 50 tekens zijn.");
    }

    if (empty($this->password)) {
        array_push($errors, "Invalid password");
    }

    return $errors;
   }



public function loginUser(): bool
{
    // Maak verbinding met de database
    $conn = $this->dbConnect();

    // Zoek de gebruiker op via de username
    $sql = "SELECT * FROM `user` WHERE username = :username";
    $statement = $conn->prepare($sql);

    $statement->execute([
        'username' => $this->username
    ]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Gebruiker niet gevonden
    if ($user === false) {
        return false;
    }

    // Controleer het wachtwoord
    if (!password_verify($this->password, $user['password'])) {
        return false;
    }

    // Start de sessie indien nodig
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION['userId'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    return true;
}



        public function isLoggedin(): bool {

            if(session_status() == PHP_SESSION_NONE){
             session_start();
    }


    return isset($_SESSION['userId']);


}



        public function getUser(string $username): bool {
            // Connect database

		    // Doe SELECT * from user WHERE username = $username

            if (false){
                //Indien gevonden eigenschappen vullen met waarden uit de SELECT
                $this->username = 'Waarde uit de database';
                return true;
            } else {
                return false;
            }   
        }


        public function dbConnect()
{
    include __DIR__ . "/../config.php";

    try {
        $conn = new PDO(
            "mysql:host=$servername;dbname=$dbname",
            $username,
            $password
        );

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;

    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

 public function logout(){

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    session_unset();

    session_destroy();
}




} 



?>




