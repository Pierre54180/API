<?php
require '../../vendor/autoload.php';
use \Psr\Http\Message\ServerRequestInterface as Request; 
use \Psr\Http\Message\ResponseInterface as Response;
use \sandwich\utils\ConnexionFactory as ConnexionFactory;
use \sandwich\model\ingredient;
use \sandwich\model\categorie;
use \sandwich\model\commande;
use \RandomLib\Factory;
use \controllers\categorieController;
use \controllers\ingredientController;
use \controllers\commandeController;
use \controllers\test;

ConnexionFactory::bootEloquent('../../conf/config.ini');

/*---------------------------------------------------------------------------------*/

$conf= ['settings'=>['displayErrorDetails'=>true]];
$app = new \Slim\App(new \Slim\Container($conf));

/*---------------------------------------------------------------------------------*/

/*---------------------------------------------------------------------------------*/

$app->get('/testCo/{pseudo}/{mdp}',
	function (Request $req, Response $resp, $args) {
		return (new \controllers\adminController($this))
		->testCon($req,$resp, $args);
	} 
)->setName('ad');

/*---------------------------------------------------------------------------------*/


$app->get('/listingredient/',
	function (Request $req, Response $resp, $args) {
		return (new \controllers\categorieController($this))
		->listingredient($req,$resp, $args);
	} 
)->setName('listing');

$app->get('/deleteingre/{id}',
	function (Request $req, Response $resp, $args) {
		return (new \controllers\ingredientController($this))
		->deleteingr($req,$resp, $args);
	}
	)->setname('dfdf'); 


$app->post('/ajouting/',
function (Request $req, Response $resp ,$args)
	{
		return (new \controllers\ingredientController($this))
		->ajouting($req,$resp,$args);
	}
	)->setName('ajouting');


$app->put('/updatesand/',
function (Request $req, Response $resp ,$args)
	{
		return (new \controllers\ingredientController($this))
		->updatesandw($req,$resp,$args);
	}
	)->setName('updatesandwich');

$app->get('/getTDB',
	function (Request $req, Response $resp, $args) {
		return (new \controllers\commandeController($this))
		->getTDB($req,$resp, $args);
	}
	)->setname('dfdf'); 

$app->put('/updatesand/',
function (Request $req, Response $resp ,$args)
	{
		return (new \controllers\ingredientController($this))
		->updatesandw($req,$resp,$args);
	}
	)->setName('updatesandwich');
$app->run();