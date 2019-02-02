<?php

namespace sandwich\model;


class Commande extends \Illuminate\Database\Eloquent\Model{
	protected $table='commande';
	protected $primarykey='id';

	public function sandwichCommande(){
		return $this->HasMany('\sandwich\model\sandwich','id_sandwich');
	}
	
	public function PaiementCommande(){
		return $this->belongsTo('\sandwich\model\paiement','id_paiement');
	}



}