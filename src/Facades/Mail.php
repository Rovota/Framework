<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Facades;

use Closure;
use Rovota\Framework\Mail\Enums\Driver;
use Rovota\Framework\Mail\Interfaces\MailerInterface;
use Rovota\Framework\Mail\Mailable;
use Rovota\Framework\Mail\MailManager;
use Rovota\Framework\Support\Facade;

/**
 * @method static MailerInterface using(string|null $name = null)
 * @method static MailerInterface|null usingDriver(Driver $driver)
 * @method static MailerInterface create(array $config, string|null $name = null)
 *
 * @method static Mailable make()
 * @method static void attachHeader(string $name, string $value)
 * @method static void attachHeaders(array $headers)
 * @method static void clear()
 * @method static void reset()
 */
final class Mail extends Facade
{

	public static function service(): MailManager
	{
		return parent::service();
	}

	// -----------------

	protected static function getFacadeTarget(): string
	{
		return MailManager::class;
	}

	protected static function getMethodTarget(string $method): Closure|string
	{
		return match ($method) {
			'using' => 'get',
			'usingDriver' => 'getWithDriver',
			'create' => 'createMailer',
			default => function (MailManager $instance, string $method, array $parameters = []) {
				return $instance->get()->$method(...$parameters);
			},
		};
	}

}