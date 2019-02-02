<?php

namespace sandwich\model;


class Ingredient extends \Illuminate\Database\Eloquent\Model{
	protected $table='ingredient';
	protected $primarykey='id';

	public $timestamps=false;
	public function CategIngred(){
		return $this->belongsTo('\sandwich\model\categorie','cat_id');
	}
	
	public static function ingred($id){
		return Ingredient::where('id',$id)->first();
	}

	public static function listIngredCat($id){
		return Ingredient::where('cat_id',$id)->get();
	}

	public function SandwichIngred(){
		return $this->belongsToMany('\sandwich\model\sandwich','compose','id_ing', 'id_sand');
	}



}