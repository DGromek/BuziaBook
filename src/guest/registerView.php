<!doctype html>
<html lang="pl">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include 'registerServer.php';?>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>Zarejestruj się</title>
  </head>
  <body class="bg-light">
    
      <div class="container-fluid d-flex justify-content-center">
          <div class="col-lg-4 col-md-6 col-sm-9 col-12 mt-5">
            <div class="card rounded border-secondary shadow">
                <div class="card-header text-center border-secondary">
                    <h4>Zarejestruj się</h4>
                </div>
                <div class="card-content p-4">
                    <form method="post">
                        <div class="form-group">
                            <label>Imię</label>
                            <input type="text" class="form-control" name="firstName">
                            <small class="error"><?php echo $firstNameErr ?></small>
                        </div>
                        <div class="form-group">
                            <label>Nazwisko</label>
                            <input type="text" class="form-control" name="lastName">
                            <small class="error"><?php echo $firstNameErr ?></small>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email">
                            <small class="error"><?php echo $emailErr ?></small>
                        </div>
                        <div class="form-group">
                            <label>Hasło</label>
                            <input type="password" class="form-control" name="password">
                            <small class="error"><?php echo $passwordErr ?></small>
                        </div>
                        <div class="form-group">
                            <label>Powtórz hasło</label>
                            <input type="password" class="form-control" name="repeatedPassword">
                            <small class="error"><?php echo $repeatedPasswordErr ?></small>
                        </div>
                        <button type="submit" class="btn btn-success btn-block btn-sm">Utwórz konto</button>
                    </form>
                </div>
            </div>
        </div>
      </div>
      

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>