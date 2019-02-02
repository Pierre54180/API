<?php 
namespace sandwich\utils;

use \Illuminate\Database\Capsule\Manager;

 class ConnexionFactory {
	public static function bootEloquent($file){
		
		$config = parse_ini_file($file);
		$db= new Manager();

		$db->addConnection($config);
		$db->setAsGlobal();
		$db->bootEloquent();
	}
 }