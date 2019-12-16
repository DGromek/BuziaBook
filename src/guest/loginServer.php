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

    if (!empty($user)) {
        $result = password_verify($password, $user['password']);
        if ($result) {
            $_SESSION["loggedUser"] = $user["first_name"];
            header('Location: /buziaBook/src/user/wall.php');
        } else {
            $loginErr = "Wprowadzono nieprawidłowe dane logowania!";
        }
    } else {
        $loginErr = "Wprowadzono nieprawidłowe dane logowania!";
    }
}
?>