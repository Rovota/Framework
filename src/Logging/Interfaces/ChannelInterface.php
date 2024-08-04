<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Logging\Interfaces;

use Rovota\Framework\Logging\ChannelConfig;
use Stringable;

interface ChannelInterface
{

	public function __toString(): string;

	// -----------------

	public static function create(array $options, string|null $name = null): ChannelInterface;

	// -----------------

	public function isDefault(): bool;

	// -----------------

	public function name(): string;

	public function config(): ChannelConfig;

	// -----------------

	public function attach(ChannelInterface|string|array $channel): ChannelInterface;

	// -----------------

	public function log(mixed $level, string|Stringable $message, array $context = []);

	public function debug(string|Stringable $message, array $context = []);

	public function info(string|Stringable $message, array $context = []);

	public function notice(string|Stringable $message, array $context = []);

	public function warning(string|Stringable $message, array $context = []);

	public function error(string|Stringable $message, array $context = []);

	public function critical(string|Stringable $message, array $context = []);

	public function alert(string|Stringable $message, array $context = []);

	public function emergency(string|Stringable $message, array $context = []);

}