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

class commandepriveeController extends AbstractController{

  function commandeParDateLivraison($req, $resp, $args){
          $commandes = Commande::select('id','nom','date_livraison')->orderBy('date_livraison', 'DESC')->get();

          $content = json_encode($commandes);
          $status = 200;
      	  $this->json_success($resp, $status, $content);
  }

  function commandeParDateCreation($req, $resp, $args){
          $commandes = Commande::select('id','nom')->orderBy('created_at', 'DESC')->get();
          $status = 200;
      		$content = json_encode($commandes);
      	  $this->json_success($resp, $status, $content);
  }

  function detailCommande($req, $resp, $args){
    try{
  		$commande = Commande::select('id','nom','etat_avancement','date_livraison','updated_at','created_at')->firstorfail();
  		$sandwich = Sandwich::select('nom','prix')->get();
  		$status = 200;
  		$content = json_encode([
        "Commande"=>$commande->nom,
        "Etat d'avancement"=>$commande->etat_avancement,
        "Date de livraison"=>$commande->date_livraison,
        "Modifiee a"=>$commande->updated_at,
        "Creee a"=>$commande->created_at,
      ]);
  	$this->json_success($resp, $status, $content);
  	}
  	catch(\Exception $e) {
  		$status = 404;
  		$content = json_encode(["error"=> "ressource not found : ".$this->c['router']->pathfor('listc',['token'=>$args['token']])]);
  		$this->json_error($resp, $status, $content);
  	}
  }

  function filtrageEtatCommande($req, $resp, $args){
      $commandes = Commande::select('id','nom','date_livraison','etat_avancement')->where('etat_avancement','=',$args['avancement'])->get();
      $status = 200;
      $content = json_encode($commandes);
      $this->json_success($resp, $status, $content);
  }

  function filtrageDateLivraison($req, $resp, $args){
    $commandes = Commande::select('id','nom','date_livraison')->where('date_livraison','=',$args['date'])->get();
    $status = 200;
    $content = json_encode($commandes);
    $this->json_success($resp, $status, $content);
  }

  function paginationCommande($req, $resp, $args){
    $commandes = Commande::take($args['limit'])->offset($args['offset'])->get();

    $status = 200;
    $content = json_encode($commandes);
    $this->json_success($resp, $status, $content);
  }

  function changerEtatCommande($req, $resp, $args){
    try{
    	$token = $args['token'];
      $etat = $args['etat'];
      $data = $req->getParsedBody();
    	$commande = Commande::select('etat_avancement')->where('token','=',$token)->firstorfail();

      if($commande['etat_avancement'] !== $data){

        $commande->update(['etat_avancement'=>$data]);
      }

      $status = 200;
      $content = json_encode(["Success"=>"Modification de l'état de la commande"]);
      $this->json_success($resp, $status, $content);

    }catch(\Exception $e) {
    	$status = 404;
    	$content = json_encode(["error"=> "ressource not found : ".$this->c['router']->pathfor('changerEtatCommande', ['token'=>$args['token']])]);
    	$this->json_error($resp,$status,$content);
    }
  }



}
