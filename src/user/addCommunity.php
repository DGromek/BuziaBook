<?php
$commentContent = "";

require "../core/dbAndSession.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["groupName"])) {
        $_SESSION['groupNameErr'] = "Musisz podać nazwę grupy!";
        header('Location: /buziaBook/src/user/wall.php');
    }

    if (empty($_SESSION['commentContentErr'])) {
        $loggedUserEmail = $_SESSION['loggedUserEmail'];

        //User
        $takeUserQuery = "SELECT id from user where email='$loggedUserEmail'";
        $result = mysqli_query($connection, $takeUserQuery);
        $resultArray = mysqli_fetch_assoc($result);
        $userId = $resultArray['id'];
        
        $communityDescription = mysqli_real_escape_string($connection, $_POST['groupDescription']);
        $communityName = mysqli_real_escape_string($connection, $_POST['groupName']);

        $checkGroupNameQuery = "SELECT * FROM community WHERE name='$communityName'";
        $result = mysqli_query($connection, $checkGroupNameQuery);
        //echo json_encode();

        if (mysqli_fetch_array($result)) {
            $_SESSION['groupNameErr'] = "Grupa o takiej nazwie już istnieje!";
            header('Location: /buziaBook/src/user/wall.php');
        } else {
            $addGroupQuery = "INSERT INTO community(name, description) VALUES ('$communityName', '$communityDescription')";
            $result = mysqli_query($connection, $addGroupQuery);

            $getGroupIdQuery = "SELECT id FROM community WHERE name='$communityName'";
            $result = mysqli_query($connection, $getGroupIdQuery);
            $row = mysqli_fetch_array($result);
            $communityId = $row['id'];

            $communityUserInsertQuery = "INSERT INTO user_community (user_id, community_id) values ('$userId', '$communityId')";
            mysqli_query($connection, $communityUserInsertQuery);
            $url = '/buziaBook/src/user/wall.php?group=' . $communityName;
            header('Location: ' . $url);
        }
        // echo $communityName . ' ' . $communityDescription . "";
        // echo json_encode($result);
    }

}


?>