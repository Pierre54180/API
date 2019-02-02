<?php

namespace sandwich\model;


class Paiement extends \Illuminate\Database\Eloquent\Model{
	protected $table='paiement';
	protected $primarykey='id';

	public function CommandePaiement(){
		return $this->belongsTo('\sandwich\model\commande','id_commande');
	}



}