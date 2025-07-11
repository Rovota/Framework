<?php

/**
 * @copyright   Léandro Tijink
 * @license     MIT
 */

namespace Rovota\Framework\Identity\Enums;

enum GuardType: string
{

	case App = 'app';
	case Email = 'email';
	case Recovery = 'recovery';
	case PhysicalKey = 'key';

	// -----------------

	public function label(): string
	{
		return match ($this) {
			GuardType::App => 'Authenticator app',
			GuardType::Email => 'Email',
			GuardType::Recovery => 'Recovery codes',
			GuardType::PhysicalKey => 'Physical key',
		};
	}

	public function description(): string
	{
		return match ($this) {
			GuardType::App => 'Verify each sign-in using a code generated by a supported app, like Google Authenticator.',
			GuardType::Email => 'Receive an email with a code to verify each sign-in. Requires a verified email-address.',
			GuardType::Recovery => 'This method will be enabled automatically. When you lose access, you can recover your account using one of the pre-generated codes.',
			GuardType::PhysicalKey => 'Verify your identity using a supported physical key.',
		};
	}

	public function supports(): array|null
	{
		return match ($this) {
			GuardType::App => ['Google Authenticator', 'Microsoft Authenticator', 'Authy'],
			GuardType::Email => ['Verified email-addresses'],
			default => null,
		};
	}

}