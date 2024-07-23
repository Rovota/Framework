<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Support;

use JsonSerializable;
use Rovota\Framework\Routing\UrlObject;
use Stringable;

final class QrCode implements Stringable, JsonSerializable
{

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
		return $this->url();
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

	public function config(): QrCodeConfig
	{
		return $this->config;
	}

	// -----------------

	public function margin(int $margin): QrCode
	{
		$this->config->margin = limit(abs($margin), 0, 100);
		return $this;
	}

	// -----------------

	public function size(int $height, int $width): QrCode
	{
		$this->config->height = $height;
		$this->config->width = $width;
		return $this;
	}

	// -----------------

	public function background(string $color): QrCode
	{
		$this->config->background = trim($color, '#');
		return $this;
	}

	public function foreground(string $color): QrCode
	{
		$this->config->foreground = trim($color, '#');
		return $this;
	}

	// -----------------

	public function url(): UrlObject
	{
		return Url::foreign('api.qrserver.com/v1/create-qr-code')->setParameters([
			'size' => $this->config->size,
			'bgcolor' => $this->config->background,
			'color' => $this->config->foreground,
			'qzone' => $this->config->margin,
			'format' => $this->config->format,
			'data' => $this->config->data,
		]);
	}

}