<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Http\Responses;

use JsonSerializable;
use Rovota\Framework\Http\Enums\StatusCode;
use Rovota\Framework\Http\Response;
use Rovota\Framework\Structures\Config;
use Rovota\Framework\Support\Interfaces\Arrayable;

class JsonResponse extends Response
{
	public function __construct(JsonSerializable|array $content, StatusCode|int $status, Config $config)
	{
		parent::__construct($content, $status, $config);
	}

	// -----------------

	protected function getPrintableContent(): string
	{
		return json_encode_clean($this->content);
	}

	protected function prepareForPrinting(): void
	{
		$this->setContentType('application/json; charset=UTF-8');

		$this->content = match (true) {
			$this->content instanceof JsonSerializable => $this->content->jsonSerialize(),
			$this->content instanceof Arrayable => $this->content->toArray(),
			default => $this->content
		};
	}

}