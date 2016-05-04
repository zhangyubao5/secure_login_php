<?php
    $db = new PDO("sqlite:auth.sqlite") or die("Failed to open DB");
    if (!$db) die ($error);
?>