<?php

try{

		$bdd=new PDO('mysql:host=interchange.proxy.rlwy.net;dbname=railway','root','LXeaeexzhJMvNcEveEhAcQNWGiuLKzme');
	}
	catch(exeption $e)
	{
		die('erreur'.$e->getMessage());
	}
?>
