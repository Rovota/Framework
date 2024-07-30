<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 *
 * Inspired by the Laravel/Conditionable trait.
 */

namespace Rovota\Framework\Routing\Traits;

use Rovota\Framework\Http\Request;
use Rovota\Framework\Routing\Enums\Scheme;
use Rovota\Framework\Support\Str;

trait UrlModifiers
{

	public function scheme(Scheme|string $scheme): static
	{
		if (is_string($scheme)) {
			$scheme = Scheme::tryFrom($scheme) ?? Scheme::Https;
		}

		$this->config->scheme = $scheme;

		return $this;
	}
	
	// -----------------

	public function subdomain(string $subdomain): static
	{
		if ($this->config->domain === null) {
			$this->domain(Request::current()->targetHost());
		}

		$subdomain = trim($subdomain);

		// Set to null when unusable value is given.
		if (mb_strlen($subdomain) === 0) {
			$this->stripSubdomain();
			return $this;
		}

		// Set to null when useless value is given.
		if ($subdomain === 'www' || $subdomain === '.' || $subdomain === '-') {
			$this->stripSubdomain();
			return $this;
		}

		$this->config->subdomain = $subdomain;

		return $this;
	}

	public function domain(string $domain): static
	{
		$domain = trim($domain);

		if (mb_strlen($domain) === 0 || $domain === '-') {
			$this->currentHostAsDomain();
			return $this;
		}

		if (Str::occurrences($domain, '.') > 1) {
			$this->config->subdomain = Str::before($domain, '.');
			$domain = Str::after($domain, '.');
		}

		$this->config->domain = $domain;

		return $this;
	}

	public function port(int $port): static
	{
		$this->config->port = $port;
		return $this;
	}

	// -----------------

	public function path(string $path): static
	{
		$path = trim($path, ' /');

		// Set to null when unusable value is given.
		if (mb_strlen($path) === 0 || $path === '-') {
			$this->stripPath();
			return $this;
		}

		$this->config->path = $path;

		return $this;
	}

	public function parameters(array $parameters): static
	{
		if (empty($parameters)) {
			$this->stripParameters();
			return $this;
		}

		foreach ($parameters as $name => $value) {
			$this->parameter($name, $value);
		}

		return $this;
	}

	public function parameter(string $name, mixed $value): static
	{
		$name = 'parameters.'.strtolower(trim($name));

		if ($value === null) {
			$this->config->remove($name);
			return $this;
		}

		$this->config->set($name, $value);

		return $this;
	}

	public function fragment(string $fragment): static
	{
		$fragment = trim($fragment);

		// Set to null when unusable value is given.
		if (mb_strlen($fragment) === 0 || $fragment === '-') {
			$this->stripFragment();
			return $this;
		}

		$this->config->fragment = $fragment;

		return $this;
	}

	// -----------------

	public function currentHostAsDomain(): static
	{
		$this->domain(Request::current()->targetHost());
		return $this;
	}

	// -----------------

	public function stripSubdomain(): static
	{
		$this->config->subdomain = null;
		return $this;
	}

	public function stripPath(): static
	{
		$this->config->path = null;
		return $this;
	}

	public function stripParameters(): static
	{
		$this->config->parameters = null;
		return $this;
	}

	public function stripFragment(): static
	{
		$this->config->fragment = null;
		return $this;
	}

}