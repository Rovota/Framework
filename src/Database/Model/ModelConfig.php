<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Database\Model;

use Rovota\Framework\Database\ConnectionManager;
use Rovota\Framework\Facades\DB;
use Rovota\Framework\Support\Arr;
use Rovota\Framework\Support\Config;
use Rovota\Framework\Support\Str;

/**
 * @property string $table
 * @property string $connection
 * @property string $primary_key
 *
 * @property bool $is_stored
 * @property bool $auto_increment
 * @property bool $manage_timestamps
 *
 * @property string $query_order_column
 */
final class ModelConfig extends Config
{

	protected Model $model;

	// -----------------

	public function attachModelReference(Model $model): void
	{
		$this->model = $model;
	}

	// -----------------

	protected function getTable(): string
	{
		return $this->string('table', $this->getTableNameFromClass());
	}

	protected function setTable(string $name): void
	{
		if (DB::connection($this->connection)->getHandler()->hasTable($name)) {
			$this->set('table', $name);
		}
	}

	// -----------------

	protected function getConnection(): string
	{
		return $this->string('connection', ConnectionManager::instance()->getDefault());
	}

	protected function setConnection(string $name): void
	{
		if (ConnectionManager::instance()->has($name)) {
			$this->set('connection', $name);
		}
	}

	// -----------------

	protected function getPrimaryKey(): string
	{
		return $this->string('primary_key', 'id');
	}

	protected function setPrimaryKey(string $key): void
	{
		$this->set('primary_key', trim($key));
	}

	// -----------------

	protected function getIsStored(): bool
	{
		return $this->bool('is_stored');
	}

	protected function setIsStored(bool $value): void
	{
		$this->set('is_stored', $value);
	}

	// -----------------

	protected function getAutoIncrement(): bool
	{
		return $this->bool('auto_increment', true);
	}

	protected function setAutoIncrement(bool $value): void
	{
		$this->set('auto_increment', $value);
	}

	// -----------------

	protected function getManageTimestamps(): bool
	{
		return $this->bool('manage_timestamps', true);
	}

	protected function setManageTimestamps(bool $value): void
	{
		$this->set('manage_timestamps', $value);
	}

	// -----------------

	protected function getQueryOrderColumn(): string
	{
		return $this->string('query_order_column', $this->model::CREATED_COLUMN);
	}

	protected function setQueryOrderColumn(string $value): void
	{
		$this->set('query_order_column', $value);
	}

	// -----------------

	protected function getTableNameFromClass(): string
	{
		$normalized = $this->text($this->model::class)->afterLast('\\')->snake();
		$sections = $normalized->explode('_');

		foreach ($sections as $key => $section) {
			$sections[$key] = Str::singular($section);
		}

		$last_item = Arr::last($sections);
		$combined = implode('_', $sections);

		return str_replace($last_item, Str::plural($last_item), $combined);
	}

}