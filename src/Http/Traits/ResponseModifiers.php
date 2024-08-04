<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Http\Traits;

use JsonSerializable;
use Rovota\Framework\Http\Enums\StatusCode;
use Rovota\Framework\Support\Str;

trait ResponseModifiers
{

	public function header(string $name, string $value): static
	{
		$name = trim($name);
		$value = trim($value);

		if (Str::length($name) > 0 && Str::length($value) > 0) {
			$this->config->set('headers.'.$name, $value);
		}

		return $this;
	}

	public function headers(array $headers): static
	{
		foreach ($headers as $name => $value) {
			$this->header($name, $value);
		}

		return $this;
	}

	public function withoutHeader(string $name): static
	{
		$this->config->remove('headers.'.trim($name));

		return $this;
	}

	public function withoutHeaders(array $names = []): static
	{
		if (empty($names)) {
			$this->config->remove('headers');
		} else {
			foreach ($names as $name) {
				$this->withoutHeader($name);
			}
		}

		return $this;
	}

	// -----------------

	public function setContentType(string $value): static
	{
		$this->header('Content-Type', trim($value));

		return $this;
	}

	public function setContentDisposition(string $value): static
	{
		$this->header('Content-Disposition', trim($value));

		return $this;
	}

	// -----------------

	/**
	 * When no extension is specified, one will be determined based on the content provided.
	 */
	public function asDownload(string $name = null): static
	{
		$name = $this->getFileNameForContent($name);
		$value = sprintf('attachment; filename="%s"', $name);
		$this->setContentDisposition($value);

		return $this;
	}

	// -----------------

	public function setHttpCode(StatusCode|int $status): static
	{
		if ($status instanceof StatusCode) {
			$this->status = $status;
			return $this;
		}

		$this->status = StatusCode::tryFrom($status) ?? StatusCode::Ok;
		return $this;
	}

	// -----------------

	// -----------------

	// -----------------

	// -----------------

	// -----------------

	protected function getFileNameForContent(string $name = null): string
	{
		if ($name === null) {
			$name = 'download-'.Str::random(15);
		}
		
		if (str_contains($name, '.')) {
			return $name;
		}

		return match(true) {
//			$this->content instanceof View => sprintf('%s.%s', $name, 'html'),
//			$this->content instanceof FileInterface => sprintf('%s.%s', $name, $this->content->properties()->extension),
			$this->content instanceof JsonSerializable, is_array($this->content) => sprintf('%s.%s', $name, 'json'),
			default => sprintf('%s.%s', $name, 'txt')
		};
	}


}