<?php
session_start();
session_destroy();
header("Location: p_index.php");
exit();
?>