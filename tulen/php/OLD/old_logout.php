<?php
require 'auth.php';
logoutUser();
header("Location: login.html");
exit;
?>
