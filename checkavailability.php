<?php
function checkavail($username) {
     include("db_operation.php");
     $query = "select * from users where username=\"$username\";";
     $statement = $db->prepare($query);
     $statement->execute();
     $result = $statement->fetchAll(PDO::FETCH_ASSOC);
     if(count($result)>0) {
          return false;
     } else {
          return true;    
     }
}