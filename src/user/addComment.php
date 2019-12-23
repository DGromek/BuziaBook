<?php
$commentContent = "";

require "../core/dbAndSession.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Post id
    $postId = $_GET['postId'];

    if (empty($_POST["commentContent"])) {
        $_SESSION['commentContentErr'] = "To pole jest wymagane!";
    }

    if (empty($_SESSION['commentContentErr'])) {
        $loggedUserEmail = $_SESSION['loggedUserEmail'];

        //User
        $takeUserQuery = "SELECT id from user where email='$loggedUserEmail'";
        $result = mysqli_query($connection, $takeUserQuery);
        $resultArray = mysqli_fetch_assoc($result);
        $userId = $resultArray['id'];

        //Getting comment content
        $commentContent = mysqli_real_escape_string($connection, $_POST["commentContent"]);
        $addCommentQuery = "INSERT INTO comment(post_id, user_id, content) VALUES ('$postId', '$userId', '$commentContent')";


        //Saving comment to db
        mysqli_query($connection, $addCommentQuery);
        $_SESSION['successInfo'] = "Komentarz dodano pomyślnie!";
    }

}

$url = '/buziaBook/src/user/getComments.php?';
if (isset($_GET['group'])) {
    $url = $url . 'group='.$_GET['group'] . '&';
}
$url = $url . 'postId='. $postId;
echo $url;
header('Location: ' . $url);
?>