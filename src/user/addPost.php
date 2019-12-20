<?php
$postContent = "";
require "variables.php";
require "../core/dbAndSession.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["postContent"])) {
        $postContentErr = "To pole jest wymagane!";
    }

    if (empty($postContentErr)) {
        $loggedUserEmail = $_SESSION['loggedUserEmail'];

        //User
        $takeUserQuery = "SELECT id from user where email='$loggedUserEmail'";
        $result = mysqli_query($connection, $takeUserQuery);
        $resultArray = mysqli_fetch_assoc($result);
        $userId = $resultArray['id'];
        $groupId = null;

        //Getting post content
        $postContent = mysqli_real_escape_string($connection, $_POST["postContent"]);
        $addPostQuery = "INSERT INTO post(user_id, content) VALUES ('$userId', '$postContent')";

        //Getting group if needed
        if (isset($_GET['group'])) {
            $communityName = $_GET['group'];
            $findcommunityIdQuery = "SELECT id from community where name='$communityName'";
            $result = mysqli_query($connection, $findcommunityIdQuery);
            $resultArray = mysqli_fetch_assoc($result);
            $groupId = $resultArray['id'];
            $addPostQuery = "INSERT INTO post(user_id, content, community_id) VALUES ('$userId', '$postContent', '$groupId')";
        }

        //Saving post to db
        mysqli_query($connection, $addPostQuery);
        $successInfo = "Post dodano pomyślnie!";
    }

}

$url = '/buziaBook/src/user/wall.php?';
if (isset($_GET['group'])) {
    $url = $url . 'group='.$_GET['group'];
}

header('Location: ' . $url);
?>