<?php

namespace sandwich\model;


class Categorie extends \Illuminate\Database\Eloquent\Model{
	protected $table='categorie';
	protected $primarykey='id';
		public $timestamps=false;

	public function Ingreds(){
		return $this->hasMany('\sandwich\model\ingredient','cat_id');
	}

	public static function categ($id){
		return Categorie::where('id',$id)->first();
	}
}