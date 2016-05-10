<?php
     require "../vendor/autoload.php";
     use Abraham\TwitterOAuth\TwitterOAuth;
     
     session_start();
     
     putenv("CONSUMER_KEY=906W0sj9fEAuaOdv8EGg");
     putenv("CONSUMER_SECRET=6k6BHBjLVUgOk0frsO7QfCNMCwC6Dophzg3gxywgNs");
     putenv("ACCESS_TOKEN=904926499-pPYYSflm5KG6p8V1QN0jLAEjlS95cZrEWuTFSxcI");
     putenv("ACCESS_TOKEN_SECRET=cWfX67p9Cjsq35csE0NfIgWYc55RippJZqKCnkB8VE");
     
     putenv("OAUTH_CALLBACK=https://webapp-security-1-zhangyubao5.c9users.io/login/twitter_welcome.php");
     define('CONSUMER_KEY', getenv('CONSUMER_KEY'));
     define('CONSUMER_SECRET', getenv('CONSUMER_SECRET'));
     define('OAUTH_CALLBACK', getenv('OAUTH_CALLBACK'));
     
     $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
     
     $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
     $_SESSION['oauth_token'] = $request_token['oauth_token'];
     $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
     $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
     //echo "$url"
     //$content = $connection->get("statuses/home_timeline");
     //var_dump($content);
     header("Location: $url");
?>