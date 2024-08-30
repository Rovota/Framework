<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Database\Casts;

use Rovota\Framework\Database\Interfaces\CastInterface;

final class StringCast implements CastInterface
{

	public function supports(mixed $value, array $options): bool
	{
		return is_string($value);
	}

	// -----------------

	public function toRaw(mixed $value, array $options): string
	{
		return (string) $value;
	}

	public function fromRaw(mixed $value, array $options): string
	{
		return (string) $value;
	}

}