<?php

/**
 * @author      Software Department <developers@rovota.com>
 * @copyright   Copyright (c), Rovota
 * @license     MIT
 */

namespace Rovota\Framework\Caching\Adapters;

use Redis;
use RedisException;
use Rovota\Framework\Caching\Interfaces\CacheAdapterInterface;
use Rovota\Framework\Kernel\Resolver;
use Rovota\Framework\Structures\Config;

class RedisAdapter implements CacheAdapterInterface
{

	protected Redis $redis;

	protected string|null $last_modified = null;

	protected string|null $scope = null;

	// -----------------

	/**
	 * @throws RedisException
	 */
	public function __construct(Config $parameters)
	{
		$this->redis = new Redis();
		$this->redis->connect($parameters->string('host', '127.0.0.1'));
		$this->redis->auth($parameters->get('password'));
		$this->redis->select($parameters->int('database', 2));

		$this->scope = $parameters->get('scope');
	}

	// -----------------

	public function all(): array
	{
		return [];
	}

	// -----------------

	/**
	 * @throws RedisException
	 */
	public function has(string $key): bool
	{
		$result = $this->redis->exists($this->getScopedKey($key));
		return $result === 1 || $result === true;
	}

	/**
	 * @throws RedisException
	 */
	public function set(string $key, mixed $value, int $retention): void
	{
		$this->last_modified = $key;
		$this->redis->set($this->getScopedKey($key), Resolver::serialize($value), $retention);
	}

	/**
	 * @throws RedisException
	 */
	public function get(string $key): mixed
	{
		$key = $this->getScopedKey($key);
		return $this->redis->exists($key) ? Resolver::deserialize($this->redis->get($key)) : null;
	}

	/**
	 * @throws RedisException
	 */
	public function remove(string $key): void
	{
		$this->last_modified = $key;
		$this->redis->del($this->getScopedKey($key));
	}

	// -----------------

	/**
	 * @throws RedisException
	 */
	public function increment(string $key, int $step = 1): void
	{
		$this->last_modified = $key;
		$this->redis->incrBy($this->getScopedKey($key), max($step, 0));
	}

	/**
	 * @throws RedisException
	 */
	public function decrement(string $key, int $step = 1): void
	{
		$this->last_modified = $key;
		$this->redis->decrBy($this->getScopedKey($key), max($step, 0));
	}

	// -----------------

	/**
	 * @throws RedisException
	 */
	public function flush(): void
	{
		$this->redis->flushDB();
	}

	// -----------------

	public function lastModified(): string|null
	{
		return $this->last_modified;
	}

	// -----------------

	protected function getScopedKey(string $key): string
	{
		if ($this->scope === null || mb_strlen($this->scope) === 0) {
			return $key;
		}
		return sprintf('%s:%s', $this->scope, $key);
	}

}