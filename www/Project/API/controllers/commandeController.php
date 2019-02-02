<?php

namespace controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \sandwich\model\ingredient;
use \sandwich\model\categorie;
use \sandwich\model\commande;
use \sandwich\model\sandwich;
use \sandwich\model\paiement;
use \sandwich\model\compose;
use \sandwich\model\valeur;

class CommandeController extends AbstractController{

	function CreerCommande( $req, $resp, $args) {
		$data = $req->getParsedBody();
		
		if(!isset($data)){
			return $this->json_error($resp,400,'command creation none !');
		}
		if(!isset($data['nom'])){
			return $this->json_error($resp,400,'missing data (nom)');
		}
		
		if(!isset($data['date_livraison'])){
			return $this->json_error($resp,400,'missing data (date_livraison)');
		}

		$c= new Commande;

		$c->nom = filter_var($data['nom'], FILTER_SANITIZE_STRING);
		$c->date_livraison= filter_var($data['date_livraison']);
		$date = date('Y-m-d'); 
		var_dump($date);
		$c->created_at = $date;
		$tokenFactory = new \RandomLib\Factory;
		$generator = $tokenFactory->getMediumStrengthGenerator();
		$randomString = $generator->generateString(32, 'abcdefghijklmnopqrstuvwyz123456789');
		$c->token = $randomString;
		$c->save();

		if($c== '' ){
			$resp=$resp->withStatus(404);
			$resp=$resp->withHeader('Content-Type','application/json') ;
			$resp->getBody()->write(json_encode(["error"=>"ressource not found :".$this['router']->pathfor('com',['id'=>$args['id']])])); 
		}else{
			
		}
		return $resp;
	}


	function ajoutsand($req,$resp, $args)
	{
	/*
		$sand = Sandwich::join('commande','sandwich.id_co','=','commande.id_com')
		->select('sandwich.nom','commande.nom_co')->get();
		echo $sand;
	$sandwich = new Sandwich();
		*/
		try{
			$token = $args['token'];

			$etat = Commande::select('etat_avancement','id')->where('token','=',$token)->firstorFail();
			$data = $req->getParsedBody();
				if ($etat->etat_avancement == 1)
				{
	
				$sandwich = new Sandwich();
				$sandwich->nom = $data['nom'];
				$sandwich->id_commande= $etat->id;
				$prix = Valeur::select('prix','taille')->where('taille','=','10')->first();
				
				$sandwich->prix = $prix["prix"];
				$sandwich->taille = $prix["taille"];
				$sandwich->save();
				$status = 200;
				$content = json_encode (["Success"=>"l'ajout de votre sandwich a été ajouté"]);
				$this->json_success($resp, $status, $content);

				}
				else{
				$status = 404;
				$content = json_encode (["Error"=>"Votre commande est ne peut plus être modifié.."]);
				$this->json_error($resp, $status, $content);

					}
			} 
			catch(\Exception $e) 
			{
				$status = 404;
				$content = json_encode(["error"=> "ressource not found : ".$this->c['router']->pathfor('add', ['token'=>$args['token']])]);
				$this->json_error($resp,$status,$content);
			}

	}

	function suppsandwich($req,$resp, $args)
	{
		
		try{
			$token = $args['token'];
			$d = Commande::select('id')->where('token','=',$token)->firstorFail();

			$Commande = $d['id'];
	

			$id_sandwich = $args['id'];
			$sand = Sandwich::select('id','id_commande')->where('id','=',$id_sandwich)->firstorFail();
			$sand = ($sand['id_commande']);

			

			if ($Commande == $sand)
			{		$suppression_c = Compose::where('id_sandwich','=',$id_sandwich)->delete();
			 		$suppresion = Sandwich::select('id','nom','id_commande')->where('id','=',$id_sandwich)->delete();
			 		$status = 200;
			 		$content = json_encode(["Success"=>"Sandwich delete!"]);
			 		$this->json_success($resp, $status, $content);
			}
			else
			{
				$status = 404;
				$content = json_encode(["Error"=>"Une erreur est apparue dans votre requete"]);
				$this->json_error($resp, $status, $content);
			
			}
		}
			catch(\Exception $e) {
		$status = 404;
		$content = json_encode(["error"=> "ressource not found : ".$this->c['router']->pathfor('add',['token'=>$args['token'],$args['id'] ])]);			
		$this->json_error($resp, $status, $content);
		 
}
			
		}









