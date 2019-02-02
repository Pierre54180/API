<?php

namespace controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \sandwich\model\ingredient;
use \sandwich\model\categorie;
use \sandwich\model\commande;


class CategorieController extends AbstractController{

	public function getCateg(Request $req, Response $resp, $args){
		$lc = Categorie::Select('id','nom')->get();
		$resp=$resp->withHeader('Content-Type','application/json') ;
		$resp->getBody()->write(json_encode(['nb'=>$lc->Count(),'categories'=>$lc->toArray()])); 
		return $resp;
	}

	public function getCategId(Request $req, Response $resp, $args){
		$lc = Categorie::categ($args);
		
		if($lc== '' ){	
			$resp=$resp->withStatus(404);
		

			$resp->getBody()->write(json_encode(["error"=>"ressource not found :".$this['router']->pathfor('cat',['id'=>$args['id']])])); 
		}else{
			$resp=$resp->withHeader('Content-Type','application/json') ;
			$resp->getBody()->write(json_encode($lc->toArray())); 
		}
		return $resp;
	}

	public function getIngredCateg(Request $req, Response $resp, $args){
		$li = Ingredient::listIngredCat($args);
		if($li== '' ){	
			$resp=$resp->withStatus(404);
			$resp=$resp->withHeader('Content-Type','application/json') ;
			$resp->getBody()->write(json_encode(["error"=>"ressource not found :".$this['router']->pathfor('cat',['id'=>$args['id']])])); 
		}else{
			$resp=$resp->withHeader('Content-Type','application/json') ;
			$resp->getBody()->write(json_encode($li->toArray())); 
		}
		return $resp;
	}


/*
	**************************************
					API PRIVEE
	**************************************
*/



public function listingredient(Request $req, Response $resp, $args)
{

	try{
	$select=Categorie::select('id','nom','description')->get();
	$result = array();
		foreach ($select as $d)
			{
			$data = array(

			'Nom Categorie' => $d['nom'],
			"Les ingredients disponible" => $d->Ingreds
		
				);

 			array_push($result,$data);
			}
	$resp=$resp->withStatus(200);
	$resp = $resp->getBody()->write(json_encode($result));
	return $resp;

	}
	catch(\Exception $e)
	{
	$status = 404;
	$content = json_encode(["error"=>"Une erreur s'est produite.."]);
	$this->json_success($resp,$status,$content);
	}
}







}


