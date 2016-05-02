<?php
     include("github_para.php");
     include("../Util/urlutil.php");
     session_start();
     
       // Generate a random hash and store in the session for security
       $_SESSION['state'] = hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);
       unset($_SESSION['access_token']);
       $params = array(
         'client_id' => OAUTH2_CLIENT_ID,
         'redirect_uri' => 'https://webapp-security-1-zhangyubao5.c9users.io/login/github_welcome.php',
         'scope' => 'user',
         'state' => $_SESSION['state']
       );
       // Redirect the user to Github's authorization page
       echo "Get token";
       header('Location: ' . $authorizeURL . '?' . http_build_query($params));
       die();
     
?>