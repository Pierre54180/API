<?php

namespace controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


class Test extends AbstractController{

	public function getHello(Request $req, Response $resp, $args){
		$name = $args['name'];
		$resp->getBody()->write("Hello $name");
		return $resp;
	}
}