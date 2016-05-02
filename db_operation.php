<?php
    $db = new PDO("sqlite:../rbac/rbac.db") or die("Failed to open DB");
    if (!$db) die ($error);
    
?>