<?php
     require "../vendor/autoload.php";
     use Abraham\TwitterOAuth\TwitterOAuth;
     
     session_start();
     define('CONSUMER_KEY', getenv('CONSUMER_KEY'));
     define('CONSUMER_SECRET', getenv('CONSUMER_SECRET'));
     define('OAUTH_CALLBACK', getenv('OAUTH_CALLBACK'));
     
     $request_token = [];
     $request_token["oauth_token"] = $_SESSION["oauth_token"];
     $request_token["oauth_token_secret"] = $_SESSION["oauth_token_secret"];
     
     if(isset($_REQUEST["oauth_token"]) && ($_REQUEST["oauth_token"]!=$request_token["oauth_token"])){
          exit(0);
     }
     
     
     $twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token["oauth_token"], $request_token["oauth_token_secret"]);
     //var_dump($_REQUEST["oauth_verifier"]);
     $credential = $twitter->oauth("oauth/access_token", ['oauth_verifier' => $_REQUEST["oauth_verifier"]]);
     $screen_name = $credential["screen_name"];
     echo "<html><head></head><body><h3>Welcome</h3><h4>$screen_name</h4></body></html>";
?>