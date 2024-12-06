<?php
session_start();
$_SESSION = [];
session_destroy();
session_write_close();
header("Location: index.php");
exit;
