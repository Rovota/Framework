<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Kernel;

use Rovota\Framework\Caching\CacheManager;
use Rovota\Framework\Http\Client\ClientManager;
use Rovota\Framework\Logging\LoggingManager;
use Rovota\Framework\Support\Config;
use RuntimeException;

/**
 * @property-read string $cookie_domain
 * @property-read array $services
 */
class EnvironmentConfig extends Config
{

	protected function getCookieDomain(): string|null
	{
		return $this->get('cookie_domain', $_SERVER['SERVER_NAME']);
	}

	// -----------------

	protected function getServices(): array
	{
		$services = [
			// Foundation
			'registry' => RegistryManager::class,
			'logging' => LoggingManager::class,
			'cache' => CacheManager::class,
			'http' => ClientManager::class,
		];

		foreach ($this->array('services') as $name => $class) {
			if (isset($services[$name])) {
				throw new RuntimeException("A service with the name '{$name}' already exists.");
			}
			$services[$name] = $class;
		}

		return $services;
	}

	// -----------------

	// TODO: methods like authProviders() and libraries()
	// For example, Environment::authProviders() returns an array with auth provider classes/config.
	// And Environment::libraries() returns an array of library classes to call a load() method on.

	// -----------------

	// -----------------

	// -----------------

	// -----------------

	// -----------------

	// -----------------

}