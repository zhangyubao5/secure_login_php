<?php
     $username = $_REQUEST["username"];
     $hahah = $_REQUEST["password"];
     $role = $_REQUEST["rolename"];
     //console.log("\n"+$role+"\n");
     include "checkavailability.php";
     if(!checkavail($username)) {
          echo "<div style=\"color:red;\">* User name is not available.</div>";
          die("User name not available.");
     }
     
     $roleid = 4;
     switch ($role) {
          case 'admin':
               $roleid = 1;
               break;    
          case 'moderator':
               $roleid = 2;
               break;
          case 'author':
               $roleid = 3;
               break;
          default:
               $roleid = 4;
               break;
     }
     
     include "generateNHash.php";
     generateNHash($username, $hahah, $roleid);
     header("Location: index.php");
?>