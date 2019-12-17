<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style.css">

    <title>BuziaBook</title>
</head>
<body>
<?php
require '../core/navbar.php';
$connection = new mysqli("localhost", "root", "", "buziabook");
require 'addPost.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-3 mt-4 ml-3">

            <a href="wall.php">Twoja tablica</a>
            <h5 class="font-weight-light">Twoje Grupy:</h5>
            <ul>
                <?php
                $loggedUserEmail = $_SESSION['loggedUserEmail'];

                $query = "SELECT * 
                          FROM community c 
                          inner join user_community uc on uc.community_id = c.id
                          inner join user u on uc.user_id = u.id
                          WHERE u.email = '$loggedUserEmail'";

                $result = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_array($result)):
                    echo '<a href="wall.php?group=' . $row['name'] . '">' . $row['name'] . '</a><br>';
                endwhile;
                ?>
            </ul>
        </div>
        <div class="col-6">
            <?php
            if ($postAddedInfo !== ""):
                ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $postAddedInfo ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
            endif;
            if (isset($_GET['group'])) {
            $communityName = $_GET['group'];
            echo "<h2 class='mt-3'>" . $communityName . "</h2>";
            $query = "SELECT * FROM post p
            INNER JOIN community c on p.community_id = c.id
            INNER JOIN user u on u.id = p.user_id
            WHERE c.name = '$communityName'
            ORDER BY p.id desc";
            } else {
            echo "<h2 class='mt-3'>Twoja tablica</h2>";
            $query = 'SELECT * FROM post p
            LEFT JOIN community c on p.community_id = c.id
            INNER JOIN user u on u.id = p.user_id
            ORDER BY p.id desc';
            }
            $result = mysqli_query($connection, $query);
            ?>

            <div class="card mt-4 border border-info">
                <div class="card-body">
                    <h3>Co słychać?</h3>
                    <form method="post">
                        <div class="form-group">
                            <textarea class="form-control" name="postContent" rows="5"></textarea>
                            <small class="error"><?php echo $postContentErr ?></small>
                        </div>
                        <button class="btn btn-info btn-block">Dodaj post!</button>
                    </form>
                </div>
            </div>

            <?php
            while ($row = mysqli_fetch_array($result)):
                
                // foreach($row as $key => $value) {
                //     echo $key . " - " . $value . "<br>"; 
                // }

                ?>
                <div class="card mt-4 border border-info">
                    <div class="card-header">
                        <?php
                        echo $row['first_name'] . ' ' . $row['last_name'];
                        if (isset($row['name'])):
                            echo ' <i class="fa fa-long-arrow-right " aria-hidden="true"></i> ' . $row['name'];
                        endif;
                        ?>
                    </div>
                    <div class="card-body">
                        <p><?php echo $row['content'] ?></p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <span><a class="fa fa-thumbs-o-up" href="#"></a> <?php echo $row['likes_count'] ?> </span>
                        <?php 
                        echo '<a href="getComments.php?id='. $row[0] .'">7 komentarzy</a>' 
                        
                    
                        while ($row = mysqli_fetch_array($_SESSION['comments']))

                        ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    </div>

</div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script> 

</script>
</body>
</html>