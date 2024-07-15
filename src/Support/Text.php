<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Support;

use Closure;
use JsonSerializable;
use Rovota\Framework\Structures\Sequence;
use Rovota\Framework\Support\Traits\Conditionable;
use Rovota\Framework\Support\Traits\Macroable;
use Stringable;

final class Text implements Stringable, JsonSerializable
{
	use Conditionable, Macroable;

	protected string $string;

	// -----------------

	public function __construct(Stringable|string $string)
	{
		$this->string = $string;
	}

	public function __toString(): string
	{
		return $this->string;
	}

	public function jsonSerialize(): string
	{
		return $this->string;
	}

	// -----------------

	public function toString(): string
	{
		return $this->string;
	}

	public function toInteger(): string
	{
		return intval($this->string);
	}

	public function toFloat(): string
	{
		return floatval($this->string);
	}

	public function toBool(): bool
	{
		return filter_var($this->string, FILTER_VALIDATE_BOOLEAN);
	}

	// TODO: toMoment() method, with optional format indication and timezone.

	// -----------------

	/**
	 * Determines whether a string is empty.
	 */
	public function isEmpty(): bool
	{
		return Str::isEmpty($this->string);
	}

	/**
	 * Determines whether a string is formatted as a slug.
	 */
	public function isSlug(string|null $replacement = null): bool
	{
		return Str::isSlug($this->string, $replacement);
	}

	/**
	 * Determines whether a string only contains ASCII characters.
	 */
	public function isAscii(): bool
	{
		return Str::isAscii($this->string);
	}

	// -----------------

	/**
	 * Transforms the given string into uppercase.
	 */
	public function upper(): string
	{
		$this->string = Str::upper($this->string);
		return $this;
	}

	/**
	 * Transforms the given string into lowercase.
	 */
	public function lower(): string
	{
		$this->string = Str::lower($this->string);
		return $this;
	}

	/**
	 * Transforms the given string into title case.
	 */
	public function title(): string
	{
		$this->string = Str::title($this->string);
		return $this;
	}

	// -----------------

	/**
	 * Replaces non-ASCII characters with their ASCII equivalent.
	 */
	public function simplify(): string
	{
		$this->string = Str::simplify($this->string);
		return $this;
	}

	/**
	 * Adds a separator (underscore by default), while transforming the string into lowercase.
	 */
	public function snake(string $separator = '_'): string
	{
		$this->string = Str::snake($this->string, $separator);
		return $this;
	}

	/**
	 * Adds a dash as separator, while transforming the string into lowercase.
	 */
	public function kebab(): string
	{
		$this->string = Str::kebab($this->string);
		return $this;
	}

	/**
	 * Removes spaces, underscores and dashes, while transforming the first letter of each word into uppercase.
	 */
	public function pascal(): string
	{
		$this->string = Str::pascal($this->string);
		return $this;
	}

	/**
	 * Transforms the given string into camel case.
	 */
	public function camel(): string
	{
		$this->string = Str::camel($this->string);
		return $this;
	}

	/**
	 * Simplifies the given string and removes special characters, making the string suitable for URL usage.
	 */
	public function slug(string $separator = '-'): string
	{
		$this->string = Str::slug($this->string, $separator);
		return $this;
	}

	// -----------------

	public function plural(string $string, mixed $count): string
	{
		$this->string = Str::plural($string, $count);
		return $this;
	}

	public function singular(string $string): string
	{
		$this->string = Str::singular($string);
		return $this;
	}

	// -----------------

	public function prepend(string $addition): string
	{
		$this->string = Str::prepend($this->string, $addition);
		return $this;
	}

	public function append(string $addition): string
	{
		$this->string = Str::append($this->string, $addition);
		return $this;
	}

	public function wrap(string $start, string|null $end = null): string
	{
		$this->string = Str::wrap($this->string, $start, $end);
		return $this;
	}

	public function start(string $value): string
	{
		$this->string = Str::start($this->string, $value);
		return $this;
	}

	public function finish(string $value): string
	{
		$this->string = Str::finish($this->string, $value);
		return $this;
	}

	public function startAndFinish(string $value): string
	{
		$this->string = Str::startAndFinish($this->string, $value);
		return $this;
	}

	public function padLeft(int $length, string $pad_with = ' '): string
	{
		$this->string = Str::padLeft($this->string, $length, $pad_with);
		return $this;
	}

	public function padRight(int $length, string $pad_with = ' '): string
	{
		$this->string = Str::padRight($this->string, $length, $pad_with);
		return $this;
	}

	public function padBoth(int $length, string $pad_with = ' '): string
	{
		$this->string = Str::padBoth($this->string, $length, $pad_with);
		return $this;
	}

	// -----------------

	public function shuffle(): string
	{
		$this->string = Str::shuffle($this->string);
		return $this;
	}

	public function reverse(): string
	{
		$this->string = Str::reverse($this->string);
		return $this;
	}

	public function scramble(): string
	{
		$this->string = Str::scramble($this->string);
		return $this;
	}

	public function mask(string $replacement, int|null $length = null, int $start = 0): string
	{
		$this->string = Str::mask($this->string, $replacement, $length, $start);
		return $this;
	}

	public function maskEmail(string $replacement, int $preserve = 3): string
	{
		$this->string = Str::maskEmail($this->string, $replacement, $preserve);
		return $this;
	}

	public function hash(string $algo): Text
	{
		$this->string = hash($this->string, $algo);
		return $this;
	}

	// -----------------

	public function length(): int
	{
		return Str::length($this->string);
	}

