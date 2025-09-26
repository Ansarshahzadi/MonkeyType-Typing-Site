<?php
session_start();

// clear all session data
$_SESSION = [];
session_unset();
session_destroy();

// clear cache headers
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// redirect to login
header("Location: login.php");
exit;
?>

<?php
session_start();

// destroy session data
$_SESSION = [];
session_unset();
session_destroy();

// prevent back button issue
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

header("Location: login.php");
exit;
?>
