<?php
$host = '35.225.xxx.xxx'; // ← l’IP publique donnée par Railway
$user = 'root';
$password = 'LXeaeexzhJMvNcEveEhAcQNWGiuLKzme';
$database = 'railway';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
?>
