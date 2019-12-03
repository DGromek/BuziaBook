<?php

$firstName = $lastName = $email = $password = "";
$firstNameErr = $lastNameErr = $emailErr = $passwordErr = $repeatedPasswordErr = "";


//User input validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstName"])) {
        $firstNameErr = "To pole jest wymagane!";
    }
    $firstName = test_input($_POST["firstName"]);

    if (empty($_POST["lastName"])) {
        $lastNameErr = "To pole jest wymagane!";
    }
    $lastName = test_input($_POST["lastName"]);

    if (empty($_POST["email"])) {
        $emailErr = "To pole jest wymagane!";
    }
    $email = test_input($_POST["email"]);

    if (empty($_POST["password"])) {
        $passwordErr = "To pole jest wymagane!";
    } else {
        if ($_POST["password"] === $_POST["repeatedPassword"]) {
            $password = test_input($_POST["password"]);
        } else {
            $repeatedPasswordErr = "Hasła różnią się.";
        }
    }

    //Checking if email is unique and saving user to DB.
    if ($firstNameErr === "" && $lastNameErr === "" && $emailErr === "" && $passwordErr === "" && $repeatedPasswordErr === "") {
        $connection = new mysqli("localhost", "root", "", "buziabook");

        $userCheckQuery = "SELECT * FROM user WHERE email='$email'";
        $result = mysqli_query($connection, $useCheckQuery);

        if ($result != NULL) {
            $emailErr = "Istnieje użytkownik o takim adresie email.";
        } else {
            $sql = "INSERT INTO (first_name, last_name, email, password) VALUES ('$firstName', '$lastName', '$email', '$password')";
            echo "WSZYSTKO GICIK ZIOMEK";
        }

        $connection->close();
    }

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

echo "AAAAA";
echo $firstName . $firstNameErr . "\n";
echo $lastName . $lastNameErr . "\n";
echo $password . $passwordErr . "\n";
echo $email . $emailErr . "\n";
?>