<?php
     

     function checkHash($username=null, $word=null) {
          if ($username==null) {
               die("No username.");
          }
          include("db_operation.php");
          $query = "select hash, stretch, salt from users where username= :username;";
          $statement = $db->prepare($query);
          $statement->bindParam(":username", $username, PDO::PARAM_STR, 100);
          $statement->execute();
          $result = $statement->fetchAll(PDO::FETCH_ASSOC);
          if(count($result)!=1){
               die("DB error.");
          }
          $hash = $result[0]["hash"];
          //var_dump($hash);
          $salt = $result[0]["salt"];
          $stretch = $result[0]["stretch"];
          $hash1 = generate($stretch, $word, $salt);
          //var_dump($hash1);
          if($hash1==$hash) {
               //echo "<div>You are logged in.</div>";
               return true;
          } else {
               //echo "<div>Username or password is wrong.</div>";
               return false;
          }
     }

     function generateNHash($username=null, $word=null, $role=4) {
          if ($username==null) {
               die("No username.");
          }
          if($word==null){
               die("No password.");
          }
          
          include("db_operation.php");
          include("salt_gen.php");
          // $init_loop = 100;
          // $init_time = array();
          // for($x=0;$x<$init_loop;$x++){
          //      $start = microtime(true);
          //      $randword = $word.$salt;
          //      $hash1 = hash("sha256",$randword);
          //      $end = microtime(true);
          //      $init_time[] = $end-$start;
          // }
          // $mean_init_time = array_sum($init_time)/count($init_time);
     
          // $iter =floor(0.1/$mean_init_time);
          
          $iter = rand(1000, 10000);
          $hash = generate($iter, $word, $salt);
          $sth = $db->prepare("insert into users(username, salt,stretch,hash,roleid) values( :username, :salt, :iter, :hash, :roleid);");
          if (is_null($sth)) {
               die("PDO prepare failed.");
          }
          $sth->bindParam(":username", $username,PDO::PARAM_STR, 100);
          $sth->bindParam(":salt", $salt,PDO::PARAM_STR, 100);
          $sth->bindParam(":iter", $iter,PDO::PARAM_STR, 100);
          $sth->bindParam(":hash", $hash,PDO::PARAM_STR, 100);
          $sth->bindParam(":roleid", $role, PDO::PARAM_STR, 100);
          $sth->execute();
          echo "<div>Sign up successfully.</div>";
          //header("Location: login.html");
     }
     //A123456
     function generateNHashChangePass($username=null, $word=null) {
          if ($username==null) {
               die("No username.");
          }
          if($word==null){
               die("No password.");
          }
          
          include("db_operation.php");
          include("salt_gen.php");
          // $init_loop = 100;
          // $init_time = array();
          // for($x=0;$x<$init_loop;$x++){
          //      $start = microtime(true);
          //      $randword = $word.$salt;
          //      $hash1 = hash("sha256",$randword);
          //      $end = microtime(true);
          //      $init_time[] = $end-$start;
          // }
          // $mean_init_time = array_sum($init_time)/count($init_time);
     
          // $iter =floor(0.1/$mean_init_time);
          
          $iter = rand(1000, 10000);
          $hash = generate($iter, $word, $salt);
          $sth = $db->prepare("update users set stretch=:iter, hash=:hash, salt=:salt where username=:username;");
          $sth->bindParam(":username", $username,PDO::PARAM_STR, 100);
          $sth->bindParam(":salt", $salt,PDO::PARAM_STR, 100);
          $sth->bindParam(":iter", $iter,PDO::PARAM_STR, 100);
          $sth->bindParam(":hash", $hash,PDO::PARAM_STR, 100);
          $sth->execute();
          echo "<div>Change password successfully.</div>";
     }
     
     function generate($num, $word, $salt) {
          $hash1 = "0";
          for ($x=0;$x<$num;$x++) {
               $randword = $hash1.$word.$salt;
               $hash1 = hash("sha256", $randword);
          }
          return $hash1;
     }
?>