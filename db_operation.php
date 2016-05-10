<?php
<<<<<<< HEAD
    $db = new PDO("sqlite:auth.db") or die("Failed to open DB");
=======
    $db = new PDO("sqlite:auth.sqlite") or die("Failed to open DB");
>>>>>>> 7d5022500fc66f47c5008bcd5f8b733169b67994
    if (!$db) die ($error);
?>