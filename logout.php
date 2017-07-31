<?php
session_start();
session_destroy();
unset($_SESSION);

echo "<script> document.location = 'login.php'; </script>";
die('Olet nyt kirjautunut ulos!');