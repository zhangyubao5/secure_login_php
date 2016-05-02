<?php
     include("github_para.php");
     include("../Util/urlutil.php");
     session_start();
     // When Github redirects the user back here, there will be a "code" and "state" parameter in the query string
     if(get('code')) {
       // Verify the state matches our stored state
       if(!get('state') || $_SESSION['state'] != get('state')) {
         header('Location: ' . $_SERVER['PHP_SELF']);
         die();
       }
       // Exchange the auth code for a token
       $token = apiRequest($tokenURL, array(
         'client_id' => OAUTH2_CLIENT_ID,
         'client_secret' => OAUTH2_CLIENT_SECRET,
         'redirect_uri' => 'https://webapp-security-1-zhangyubao5.c9users.io/login/github_welcome.php',
         'state' => $_SESSION['state'],
         'code' => get('code')
       ));
       $_SESSION['access_token'] = $token->access_token;
       header('Location: ' . $_SERVER['PHP_SELF']);
     }
     if(session('access_token')) {
       //echo session("access_token");
       //$user = apiRequest($apiURLBase . 'user');
       $user = directUrlApiRequest($apiURLBase . 'user?access_token='. session('access_token'));
       echo '<h3>Welcome</h3>';
       echo '<h4>'. $user->login .'</h4>';
       //var_dump($user);
       echo '<pre>';
       //print_r($user);
       echo '</pre>';
     } else {
       echo '<h3>Not logged in</h3>';
       echo '<p><a href="?action=login">Log In</a></p>';
     }


?>