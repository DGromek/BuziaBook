<?php
session_start(); 
$firstName = $lastName = $email = $password = "";
$firstNameErr = $lastNameErr = $emailErr = $passwordErr = $repeatedPasswordErr = "";
$connection = new mysqli("localhost", "root", "", "buziabook");

//User input validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstName"])) {
        $firstNameErr = "To pole jest wymagane!";
    }
    $firstName = mysqli_real_escape_string($connection, $_POST["firstName"]);

    if (empty($_POST["lastName"])) {
        $lastNameErr = "To pole jest wymagane!";
    }
    $lastName = mysqli_real_escape_string($connection, $_POST["lastName"]);
    

    if (empty($_POST["email"])) {
        $emailErr = "To pole jest wymagane!";
    }
    $email = mysqli_real_escape_string($connection, $_POST["email"]);

    if (empty($_POST["password"])) {
        $passwordErr = "To pole jest wymagane!";
    } else {
        if ($_POST["password"] === $_POST["repeatedPassword"]) {
            $password = mysqli_real_escape_string($connection, $_POST["password"]);
            $password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $repeatedPasswordErr = "Hasła różnią się.";
        }
    }

    //Checking if email is unique and saving user to DB.
    if ($firstNameErr === "" && $lastNameErr === "" && $emailErr === "" && $passwordErr === "" && $repeatedPasswordErr === "") {

        $userCheckQuery = "SELECT * FROM user WHERE email='$email'";
        $result = mysqli_query($connection, $userCheckQuery);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            $emailErr = "Istnieje użytkownik o takim adresie email.";
        } else {
            $sql = "INSERT INTO user(first_name, last_name, email, password) VALUES ('$firstName', '$lastName', '$email', '$password')";
            $connection->query($sql);
            $_SESSION['loggedUser'] = $firstName;
            header('Location: /buziaBook/src/user/wall.php');
        }
    }
    $connection->close();
}

?>