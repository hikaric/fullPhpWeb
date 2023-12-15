<?php
// Set the session cookie's attributes: expires - path - domain - secure - httpOnly
session_set_cookie_params(3 * 24 * 60 * 60, "/", "", true, true);
// Start session
session_start();
// Set session variables
//$_SESSION['id'] = 'test';
?>
<!DOCTYPE html>
<html>

<head>
      <?php
      include "../config/head_element/cdn.config.php";
      include "../config/head_element/meta.config.php";
      ?>
      <link rel="stylesheet" href="/css/preset_style.css">
</head>

<body>
</body>

</html>