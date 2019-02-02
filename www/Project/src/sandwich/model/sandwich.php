<?php

namespace sandwich\model;


class Sandwich extends \Illuminate\Database\Eloquent\Model{
	protected $table='sandwich';
	protected $primarykey='id';
	public $timestamps=false;
	public function sandwichCommande(){
		return $this->belongsTo('\sandwich\model\commande','id_co');
	}
	
	public function IngredSandwich(){
		return $this->belongsToMany('\sandwich\model\ingredient','compose','id_sand', 'id_ing');
	}


}