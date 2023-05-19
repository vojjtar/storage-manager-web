<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		//$router->addRoute('<presenter>/<action>[/<id>]', 'Home:default');
		$router->addRoute('warehouse/', 'Warehouse:default');
		$router->addRoute('storage/', 'Storage:default');
		return $router;
	}
}
