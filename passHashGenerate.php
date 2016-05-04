<?php 
     include "db_operation.php";
     $dictionary = file_get_contents("dictionary.txt");
     $dict_array = explode("\n", $dictionary);
     echo count($dict_array).'<br>';
     $now = microtime(true);
     while (count($dict_array)>0) {
          $word = array_pop($dict_array);
          $wordHash = hash("sha256", $word);
          $db -> exec("insert into users(username, pwd) values (\"$word\",\"$wordHash\");");
     }
     $total_finished = microtime(true);
     echo "Total time: ".($total_finished-$now)."<br>";
?>