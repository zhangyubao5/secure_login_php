<?php
     include("db_operation.php");
     $query = "select username from users order by random() limit 1;";
     $statement = $db->prepare($query);
     $statement->execute();
     $result = $statement->fetchAll(PDO::FETCH_ASSOC);
     $word = $result[0]["username"];
     
     include("salt_gen.php");
     $init_loop = 5000;
     $init_time = array();
     for($x=0;$x<$init_loop;$x++){
          $start = microtime(true);
          $randword = $word.$salt;
          $hash1 = hash("sha256",$randword);
          $end = microtime(true);
          $init_time[] = $end-$start;
     }
     $mean_init_time = array_sum($init_time)/count($init_time);
     echo "<html><head></head><body>";
     echo "<table border=\"1\" style=\"width:100%\"><tr><td>Word</td> <td>$word</td> <tr><td>salt</td><td>$salt</td></tr> <tr><td>random word</td> 
          <td>$randword </td></tr> <tr><td>hash</td> <td>$hash1 </td></tr> <tr><td>Time</td><td>".($end-$start)." sec</td></tr>";
     $iter =floor(1/$mean_init_time);
     echo "<tr><td>Iterate loops</td> <td>$iter</td></tr>";
     
     for ($x=0;$x<$iter;$x++) {
          $randword = $hash1.$salt;
          $hash1 = hash("sha256", $randword);
     }
     $finalend = microtime(true);
     echo "<tr><td>Final hash</td><td>$hash1 </td></tr> <tr><td>Total time</td> <td>".($finalend-$end)." sec</td></tr></table>";
     echo "</body></html>";
?>