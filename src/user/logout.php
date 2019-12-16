<?php

session_start();
session_destroy();
header('Location: /buziaBook/src/home.php');

?>