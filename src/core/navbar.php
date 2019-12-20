<nav class="navbar navbar-light bg-light">
  <a class="navbar-brand font-weight-light brand" href="">BuziaBook</a>
  <?php
    if (isset($_SESSION["loggedUser"])) { 
        echo 
        '<form class="form-inline">'.
            '<span class="d-block pr-2">Witaj, ' . $_SESSION['loggedUser'] . '!</span>'.
            '<a class="btn btn-outline-success p-2 mr-2" href="/buziaBook/src/user/logout.php">Wyloguj się</a>'.
        '</form>';
    } else {
        echo 
        '<form class="form-inline">'.
            '<a class="btn btn-outline-success p-2 mr-2" href="/buziaBook/src/guest/registerView.php">Zarejestruj się</a>'.
            '<a class="btn btn-outline-secondary p-2" href="/buziaBook/src/guest/loginView.php">Zaloguj się</a>'.
        '</form>';
    }
    ?>
</nav>