<?php
session_start();
session_unset();
session_destroy();

// DO NOT delete the cookie here, so it remains after logout
// setcookie("preferred_cities", "", time() - 3600, "/");

header("Location: index.php");
exit();
?>
