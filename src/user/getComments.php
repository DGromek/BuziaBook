<?php
session_start();
$connection = new mysqli("localhost", "root", "", "buziabook");
$postId = $_GET['postId'];
$_SESSION['postId'] = $postId;

echo $postId;

$findComments = "SELECT * from comment c
                 INNER JOIN user u ON c.user_id = u.id
                 where post_id='$postId'";
$result = mysqli_query($connection, $findComments);

$array = [];
while ($row = mysqli_fetch_array($result)) {
    array_push($array, $row);
}

$_SESSION['comments'] = $array;
mysqli_close($connection);
$url = '/buziaBook/src/user/wall.php?';
if (isset($_GET['group'])) {
    $url = $url . 'group='.$_GET['group'];
}

header('Location: ' . $url);

?>