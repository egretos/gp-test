<?php

namespace Egretos\GamepointTestTask\Controllers;

use Symfony\Component\HttpFoundation\Request;

class SimpleRouter
{
	public static function directToController(): void
	{
		$routes = [
			'/' => [
				'controller' => TransactionController::class,
				'method' => 'index',
			],
		];
		
		$request = Request::createFromGlobals();
		
		if (array_key_exists($request->getPathInfo(), $routes)) {
			$controllerName = $routes[$request->getPathInfo()]['controller'];
			$methodName = $routes[$request->getPathInfo()]['method'];
			
			$controller = new $controllerName();
			
			$result = $controller->$methodName($request);
			
			if (is_string($result)) {
				echo $result;
			}
		} else {
			// Handle 404 Not Found
			http_response_code(404);
			echo "404 Not Found";
		}
		
	}
}