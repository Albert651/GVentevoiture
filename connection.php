<?php

try{

		$bdd=new PDO('mysql:host=localhost;dbname=dbventevoiture','root','');
	}
	catch(exeption $e)
	{
		die('erreur'.$e->getMessage());
	}
?>