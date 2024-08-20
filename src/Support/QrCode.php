<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Support;

use JsonSerializable;
use Rovota\Framework\Routing\UrlObject;
use Rovota\Framework\Support\Traits\QrCodeModifiers;
use Stringable;

final class QrCode implements Stringable, JsonSerializable
{
	use QrCodeModifiers;

	// -----------------

	protected QrCodeConfig $config;

	// -----------------

	public function __construct(string $data)
	{
		$this->config = new QrCodeConfig([
			'data' => trim($data),
		]);
	}

	public function __toString(): string
	{
		return (string) $this->url();
	}

	public function __get(string $name)
	{
		return $this->config->{$name};
	}

	public function __set(string $name, $value): void
	{
		$this->config->set($name, $value);
	}

	// -----------------

	public function jsonSerialize(): string
	{
		return $this->__toString();
	}

	// -----------------

	public static function from(string $data): self
	{
		return new self($data);
	}

	// -----------------

	public function url(): UrlObject
	{
		return Url::foreign('api.qrserver.com/v1/create-qr-code')->withParameters([
			'size' => $this->size,
			'bgcolor' => $this->background,
			'color' => $this->foreground,
			'qzone' => $this->margin,
			'format' => $this->format,
			'data' => $this->data,
		]);
	}

}