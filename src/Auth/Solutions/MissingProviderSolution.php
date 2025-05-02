<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Auth\Solutions;

use Rovota\Framework\Support\Interfaces\Solution;

class MissingProviderSolution implements Solution
{

	public function title(): string
	{
		return 'Try the following:';
	}

	public function description(): string
	{
		return 'Ensure that you have a provider configured using the name specified. You may have made a spelling error.';
	}

	public function references(): array
	{
		return [
			'Read documentation' => 'https://rovota.gitbook.io/core/getting-started/configuration/providers'
		];
	}
	
}