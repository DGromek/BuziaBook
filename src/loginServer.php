<?php
session_start(); 
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $connection = new mysqli("localhost", "root", "", "buziabook");

    $email = mysqli_real_escape_string($connection, $_POST["email"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);

    $userCheckQuery = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($connection, $userCheckQuery);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['password'] === $password) {
            $_SESSION["loggedUser"] = $firstName;
            header('Location: wall.php');
        }
    } else {
        $loginErr = "Wprowadzono nieprawidłowe dane logowania!";
    }
}
?>