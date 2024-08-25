<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Support;

final class Path
{

	protected function __construct()
	{
	}

	// -----------------

	/**
	 * Returns a complete path to a given file in the framework folder, where `bootloader.php` is located.
	 */
	public static function toSourceFile(string $path = ''): string
	{
		return self::toProjectFile($path, self::getFrameworkRootPath());
	}

	/**
	 * Returns a complete path to a given file in the project folder, where `app.php` is located.
	 */
	public static function toProjectFile(string $path = '', string|null $base = null): string
	{
		$base = $base ?? self::getProjectRootPath();
		return strlen($path) > 0 ? $base.'/'.ltrim($path, '/') : $base;
	}

	// -----------------
	
	protected static function getFrameworkRootPath(): string
	{
		return str_replace('\Support', '', dirname(__FILE__));
	}

	protected static function getProjectRootPath(): string
	{
		return defined('BASE_PATH') ? BASE_PATH : self::getFrameworkRootPath();
	}

}