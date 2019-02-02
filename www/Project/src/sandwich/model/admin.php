<?php

namespace sandwich\model;


class Admin extends \Illuminate\Database\Eloquent\Model{
	protected $table='admin';
	protected $primarykey='id';

	public static function testCo($pseudo,$mdp){
		return Admin::where('pseudo',$pseudo)->where('mdp', $mdp)->firstorfail();
	}
}