<?php 
$title = 'Student Q&A Portal';
ob_start();
include 'template/home.html.php';
$output = ob_get_clean();
include 'login.html';
