<?php

require '../core/dbAndSession.php';

$loggedUserEmail = $_SESSION['loggedUserEmail'];

//User
$takeUserQuery = "SELECT id from user where email='$loggedUserEmail'";
$result = mysqli_query($connection, $takeUserQuery);
$resultArray = mysqli_fetch_assoc($result);
$userId = $resultArray['id'];

//Community id
$communityId = $_GET['communityId'];

echo "CommunityId: " . $communityId . "<br>";
echo "UserId: " . $userId . "<br>";

$ifExistsQuery = "SELECT * FROM user_community WHERE community_id = '$communityId' AND user_id = '$userId'";
$result = mysqli_query($connection, $ifExistsQuery);
$result = mysqli_fetch_array($result);

if ($result) {
    $_SESSION['groupNameErr'] = 'Już należysz do tej grupy!';
    $url = '/buziaBook/src/user/wall.php?';
} else {
    $joinCommunityQuery = "INSERT INTO user_community(user_id, community_id) VALUES ('$userId', '$communityId')";
    $result = mysqli_query($connection, $joinCommunityQuery);
    
    $query = "SELECT name from community where id='$communityId'";
    $result = mysqli_query($connection, $query);
    $result = mysqli_fetch_array($result);
    echo json_encode($result);

    $url = '/buziaBook/src/user/wall.php?group=' . $result['name'];
    echo $url;
}
header('Location: ' . $url);

?>