<?php

namespace controllers;

use \Psr\Http\Message\ServiceResponseInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


class AbstractController{
	protected $c = null;

	public function __construct ( \Slim\Container $c=null){
		$this->c = $c;
	}

	public function json_success( Response $resp, $code, $content){
		$resp = $resp->withStatus($code)->withHeader('Content-Type', 'application/json:charset=utf8');

		$resp->getBody()->write($content);

		return $resp;
	}

	public function json_error(Response $resp, $code, $msg){
		$resp = $resp->withStatus($code)->withHeader('Content-Type', 'application/json:charset=utf8');

		$resp->getBody()->write($msg);

		return $resp;
	}
}