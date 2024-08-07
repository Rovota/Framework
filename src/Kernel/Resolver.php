<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Kernel;

use BackedEnum;
use BadMethodCallException;
use Closure;
use DateTime;
use Rovota\Framework\Structures\Basket;
use Rovota\Framework\Structures\Bucket;
use Rovota\Framework\Structures\Map;
use Rovota\Framework\Structures\Sequence;
use Rovota\Framework\Support\Moment;
use Rovota\Framework\Support\Text;

final class Resolver
{

	protected function __construct()
	{
	}

	// -----------------

	public static function invoke(mixed $target, array $parameters = []): mixed
	{
		if ($target instanceof Closure) {
			return call_user_func_array($target, $parameters);
		}

		if (is_array($target)) {
			[$controller, $method] = $target;
			$controller = new $controller();

			if (is_callable([$controller, $method])) {
				return call_user_func_array([$controller, $method], $parameters);
			} else {
				throw new BadMethodCallException("The method specified cannot be called: $controller@$method.");
			}
		}

		return null;
	}

	public static function getValueType(mixed $value): string
	{
		return match(true) {
			$value instanceof BackedEnum => 'enum',
			$value instanceof Basket => 'basket',
			$value instanceof Bucket => 'bucket',
			$value instanceof Map => 'map',
			$value instanceof Sequence => 'sequence',
			$value instanceof Moment => 'moment',
			$value instanceof DateTime => 'datetime',
			$value instanceof Text => 'text',
			is_array($value) => 'array',
			is_bool($value) => 'bool',
			is_float($value) => 'float',
			is_int($value) => 'int',
			is_string($value) => 'string',
			default => gettype($value),
		};
	}

	// -----------------

	public static function serialize($value): string
	{
		return is_numeric($value) && ! in_array($value, [INF, -INF]) && ! is_nan($value) ? $value : serialize($value);
	}

	public static function deserialize($value): mixed
	{
		return is_numeric($value) ? $value : unserialize($value);
	}

}