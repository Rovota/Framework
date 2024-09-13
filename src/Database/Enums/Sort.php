<?php

/**
 * @author      Software Department <developers@rovota.com>
 * @copyright   Copyright (c), Rovota
 * @license     MIT
 */

namespace Rovota\Framework\Database\Enums;

use Rovota\Framework\Support\Traits\EnumHelpers;

enum Sort: string
{
	use EnumHelpers;

	case Asc = 'ASC';
	case Desc = 'DESC';

	// -----------------

	public function label(): string
	{
		return match ($this) {
			Sort::Asc => 'Ascending',
			Sort::Desc => 'Descending',
		};
	}

}