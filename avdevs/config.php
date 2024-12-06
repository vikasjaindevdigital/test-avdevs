<?php
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$domain = $_SERVER['HTTP_HOST'];
$folder = 'avdevs';
$baseUrl = $protocol . '://' . $domain . '/' . $folder;
?>
