<?php

$host = 'localhost';
$user = 'milovan';
$pass = '1234';
$db = 'register_login';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    echo "Connection error" . mysqli_connect_error();
}