	public function limit(int $length, int $start = 0, string $marker = ''): string
	{
		$this->string = Str::limit($this->string, $length, $start, $marker);
		return $this;
	}

	public function trim(string|null $characters = null): string
	{
		$this->string = Str::trim($this->string, $characters);
		return $this;
	}

	public function trimEnd(string|null $characters = null): string
	{
		$this->string = Str::trimEnd($this->string, $characters);
		return $this;
	}

	public function trimStart(string|null $characters = null): string
	{
		$this->string = Str::trimStart($this->string, $characters);
		return $this;
	}

	public function remove(string|array $values, bool $ignore_case = false): string
	{
		$this->string = Str::remove($this->string, $values, $ignore_case);
		return $this;
	}

	// -----------------

	public function before(string $target): string
	{
		$this->string = Str::before($this->string, $target);
		return $this;
	}

	public function beforeLast(string $target): string
	{
		$this->string = Str::beforeLast($this->string, $target);
		return $this;
	}

	public function after(string $target): string
	{
		$this->string = Str::after($this->string, $target);
		return $this;
	}

	public function afterLast(string $target): string
	{
		$this->string = Str::afterLast($this->string, $target);
		return $this;
	}

	public function between(string $start, string $end): string
	{
		$this->string = Str::between($this->string, $start, $end);
		return $this;
	}

	// -----------------

	public function contains(mixed $needle): bool
	{
		return Str::contains($this->string, $needle);
	}

	public function containsAny(array $needles): bool
	{
		return Str::containsAny($this->string, $needles);
	}

	public function containsNone(array $needles): bool
	{
		return Str::containsNone($this->string, $needles);
	}

	public function startsWith(string $needle): bool
	{
		return Str::startsWith($this->string, $needle);
	}

	public function startsWithAny(array $needles): bool
	{
		return Str::startsWithAny($this->string, $needles);
	}

	public function startsWithNone(array $needles): bool
	{
		return Str::startsWithNone($this->string, $needles);
	}

	public function endsWith(string $needle): bool
	{
		return Str::endsWith($this->string, $needle);
	}

	public function endsWithAny(array $needles): bool
	{
		return Str::endsWithAny($this->string, $needles);
	}

	public function endsWithNone(array $needles): bool
	{
		return Str::endsWithNone($this->string, $needles);
	}

	// -----------------

	public function increment(string $separator = '-', int $step = 1): string
	{
		$this->string = Str::increment($this->string, $separator, $step);
		return $this;
	}

	public function decrement(string $separator = '-', int $step = 1): string
	{
		$this->string = Str::decrement($this->string, $separator, $step);
		return $this;
	}

	// -----------------

	public function insert(int $interval, string $character): string
	{
		$this->string = Str::insert($this->string, $interval, $character);
		return $this;
	}

	public function merge(string|array $values): string
	{
		$this->string = Str::merge($this->string, $values);
		return $this;
	}

	public function swap(array $map): string
	{
		$this->string = Str::swap($this->string, $map);
		return $this;
	}

	// -----------------

	public function take(int $amount): string
	{
		$this->string = Str::take($this->string, $amount);
		return $this;
	}

	public function takeLast(int $amount): string
	{
		$this->string = Str::takeLast($this->string, $amount);
		return $this;
	}

	// -----------------

	public function replace(string|array $targets, string|array $values): string
	{
		$this->string = Str::replace($this->string, $targets, $values);
		return $this;
	}

	public function replaceSequential(string $target, array $values): string
	{
		$this->string = Str::replaceSequential($this->string, $target, $values);
		return $this;
	}

	public function replaceFirst(string $target, string $value): string
	{
		$this->string = Str::replaceFirst($this->string, $target, $value);
		return $this;
	}

	public function replaceLast(string $target, string $value): string
	{
		$this->string = Str::replaceLast($this->string, $target, $value);
		return $this;
	}
	
	// -----------------

	public function scan(string $format): array
	{
		return Str::scan($this->string, $format);
	}

	public function occurrences(mixed $needle): int
	{
		return Str::occurrences($this->string, $needle);
	}

	public function wordCount(): int
	{
		return Str::wordCount($this->string);
	}

	// -----------------

	public function explode(string $char, int $elements = PHP_INT_MAX): array
	{
		return Str::explode($this->string, $char, $elements);
	}

	public function escape(string $encoding = 'UTF-8'): string|null
	{
		$this->string = Str::escape($this->string, $encoding);
		return $this;
	}

	public function acronym(string $delimiter = '.'): string
	{
		$this->string = Str::acronym($this->string, $delimiter);
		return $this;
	}

	// -----------------

	public function tap(callable $callback): Text
	{
		$callback($this);
		return $this;
	}

	public function modify(Closure $callback): Text
	{
		$this->string = $callback($this);
		return $this;
	}

	// -----------------

	public function follows(string $pattern): bool
	{
		$pattern = Str::startAndFinish($pattern, '/');
		return preg_match($pattern, $this->string) === 1;
	}

	public function matches(string $pattern): Sequence
	{
		$pattern = Str::startAndFinish($pattern, '/');
		preg_match_all($pattern, $this->string, $matches);
		return new Sequence($matches[0]);
	}

	// -----------------

	public function whenEmpty(callable $callback, callable|null $alternative = null): Text
	{
		return $this->when($this->isEmpty() === true, $callback, $alternative);
	}

	public function whenNotEmpty(callable $callback, callable|null $alternative = null): Text
	{
		return $this->when($this->isEmpty() === false, $callback, $alternative);
	}

}