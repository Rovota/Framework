<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Facades;

use Closure;
use Rovota\Framework\Routing\RouteGroup;
use Rovota\Framework\Routing\RouteInstance;
use Rovota\Framework\Routing\RouteManager;
use Rovota\Framework\Routing\Router;
use Rovota\Framework\Structures\Bucket;
use Rovota\Framework\Support\Facade;
use Rovota\Framework\Support\Str;

/**
 * @method static Router router()
 *
 * @method static RouteInstance fallback(mixed $target)
 * @method static RouteInstance|null current()
 * @method static RouteInstance|null findByName(string $name)
 * @method static Bucket findWithGroupName(string $name)
 *
 * @method static RouteGroup name(string $value)
 * @method static RouteGroup prefix(string $path)
 * @method static RouteGroup controller(string $class)
 * @method static RouteGroup where(array|string $parameter, string|null $pattern = null)
 * @method static RouteGroup whereHash(array|string $parameter, string|int $algorithm)
 * @method static RouteGroup whereNumber(array|string $parameter, int|null $length = null)
 * @method static RouteGroup whereSlug(array|string $parameter, int|null $length = null)
 *
 * @method static RouteInstance match(array|string $methods, string $path, mixed $target = null)
 * @method static RouteInstance get(string $path, mixed $target = null)
 * @method static RouteInstance post(string $path, mixed $target = null)
 * @method static RouteInstance put(string $path, mixed $target = null)
 * @method static RouteInstance delete(string $path, mixed $target = null)
 * @method static RouteInstance options(string $path, mixed $target = null)
 * @method static RouteInstance patch(string $path, mixed $target = null)
 * @method static RouteInstance head(string $path, mixed $target = null)
 */
final class Route extends Facade
{

	public static function service(): RouteManager
	{
		return parent::service();
	}

	// -----------------

	protected static function getFacadeTarget(): string
	{
		return RouteManager::class;
	}

	protected static function getMethodTarget(string $method): Closure|string
	{
		return match ($method) {
			'router' => 'getRouter',

			default => function (RouteManager $instance, string $method, array $parameters = []) {
				$router = $instance->getRouter();

				if (in_array($method, ['get', 'post', 'put', 'delete', 'options', 'patch', 'head'], true)) {
					return $router->define(Str::upper($method), ...$parameters);
				}

				return match ($method) {
					// Router
					'fallback' => $router->setFallback(...$parameters),
					'current' => $router->getCurrentRoute(),
					'findByName' => $router->findRouteByName(...$parameters),
					'findWithGroupName' => $router->findRoutesWithGroupName(...$parameters),

					// Group
					'name' => $instance->getRouteGroup()->name(...$parameters),
					'prefix' => $instance->getRouteGroup()->prefix(...$parameters),
					'controller' => $instance->getRouteGroup()->controller(...$parameters),
					'where' => $instance->getRouteGroup()->where(...$parameters),
					'whereHash' => $instance->getRouteGroup()->whereHash(...$parameters),
					'whereNumber' => $instance->getRouteGroup()->whereNumber(...$parameters),
					'whereSlug' => $instance->getRouteGroup()->whereSlug(...$parameters),

					// Definitions
					'match' => $router->define(...$parameters),

					default => $instance->getRouter()->$method(...$parameters)
				};
			},
		};
	}

}