<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'php_basic_2';
$utf8 = 'utf8';

$conn = mysqli_connect($servername, $username, $password, $database);
mysqli_set_charset($conn, 'utf8');
