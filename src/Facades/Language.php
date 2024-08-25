<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Facades;

use Closure;
use Rovota\Framework\Localization\LanguageObject;
use Rovota\Framework\Localization\LocalizationManager;
use Rovota\Framework\Structures\Bucket;
use Rovota\Framework\Support\Facade;

/**
 * @method static LanguageObject current()
 * @method static LanguageObject|null get(string $locale)
 *
 * @method static void makeCurrent(string $locale)
 * @method static bool exists(string $locale)
 * @method static array all()
 * @method static array allWithPrefix(string $prefix)
 *
 * @method static string textDirection()
 * @method static Bucket about()
 * @method static Bucket units()
 */
final class Language extends Facade
{

	public static function service(): LocalizationManager
	{
		return parent::service();
	}

	// -----------------

	protected static function getFacadeTarget(): string
	{
		return LocalizationManager::class;
	}

	protected static function getMethodTarget(string $method): Closure|string
	{
		return match ($method) {
			'makeCurrent' => 'setActiveLocale',
			'current' => 'getCurrentLanguage',
			'get' => 'getLanguage',
			'exists' => 'hasLanguage',
			'all' => 'getLanguages',
			'allWithPrefix' => 'getLanguagesWithPrefix',
			default => function (LocalizationManager $instance, string $method, array $parameters = []) {
				return $instance->getCurrentLanguage()->$method(...$parameters);
			},
		};
	}

}