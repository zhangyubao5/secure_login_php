<?php
   $username = $_REQUEST["username"];
   $hahah = $_REQUEST["password"];
   $hahahah = $_REQUEST["newpassword"];
   include "generateNHash.php";
   include "db_operation.php";
   if (checkHash($username, $hahah)) {
      generateNHashChangePass($username, $hahahah);
   } else {
      header("Location: changepass.html"); /* Redirect browser */
      exit();
   }
?>