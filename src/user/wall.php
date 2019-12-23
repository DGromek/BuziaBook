<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../style.css">

    <title>BuziaBook</title>
</head>

<body>
    <?php
    require '../core/dbAndSession.php';
    require '../core/navbar.php';
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

                    while ($row = mysqli_fetch_array($result)) :
                        echo '<a href="wall.php?group=' . $row['name'] . '">' . $row['name'] . '</a><br>';
                    endwhile;
                    ?>
                </ul>
                <button data-toggle="modal" data-target="#addGroupModal" class="btn btn-success btn-sm">Utwórz nową grupę</button>
                <button data-toggle="modal" data-target="#browseGroupModal" class="btn btn-success btn-sm">Przeglądaj grupy</button>
            </div>
            <div class="col-6">
                <?php
                if (isset($_SESSION['successInfo'])) :
                ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['successInfo'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                $_SESSION['successInfo'] = null;
                endif;
                if (isset($_SESSION['groupNameErr'])) :
                ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['groupNameErr'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php
                $_SESSION['groupNameErr'] = null;
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
                        <?php
                        $url = 'addPost.php?';
                        if (isset($_GET['group'])) {
                            $url = $url . 'group=' . $_GET['group'];
                        }
                        echo '<form method="post" action="' . $url . '">';
                        ?>
                        <div class="form-group">
                            <textarea class="form-control" name="postContent" rows="5"></textarea>
                            <small class="error"><?php
                            if (isset($_SESSION['postContentErr'])) {
                                echo $_SESSION['postContentErr']; 
                                $_SESSION['postContentErr'] = null;
                            }
                             ?></small>
                        </div>
                        <button class="btn btn-info btn-block">Dodaj post!</button>
                        </form>
                    </div>
                </div>

                <?php
                while ($row = mysqli_fetch_array($result)) :
                ?>
                    <div class="card mt-4 border border-info">
                        <div class="card-header">
                            <?php
                            echo $row['first_name'] . ' ' . $row['last_name'];
                            if (isset($row['name'])) :
                                echo ' <i class="fa fa-long-arrow-right " aria-hidden="true"></i> ' . $row['name'];
                            endif;
                            ?>
                        </div>
                        <div class="card-body">
                            <p><?php echo $row['content'] ?></p>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <span><a class="fa fa-thumbs-o-up" href="#"></a> <?php echo $row['likes_count'] ?> </span>
                                <?php
                                $flag = false;
                                $commentUrl = 'addComment.php?';
                                $getCommentUrl = 'getComments.php?';

                                if (isset($_GET['group'])) {
                                    $commentUrl = $commentUrl . 'group=' . $_GET['group'] . "&";
                                    $getCommentUrl = $getCommentUrl . 'group=' . $_GET['group'] . "&";
                                }
                                $commentUrl = $commentUrl . "postId=" . $row[0];
                                $getCommentUrl = $getCommentUrl . "postId=" . $row[0];

                                echo '<a href="' . $getCommentUrl . '">Zobacz komentarze</a></div>';
                                if (isset($_SESSION['comments'])) :
                                    foreach ($_SESSION['comments'] as $commentRow) :
                                        if ($commentRow['post_id'] === $row[0]) :
                                ?>
                                            <div class="p-2 m-3 border border-info bg-white rounded">
                                                <?php
                                                $flag = true;
                                                echo $commentRow['first_name'] . " " . $commentRow['last_name'] . '<br>';
                                                echo $commentRow['content']
                                                ?>
                                            </div>
                                        <?php
                                        endif;
                                    endforeach;
                                    if (isset($_SESSION['postId'])) :
                                        if ($_SESSION['postId'] === $row[0]) :
                                            echo '<form method="post" action="' . $commentUrl . '">';
                                        ?>
                                            <div class="form-group mx-2 px-2">
                                                <label>Dodaj komentarz</label>
                                                <?php echo '<input type="hidden" id="custId" name="custId" value="">' ?>
                                                <textarea class="form-control " name="commentContent" rows="2"></textarea>
                                                <small class="error"><?php 
                                                if (isset($_SESSION['commentContentErr'])) {
                                                    echo $_SESSION['commentContentErr'];
                                                    $_SESSION['commentContentErr'] = null;
                                                }
                                                ?></small>
                                                <button class="mt-3 btn btn-info btn-block">Dodaj komentarz!</button>
                                            </div>
                                            </form>
                                <?php
                                        endif;
                                    endif;
                                endif;
                                ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    </div>
            </div>
        </div>
    </div>


    <!-- Add group modal -->
    <div class="modal fade" id="addGroupModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nowa grupa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="addCommunity.php">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nazwa grupy:</label>
                            <input type="text" class="form-control" name="groupName">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Opis grupy:</label>
                            <textarea class="form-control" name="groupDescription"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-info">Utwórz grupę</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="browseGroupModal" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-white">
                    <h5 class="modal-title" id="exampleModalLabel">Dostępne grupy: </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php

                    $getCommunitiesQuery = "SELECT * FROM community";
                    $communities = mysqli_query($connection, $getCommunitiesQuery);

                    echo '<table class="table">';
                    echo '<thead><tr><th>Nazwa</th><th>Opis</th><th>Akcja</th></tr></thead>';
                    while ($community = mysqli_fetch_array($communities)) {
                        echo '<tr>';
                        $redirect = "window.location.href = 'joinCommunity.php?communityId=" . $community['id'] ."'";
                        echo '<td>' . $community['name'] . '</td><td>' . $community['description'] . '</td><td><button onclick="'. $redirect . '" class="btn btn-success btn-sm">Dołącz</button></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>

    </script>
</body>

</html>