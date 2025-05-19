<?php
$host = 'interchange.proxy.rlwy.net';
$user = 'root';
$password = 'LXeaeexzhJMvNcEveEhAcQNWGiuLKzme';
$database = 'railway';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
?>
