<?php

/**
 * @copyright   Léandro Tijink
 * * @license     MIT
 *
 * Inspired by the Laravel/Conditionable trait.
 */

namespace Rovota\Framework\Routing\Traits;

use Rovota\Framework\Routing\Enums\Scheme;
use Rovota\Framework\Routing\UrlObject;
use Rovota\Framework\Support\Str;

trait UrlModifiers
{

	public function setScheme(Scheme|string $scheme): UrlObject
	{
		if (is_string($scheme)) {
			$scheme = Scheme::tryFrom($scheme) ?? Scheme::Https;
		}

		$this->scheme = $scheme;

		return $this;
	}
	
	// -----------------

	public function setSubdomain(string $subdomain): UrlObject
	{
		// TODO: Apply a default domain value when it's not already set.
		if ($this->domain === null) {
//			$this->domain(RequestManager::getRequest()->targetHost());
		}

		$subdomain = trim($subdomain);

		// Set to null when unusable value is given.
		if (mb_strlen($subdomain) === 0) {
			$this->subdomain = null;
			return $this;
		}

		// Set to null when useless value is given.
		if ($subdomain === 'www' || $subdomain === '.') {
			$this->subdomain = null;
			return $this;
		}

		$this->subdomain = trim($subdomain);

		return $this;
	}

	public function setDomain(string $domain): UrlObject
	{
		$domain = trim($domain);

		// TODO: Apply a default domain value when unusable value is given.
		if (mb_strlen($domain) === 0) {
//			$this->domain(RequestManager::getRequest()->targetHost());
		}

		if (Str::occurrences($domain, '.') > 1) {
			$this->subdomain = Str::before($domain, '.');
		}

		$this->domain = Str::after($domain, '.');

		return $this;
	}

	public function setPort(int $port): UrlObject
	{
		// Set to null when redundant value is given.
		if ($port === 80 || $port === 443) {
			$this->port = null;
			return $this;
		}

		$this->port = $port;

		return $this;
	}

	// -----------------

	public function setPath(string $path): UrlObject
	{
		$path = trim($path, ' /');

		// Set to null when unusable value is given.
		if (mb_strlen($path) === 0) {
			$this->path = null;
			return $this;
		}

		$this->path = $path;

		return $this;
	}

	public function setParameters(array $parameters): UrlObject
	{
		foreach ($parameters as $name => $value) {
			$this->setParameter($name, $value);
		}

		return $this;
	}

	public function setParameter(string $name, mixed $value): UrlObject
	{
		$name = strtolower(trim($name));

		if ($value === null) {
			unset($this->parameters[$name]);
			return $this;
		}

		$this->parameters[$name] = $value;

		return $this;
	}

	public function setFragment(string $fragment): UrlObject
	{
		$fragment = trim($fragment);

		// Set to null when unusable value is given.
		if (mb_strlen($fragment) === 0) {
			$this->fragment = null;
			return $this;
		}

		$this->fragment = trim($fragment);

		return $this;
	}

}