<?php
session_start();
session_destroy();
header("location:../site/index.php");
?>