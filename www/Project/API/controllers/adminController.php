<?php

namespace controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \sandwich\model\admin as Admin;

class adminController extends AbstractController{
	
	function testCon(Request $req, Response $resp, $args){

		try{

			$li = Admin::testCo($args["pseudo"],$args["mdp"]);

			$resp=$resp->withStatus(200);
			$resp = $resp->getBody()->write(json_encode($li));

			return $resp;

		}
			catch(\Exception $e)
		{
			$status = 404;
			$content = json_encode(["error"=>"erreur!"]);
			$this->json_success($resp,$status,$content);
		}
	}
}