	function etatcommande($req,$resp,$args){
	try{
	$token = $args['token'];
	$Comm  = Commande::select('id')->where('token','=',$token)->first();
	$etat = Commande::select('nom','etat_avancement','date_livraison','id_paiement')->where('token','=',$token)->first();
	$sandwich = Sandwich::select('nom','taille','prix')->get();
	$s = Sandwich::select('prix')->where('id_commande','=',$Comm['id'])->sum('prix');

	$status = 200;
	$content = json_encode([
		"Nom-Commande"=>$etat['nom'],
		"Etape_commande"=>$etat['etat_avancement'],
		"Date_livration"=>$etat['date_livraison'],
		"Liste des sandwich"=>$sandwich,
		"Prix Total"=>$s."euros",
			]);
	$this->json_success($resp,$status,$content);

	}	
	catch(\Exception $e)
	{
		$status = 404;
		$content = json_encode(["error"=> "ressource not found : ".$this->c['router']->pathfor('etatcommande', ['token'=>$args['token']])]);
		$this->json_error($resp,$status,$content);
	}
	
	}



function modifiercommande($req,$resp,$args)
{
try {
	$token = $args['token'];
	$etat = Commande::select('nom','etat_avancement','date_livraison','id_paiement')->where('token','=',$token)->firstorfail();
	$data = $req->getParsedBody();
	$nom = $data['date'];
	$mod = date('Y-m-d'); 
	$Co = Commande::where('token','=',$token)->update(['Date_livraison'=>$nom,'updated_at'=>$mod]);
	$status = 200;
	$content = json_encode(["Success"=>"Modification de la date de commande"]);
	$this->json_success($resp,$status,$content);
	}

catch(\Exception $e) {
	$status = 404;
	$content = json_encode(["error"=> "ressource not found : ".$this->c['router']->pathfor('modifiercommande', ['token'=>$args['token']])]);
	$this->json_error($resp,$status,$content);
	}
}







function updatesand($req,$resp,$args)
{
try{
	$token = $args['token'];
	$auto = Commande::select('etat_avancement')->where('token','=',$token)->firstorfail();



		if($auto['etat_avancement'] == 1)
		{
		$data = $req->getParsedBody();

			if(isset($data['nom'])) {
				$nom = Compose::select('id_sandwich')->where('id_sandwich','=',$args['id'])->first();
				$sa = Sandwich::where('id','=',$nom['id_sandwich'])->update(['nom'=>$data['nom']]);
			
			}

			if(isset($data['id_ingredient'])) {
				$id = $args['id'];
				$data = $req->getParsedBody();
				$ingre = $data['id_ingredient'];
				$Compose = Compose::where('id','=',$id)->update(['id_ingredient'=>$data['id_ingredient']]);
			}

			$status = 200;
			$content = json_encode(["Success"=>"Modification du sandwich"]);
			$this->json_success($resp,$status,$content);
		}

	}
catch(\Exception $e) {
	$status = 404;
	$content = json_encode(["error"=> "ressource not found : ".$this->c['router']->pathfor('modifiercommande', ['token'=>$args['token']])]);
	$this->json_error($resp,$status,$content);
	}
}








function listcommande ($req,$resp,$args)
{
	try{
		$commande = $args['token'];
		$comman = Commande::select('id','nom')->where('token','=',$args['token'])->firstorfail();
		$sandwich = Sandwich::select('nom','prix')->get();
		$status = 200;
		$content = json_encode(["commande"=>$comman->nom,
									"Sandwich(s)"=>$sandwich]);
	$this->json_success($resp, $status, $content);	
	}
	catch(\Exception $e) { 
		$status = 404;
		$content = json_encode(["error"=> "ressource not found : ".$this->c['router']->pathfor('listc',['token'=>$args['token']])]);
		$this->json_error($resp, $status, $content);
		}

}

	function facture ($req,$resp,$args)
	{
		try {


		$token = $args['token'];
	
		$auto = Commande::select('etat_avancement')->where('token','=',$token)->firstorFail();
		$f = Commande::select('id','nom','date_livraison','Montant_c')->where('token','=',$args['token'])->first();
		$sandwich = Sandwich::select('nom','prix')->where('id_commande','=',$f['id'])->get();
		$paiement = Paiement::select('date_paiement')->where('id_commande','=',$f['id'])->first();
		/*

			$token = $args['token'];
			$auto = Commande::select('etat_avancement')->where('token','=',$token)->firstorFail();

			
			$f = Commande::select('id','nom','date_livraison')->where('token','=',$args['token'])->first();
			$sandwich = Sandwich::select('nom','prix')->where('id_commande','=',$f['id'])->get();
			$paiement = Paiement::select('montant_total','date_paiement')->where('id_commande','=',$f['id'])->first();

*/
			$status = 200;
			$content = json_encode([
				"La Commande"=>$f,
				"Les Sandwich(s)"=>$sandwich,
				"Description de la facture"=>$paiement]);
			$this->json_success($resp, $status, $content);	
			
	/*
	$o = Commande::select('id')->where('token','=',$args['token'])->first();
	$content = json_encode($chemins->toArray());
	*/

		}
		catch(\Exception $e) {
			$status = 404;
			$content = json_encode(["error"=> "ressource not found : ".$this->c['router']->pathfor('facture',['token'=>$args['token']])]);			
			$this->json_error($resp, $status, $content);
		}	 
	}

	function getTDB($req,$resp,$args)
	{
		try {
			$dateJour =date('d-m-Y');  
			$nb = Paiement::select('*')->where('date_paiement','=',$dateJour)->get();
			$ca = Paiement::select('*')->where('date_paiement','=',$dateJour)->sum('montant_total');

			$status = 200;
			$content = json_encode([
				'Date'=>$dateJour,
				'Nombre de commandes'=>count($nb),
				"Chiffre d'affaire"=>$ca]);
			$this->json_success($resp, $status, $content);	
			
		}
		catch(\Exception $e) {
			$status = 404;
			$content = json_encode(["error"=> "erreur"]);			
			$this->json_error($resp, $status, $content);
		}	 
	}





function deletecommande ($req,$resp,$args)
{
	try {
	$token = $args['token'];
	$valeur = Commande::select('id','etat_avancement')->where('token','=',$token)->firstorfail();
		if ($valeur['etat_avancement'] == 1)
	{
			/* SQL On delete -> Cascade. */
	$Commande = Commande::where('id','=',$valeur['id'])->delete();
	$status = 200;
	$content = json_encode(["Success"=>"La commande a été supprimmée"]);
	$this->json_success($resp,$status,$content);
		
	}
	else
	{
		$status = 404;
		$content = json_encode(["error"=> "L'etat de votre commande ne permet pas d'effectuer cette action "]);
		$this->json_error($resp, $status, $content);
	}
	}

catch(\Exception $e) { 
		$status = 404;
		$content = json_encode(["error"=> "ressource not found : ".$this->c['router']->pathfor('deletecommande',['token'=>$args['token']])]);
		$this->json_error($resp, $status, $content);
		}
}


}
