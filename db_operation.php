<?php
    $db = new PDO("sqlite:auth.db") or die("Failed to open DB");
    if (!$db) die ($error);
?>