<?php
require '../vendor/autoload.php';
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
use \controllers\adminController;

ConnexionFactory::bootEloquent('../conf/config.ini');


/*---------------------------------------------------------------------------------*/

$conf= ['settings'=>['displayErrorDetails'=>true]];
$app = new \Slim\App(new \Slim\Container($conf));

/*---------------------------------------------------------------------------------*/

$app->get('/hello/{name}',
	function (Request $req, Response $resp, $args) {
		return (new \controllers\Test($this))
		->getHello($req,$resp, $args);
	}
);

/*---------------------------------------------------------------------------------*/

$app->get('/categories/',
	function (Request $req, Response $resp, $args) {
		return (new \controllers\categorieController($this))
		->getCateg($req,$resp, $args);
	}
);

/*---------------------------------------------------------------------------------*/

$app->get('/categories/{id}',
	function (Request $req, Response $resp, $args) {
		return (new \controllers\categorieController($this))
		->getCategId($req,$resp, $args);
	}
)->setName('cat');

/*---------------------------------------------------------------------------------*/

$app->get('/ingredient/{id}',
	function (Request $req, Response $resp, $args) {
		return (new \controllers\ingredientController($this))
		->getIngred($req,$resp, $args);
	}
)->setName('ing');

/*---------------------------------------------------------------------------------*/

$app->get('/categories/{id}/ingredients',
	function (Request $req, Response $resp, $args) {
		return (new \controllers\categorieController($this))
		->getIngredCateg($req,$resp, $args);
	}
)->setName('cat');

/*---------------------------------------------------------------------------------*/

$app->post('/commandes[/]',
	function (Request $req, Response $resp ,$args) {
		return (new \controllers\commandeController($this))
		->creerCommande($req,$resp,$args);
	}
)->setName('com');




/*---------------------------------------------------------------------------------*/

$app->post('/commande/{token}/ajoutsand',
	function (Request $req, Response $resp ,$args)
	{
		return (new \controllers\commandeController($this))
		->ajoutsand($req,$resp,$args);
	}
	)->setName('add');

/*---------------------------------------------------------------------------------*/

$app->delete('/commande/{token}/delete/{id}',

function (Request $req, Response $resp ,$args)
	{
		return (new \controllers\commandeController($this))
		->suppsandwich($req,$resp,$args);
	}
	)->setName('delete');


/*---------------------------------------------------------------------------------*/

$app->get('/commande/{token}/etat',

function (Request $req, Response $resp ,$args)
	{
		return (new \controllers\commandeController($this))
		->etatcommande($req,$resp,$args);
	}
	)->setName('etatcommande');


$app->put('/commande/{token}/update',

function (Request $req, Response $resp ,$args)
	{
		return (new \controllers\commandeController($this))
		->modifiercommande($req,$resp,$args);
	}
	)->setName('modifiercommande');

$app->put('/commande/{token}/update/{id}',

function (Request $req, Response $resp ,$args)
	{
		return (new \controllers\commandeController($this))
		->updatesand($req,$resp,$args);
	}
	)->setName('updatesand');


$app->get('/commande/{token}/',
function (Request $req, Response $resp ,$args)
	{
		return (new \controllers\commandeController($this))
		->listcommande($req,$resp,$args);
	}
	)->setName('listc');


$app->get('/commande/{token}/facture',
function (Request $req, Response $resp ,$args)
	{
		return (new \controllers\commandeController($this))
		->facture($req,$resp,$args);
	}
	)->setName('facture');

$app->delete('/commande/{token}/delete',
function (Request $req, Response $resp ,$args)
	{
		return (new \controllers\commandeController($this))
		->deletecommande($req,$resp,$args);
	}
	)->setName('deleteC');




	// API PRIVEE //


	// On affiche les commandes par date de livraison
	$app->get("/commandes/date_livraison",
	function(Request $req, Response $resp, $args){
	    return (new \controllers\commandepriveeController($this))->commandeParDateLivraison($req, $resp, $args);
	}
	);

	// On affiche les commandes par date de creation
	$app->get("/commandes[/]",
	function(Request $req, Response $resp, $args){
	    return (new \controllers\commandepriveeController($this))->commandeParDateCreation($req, $resp, $args);
	}
	);

	// On affiche les détails d'une commande
	$app->get('/commandes/{id}/details',
		function (Request $req, Response $resp, $args) {
			return (new \controllers\commandepriveeController($this))
			->detailCommande($req,$resp, $args);
		}
	);

	// On affiche la commande en fonction de l'etat d'avancement
	$app->get('/commandes/etat/{avancement}',
		function (Request $req, Response $resp, $args) {
			return (new \controllers\commandepriveeController($this))
			->filtrageEtatCommande($req,$resp, $args);
		}
	);

	// On affiche la commande en fonction de la date de livraison
	$app->get('/commandes/livraison/{date}',
		function (Request $req, Response $resp, $args) {
			return (new \controllers\commandepriveeController($this))
			->filtrageDateLivraison($req,$resp, $args);
		}
	);

	// On affiche un certain nombre de commande par page
	$app->get('/commandes/pagination/{offset}/{limit}',
		function (Request $req, Response $resp, $args) {
			return (new \controllers\commandepriveeController($this))
			->paginationCommande($req,$resp, $args);
		}
	);

	// On change l'etat d'une commande

	$app->put('/commandes/{token}/changerEtatCommande',

	function (Request $req, Response $resp ,$args)
		{
			return (new \controllers\commandepriveeController($this))
			->changerEtatCommande($req,$resp,$args);
		}
		);

$app->run();
