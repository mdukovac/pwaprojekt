<?php
$dbc = mysqli_connect('localhost', 'root', '', 'lobs') or die('DB greška: ' . mysqli_connect_error());
mysqli_set_charset($dbc, 'utf8');
define('IMG', 'img/');
