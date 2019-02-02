<?php

require_once 'vendor/autoload.php';

use \sandwich\utils\ConnexionFactory as ConnexionFactory;
use \sandwich\model\ingredient;
use \sandwich\model\categorie;

ConnexionFactory::bootEloquent('conf/config.ini');

if(isset($id == $_GET['id'])){
	$categ=Categorie::categ($id);
	header('Content-Type:application/json');
	echo json_encode($categ);
}else{
	echo "ERREUR !!!! ";
}