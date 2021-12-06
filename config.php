<?php
$server = 'localhost:3307';
$username = 'root';
$password = '';
$dbname = 'iwpda';

$db = mysqli_connect($server,$username,$password,$dbname);


if($db === false)
die("Connectin Error");


?>