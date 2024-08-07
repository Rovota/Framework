<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Http\Responses;

use Rovota\Framework\Http\ApiError;
use Rovota\Framework\Http\Enums\StatusCode;
use Rovota\Framework\Http\Response;
use Rovota\Framework\Structures\Config;
use Rovota\Framework\Support\Str;
use Throwable;

class ErrorResponse extends Response
{

	public function __construct(Throwable|ApiError|array $content, StatusCode|int $status, Config $config)
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

		$result = match (true) {
			is_array($this->content) => $this->getContentAsArray($this->content),
			$this->content instanceof Throwable => [$this->getThrowableAsArray($this->content)],
			$this->content instanceof ApiError => [$this->getApiErrorAsArray($this->content)],
			default => $this->content
		};

		$this->content = [
			'timestamp' => now(),
			'errors' => $result,
		];
	}

	// -----------------

	protected function getContentAsArray(array $content): array
	{
		$result = [];

		foreach ($content as $item) {
			if ($item instanceof Throwable) {
				$result[] = $this->getThrowableAsArray($item);
			}
			if ($item instanceof ApiError) {
				$result[] = $this->getApiErrorAsArray($item);
			}
		}

		return $result;
	}

	protected function getThrowableAsArray(Throwable $throwable): array
	{
		return [
			'type' => Str::afterLast($throwable::class, '\\'),
			'code' => $throwable->getCode(),
			'message' => Str::translate($throwable->getMessage()),
		];
	}

	protected function getApiErrorAsArray(ApiError $error): array
	{
		return [
			'type' => Str::afterLast($error::class, '\\'),
			'code' => $error->getCode(),
			'message' => Str::translate($error->getMessage(), $error->getParameters()),
		];
	}

}