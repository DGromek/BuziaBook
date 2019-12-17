<?php
$postContent = "";
$postContentErr = "";
$postAddedInfo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["postContent"])) {
        $postContentErr = "To pole jest wymagane!";
    }

    if (empty($postContentErr)) {
        $loggedUserEmail = $_SESSION['loggedUserEmail'];

        $takeUserQuery = "SELECT id from user where email='$loggedUserEmail'";
        $result = mysqli_query($connection, $takeUserQuery);
        $resultArray = mysqli_fetch_assoc($result);
        $id = $resultArray['id'];

        $postContent = mysqli_real_escape_string($connection, $_POST["postContent"]);
        $addPostQuery = "INSERT INTO post(user_id, content) VALUES ('$id', '$postContent')";
        mysqli_query($connection, $addPostQuery);
        $postAddedInfo = "Post dodano pomyślnie!";
    }

}
?>