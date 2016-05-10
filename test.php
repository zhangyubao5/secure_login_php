<?php
// this must match the express-session `secret` in your Express app
define('EXPRESS_SECRET', 'node.js rules');

// this id mutator function helps ensure we look up
// the session using the right id
define('REDIS_SESSION_ID_MUTATOR', 'express_mutator');
function express_mutator($id) {
  if (substr($id, 0, 2) === "s:")
    $id = substr($id, 2);
  $dot_pos = strpos($id, ".");
  if ($dot_pos !== false) {
    $hmac_in = substr($id, $dot_pos + 1);
    $id = substr($id, 0, $dot_pos);
  }
  return $id;
}

// check for existing express-session cookie ...
$sess_name = session_name();
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
  session_regenerate_id();
  $sess_id = session_id();
  $hmac = str_replace("=", "", base64_encode(hash_hmac('sha256', $sess_id, EXPRESS_SECRET, true)));
  // format it according to the express-session signed cookie format
  session_id("s:$sess_id.$hmac");
}
require('redis-session-php/redis-session.php');
RedisSession::start("tcp://128.4.27.23:6379");

$_SESSION["php"] = "Hello from PHP";
if (!isset($_SESSION["cookie"]))
  $_SESSION["cookie"] = array();

unset($_COOKIE["sid"]);

echo "<html>";
echo "<body>";
echo json_encode($_COOKIE, JSON_PRETTY_PRINT);
echo json_encode($_SESSION, JSON_PRETTY_PRINT);
echo "</body>";
echo "</html>";

?>
