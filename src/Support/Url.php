<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Support;

use Rovota\Framework\Facades\Cache;
use Rovota\Framework\Http\Request\RequestManager;
use Rovota\Framework\Routing\UrlObject;

final class Url
{

	protected function __construct()
	{
	}

	// -----------------

	public static function current(): UrlObject
	{
		return RequestManager::instance()->getCurrent()->url();
	}

	// -----------------

	public static function local(string $path, array $parameters = []): UrlObject
	{
		return new UrlObject([
			'path' => $path,
			'parameters' => $parameters,
		]);
	}

	public static function foreign(string $location, array $parameters = []): UrlObject
	{
		return UrlObject::from($location)->withParameters($parameters);
	}

	// -----------------

	// TODO: route()

	/**
	 * This method requires the presence of a cache store using `session` as name.
	 */
	public static function previous(string $default = '/'): UrlObject
	{
		$referrer = RequestManager::instance()->getCurrent()->referrer();
		$location = Cache::store('session')->pull('location.previous', $referrer ?? $default);
		return UrlObject::from($location);
	}

	/**
	 * This method requires the presence of a cache store using `session` as name.
	 */
	public static function next(string $default = '/'): UrlObject
	{
		$location = Cache::store('session')->pull('location.next', $default);
		return UrlObject::from($location);
	}

	/**
	 * This method requires the presence of a cache store using `session` as name.
	 */
	public static function intended(string $default = '/'): UrlObject
	{
		$location = Cache::store('session')->pull('location.intended', $default);
		return UrlObject::from($location);
	}

	// -----------------

	public static function queryToArray(string $value): array
	{
		parse_str($value, $parameters);
		return $parameters;
	}

	public static function arrayToQuery(array $data): string
	{
		return http_build_query($data);
	}

}