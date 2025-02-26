<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Facades;

use Closure;
use Rovota\Framework\Support\Facade;
use Rovota\Framework\Views\Components\Link;
use Rovota\Framework\Views\Components\Meta;
use Rovota\Framework\Views\Components\Script;
use Rovota\Framework\Views\Interfaces\ViewInterface;
use Rovota\Framework\Views\ViewManager;

/**
 * @method static ViewInterface create(string $template, string|null $class = null)
 * @method static ViewInterface|null current()
 *
 * @method static bool hasLink(string $template, string $identifier)
 * @method static Link attachLink(array|string $templates, string $identifier, Link|array $attributes)
 *
 * @method static bool hasMeta(string $template, string $identifier)
 * @method static Meta attachMeta(array|string $templates, string $identifier, Meta|array $attributes)
 *
 * @method static bool hasScript(string $template, string $identifier)
 * @method static Script attachScript(array|string $templates, string $identifier, Script|array $attributes)
 *
 * @method static bool hasVariable(string $template, string $identifier)
 * @method static void attachVariable(array|string $templates, string $identifier, mixed $value)
 * @method static void updateVariable(array|string $templates, string $identifier, mixed $value)
 */
final class View extends Facade
{

	public static function service(): ViewManager
	{
		return parent::service();
	}

	// -----------------

	protected static function getFacadeTarget(): string
	{
		return ViewManager::class;
	}

	protected static function getMethodTarget(string $method): Closure|string
	{
		return match ($method) {
			'create' => 'createView',
			default => $method,
		};
	}

}