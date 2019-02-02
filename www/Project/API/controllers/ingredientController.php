<?php

namespace controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \sandwich\model\ingredient;
use \sandwich\model\categorie;
use \sandwich\model\commande;
use \sandwich\model\valeur;

class IngredientController extends AbstractController{

	public function getIngred(Request $req, Response $resp, $args){
		$li = Ingredient::ingred($args);
		
		if($li== '' ){
			$resp=$resp->withStatus(404);
			$resp=$resp->withHeader('Content-Type','application/json') ;
			$resp->getBody()->write(json_encode(["error"=>"ressource not found :".$this['router']->pathfor('ing',['id'=>$args['id']])])); 
		}else{

			$resp=$resp->withHeader('Content-Type','application/json') ;
			$resp->getBody()->write(json_encode(["ingredient"=>
													["id"=>$li['id'],
													"nom"=>$li['nom_ing'],
													"description"=>$li['description'],
													"fournisseur"=>$li['fournisseur'],
													"image"=>$li['image'],
													"Categorie"=>["id cat"=>$li['cat_id'], "nom"=>$li->CategIngred->nom,"description"=>$li->CategIngred->description]]])); 
		}
		return $resp;
	}


/*
	**************************************
					API PRIVEE
	**************************************
*/




	public function deleteingr(Request $req, Response $resp, $args)
	{
		try {

			$Ingredient = Ingredient::where('id','=',$args['id'])->Firstorfail();
			$Ingredient = Ingredient::where('id','=',$args['id'])->delete();
			$status = 200;
			$content = json_encode (["Success"=>"L'ingredient a bien été delete"]);
			$this->json_success($resp, $status, $content);

			}

		catch(\Exception $e) 
		{
			$status = 404;
			$content = json_encode(["error"=> "La ressource que vous voulez supprimer n'existe pas"]);
			$this->json_error($resp,$status,$content);
		}
		return $resp;
	}


		public function ajouting(Request $req, Response $resp, $args)
		{
			try {
			$ingredient = new Ingredient();
			$data = $req->getParsedBody();
			$ingredient->nom_ing = $data["nom_ing"];
			$ingredient->cat_id = $data["cat_id"];
			$ingredient->description = $data["description"];
			$ingredient->fournisseur = $data["fournisseur"];
			$ingredient->save();
			$status = 200;
			$content = json_encode (["Success"=>"L'ingredient a bien été ajouté"]);
			$this->json_success($resp, $status, $content);

			}

				catch(\Exception $e) 
		{
			$status = 404;
			$content = json_encode(["error"=> "La ressource que vous voulez supprimer n'existe pas"]);
			$this->json_error($resp,$status,$content);
		}
		return $resp;
		}

		public function	updatesandw(Request $req, Response $resp, $args)
		{	
			try
			{	
			$data = $req->getParsedBody();
			$S = Valeur::where('taille','=',$data['taille'])->firstorfail();
			$status = 200;
			$content = json_encode (["Success"=>"L'ingredient a bien été modifié"]);
			
			$Taille = Valeur::where('taille','=',$data['taille'])->update(['taille'=>$data['taille'],
																			'prix'=>$data['prix']]);
			$status = 200;
			$content = json_encode (["Success"=>"L'ingredient a bien été modifié"]);
			$this->json_success($resp, $status, $content);
			}

		catch(\Exception $e)  {

			$status = 404;
			$content = json_encode(["error"=> "La ressource que vous voulez modifier n'existe pas"]);
			$this->json_error($resp,$status,$content);
		}

		}


}

