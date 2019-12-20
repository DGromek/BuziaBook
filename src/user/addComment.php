<?php
$commentContent = "";
require "variables.php";
require "../core/dbAndSession.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["commentContent"])) {
        $commentContentErr = "To pole jest wymagane!";
    }

    if (empty($commentContentErr)) {
        $loggedUserEmail = $_SESSION['loggedUserEmail'];

        //User
        $takeUserQuery = "SELECT id from user where email='$loggedUserEmail'";
        $result = mysqli_query($connection, $takeUserQuery);
        $resultArray = mysqli_fetch_assoc($result);
        $userId = $resultArray['id'];
        
        //Post id
        $postId = $_GET['postId'];

        //Getting comment content
        $commentContent = mysqli_real_escape_string($connection, $_POST["commentContent"]);
        $addCommentQuery = "INSERT INTO comment(post_id, user_id, content) VALUES ('$postId', '$userId', '$commentContent')";


        //Saving post to db
        mysqli_query($connection, $addCommentQuery);
        $postAddedInfo = "Post dodano pomyślnie!";
    }

}

$url = '/buziaBook/src/user/getComments.php?';
if (isset($_GET['group'])) {
    $url = $url . 'group='.$_GET['group'];
}
echo $url;
header('Location: ' . $url);
?>