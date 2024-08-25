<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Security;

use Rovota\Framework\Kernel\ServiceProvider;
use Rovota\Framework\Security\Exceptions\IncorrectKeyException;
use Rovota\Framework\Support\Internal;
use Rovota\Framework\Support\Path;

/**
 * @internal
 */
final class EncryptionManager extends ServiceProvider
{
	protected EncryptionAgent $agent;

	// -----------------

	/**
	 * @throws IncorrectKeyException
	 */
	public function __construct()
	{
		$config = require Path::toProjectFile('config/encryption.php');

		$this->agent = new EncryptionAgent(
			base64_decode($config['key']), $config['cipher']
		);
	}

	// -----------------

	public function getAgent(): EncryptionAgent
	{
		return $this->agent;
	}

}