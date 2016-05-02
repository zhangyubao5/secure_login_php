<?php
     $dictionary = file_get_contents("dictionary.txt");
     $dict_array = explode("\n", $dictionary);
     echo count($dict_array).'<br>';
     $now = microtime(true);
     while (count($dict_array)>0) {
          $word = array_pop($dict_array);
          $wordHash = hash("sha256", $word);
          $h = "5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8";
          if ($wordHash==$h) {
               $finished = microtime(true);
               echo "Word: ".$word.", hash: ".$wordHash.", time:". ($finished-$now)." msec <br>";
          }
     }
     $total_finished = microtime(true);
     echo "Total time: ".($total_finished-$now)."<br>";
     
?>