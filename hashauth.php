<?php
   //header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
   // this must match the express-session `secret` in your Express app
   define('EXPRESS_SECRET', 'node.js rules');
   // this id mutator function helps ensure we look up
   // the session using the right id
   define('REDIS_SESSION_ID_MUTATOR', 'express_mutator');
   function express_mutator($id) {
        //echo("before express id: $id <br/>");
     if (substr($id, 0, 2) === "s:")
       $id = substr($id, 2);
     $dot_pos = strpos($id, ".");
     if ($dot_pos !== false) {
       $hmac_in = substr($id, $dot_pos + 1);
       $id = substr($id, 0, $dot_pos);
     }
     //echo("after express id: $id <br/>");
     return $id;
   }
   
   // check for existing express-session cookie ...
   $sess_name = session_name();
   //echo("Session name: $sess_name <br/>");
   //echo("Cookie name: $_COOKIE[$sess_name] <br/>");
   //unset($_COOKIE[$sess_name]);
   //var_dump($_COOKIE[$sess_name]);
   if (strlen($_COOKIE[$sess_name])!=32) {
     unset($_COOKIE[$sess_name]);
     //setcookie("sess_name", null, -1 , '/');
   }
   if (isset($_COOKIE[$sess_name])) {
     // here we have to manipulate the cookie data in order for
     // the lookup in redis to work correctly
     // since express-session forces signed cookies now, we have
     // to deal with that here ...
     if (substr($_COOKIE[$sess_name], 0, 2) === "s:")
       $_COOKIE[$sess_name] = substr($_COOKIE[$sess_name], 2);
     $dot_pos = strpos($_COOKIE[$sess_name], ".");
     if ($dot_pos !== false) {
       $hmac_in = substr($_COOKIE[$sess_name], $dot_pos + 1);
       $_COOKIE[$sess_name] = substr($_COOKIE[$sess_name], 0, $dot_pos);
       // https://github.com/tj/node-cookie-signature/blob/0aa4ec2fffa29753efe7661ef9fe7f8e5f0f4843/index.js#L20-L23
       $hmac_calc = str_replace("=", "", base64_encode(hash_hmac('sha256', $_COOKIE[$sess_name], EXPRESS_SECRET, true)));
       if ($hmac_calc !== $hmac_in) {
         // the cookie data has been tampered with, you can decide
         // how you want to handle this. for this example we will
         // just ignore the cookie and generate a new session ...
         unset($_COOKIE[$sess_name]);
       }
     }
   } else {
     // let PHP generate us a new id
     //session_regenerate_id();
     //$sess_id = session_id();
     $sessHandlerInst=new SessionHandler();
     $sess_id=$sessHandlerInst->create_sid();
     //$sess_id = SessionHandler::create_sid();
     var_dump($sess_id);
     //echo("Generate session id $sess_id <br/>");
     $hmac = str_replace("=", "", base64_encode(hash_hmac('sha256', $sess_id, EXPRESS_SECRET, true)));
     var_dump($hmac);
     // format it according to the express-session signed cookie format
     session_id("s:$sess_id.$hmac");
     var_dump(session_id());
   }
   
   require('redis-session-php/redis-session.php');
   RedisSession::start("tcp://128.4.27.23:6379");
   $username = $_REQUEST["username"];
   $hahah = $_REQUEST["password"];
   echo("Username $username, password $hahah <br/>");
   include "generateNHash.php";
   if (checkHash($username, $hahah)) {
      $_SESSION["logged_in"] = true;
      $_SESSION["username"] = $username;
      //Get user role
      include 'db_operation.php';
      $query = "select roleid from users where username= :username;";
       $statement = $db->prepare($query);
       $statement->bindParam(":username", $username, PDO::PARAM_STR, 100);
       $statement->execute();
       $result = $statement->fetchAll(PDO::FETCH_ASSOC);
       $roleid = $result[0]["roleid"];
       $statement->closeCursor();
       $_SESSION["roleid"] = $roleid;
       if (!isset($_SESSION["cookie"])){
          $_SESSION["cookie"] = array();
        }
     //   $sid = $_COOKIE['PHPSESSID'];
     //  //echo "<h3>Welcome, </h3><h4>".$_COOKIE['PHPSESSID']."</h4>";
      
     //  //extract data from the post
     //  //set POST variables
      
     //  $url = "https://mongo-nodejs-zhangyubao5.c9users.io:8080/ng_index.html";
     //  //open connection
     //  $ch = curl_init();
      
     //  //set the url, number of POST vars, POST data
     //  curl_setopt($ch,CURLOPT_URL, $url);
     //  curl_setopt($ch,CURLOPT_POST, 1);
     //  curl_setopt($ch,CURLOPT_FOLLOWLOCATION, true);
     //  //execute post
     //  $result = curl_exec($ch);
      
     //  //close connection
     //  curl_close($ch);
      
      //setcookie("sid", $sid, time() + 60*60*24*30, '/');
      //header("Location: https://mongo-nodejs-zhangyubao5.c9users.io:8080/ng_index.html");
      header("Location: http://128.4.27.23:3000/ng_index.html");
      //define("COOKIE_FILE", "cookie.txt");
   } else {
      $_SESSION["logged_in"] = false;
      header("Location: index.php"); /* Redirect browser */
      exit();
   }
  
?>