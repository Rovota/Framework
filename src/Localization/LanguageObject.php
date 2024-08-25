<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Localization;

use Rovota\Framework\Structures\Bucket;
use Rovota\Framework\Support\Internal;

final class LanguageObject
{

	public readonly string $locale;

	public readonly Bucket $data;

	// -----------------

	protected array $translations = [];

	// -----------------

	public function __construct(string $locale)
	{
		$this->locale = $locale;
		$this->data = $this->getLanguageData();
	}

	// -----------------

	public function loadTranslations(): void
	{
		$file = Internal::projectFile('/resources/translations/'.$this->locale.'.json');

		if (file_exists($file)) {
			$contents = file_get_contents($file);
			$this->translations = array_filter(json_decode($contents, true));
		}
	}

	// -----------------

	public function textDirection(): string
	{
		return $this->data->string('about.direction');
	}

	// -----------------

	public function about(): Bucket
	{
		return Bucket::from($this->data->get('about'));
	}

	public function units(): Bucket
	{
		return Bucket::from($this->data->get('units'));
	}

	// -----------------

	public function findTranslation(string $key): string|null
	{
		if (empty($this->translations)) {
			$this->loadTranslations();
		}
		return $this->translations[$key] ?? null;
	}

	// -----------------

	public function getLanguageData(): Bucket
	{
		$data = new Bucket();
		$file = Internal::projectFile('/config/locales/'.$this->locale.'.php');

		if (file_exists($file)) {
			$data->import(require $file);
		}

		return $data;
	}

}