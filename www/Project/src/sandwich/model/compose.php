<?php
namespace sandwich\model;
class Compose extends \Illuminate\Database\Eloquent\Model {

	protected $table = 'compose';
	protected $primarykey= 'id';
	
	public $timestamps=false;

	public function ingredient(){
		return $this->BelongsTo('\sandwich\model\ingredient', 'id');
	}

	public function sand(){
		return $this->BelongsTo('\sandwich\model\sandwich', 'id');
	}
}