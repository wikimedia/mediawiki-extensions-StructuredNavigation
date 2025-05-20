<?php

namespace MediaWiki\Extension\StructuredNavigation\Hooks;

use MediaWiki\Config\Config;
use MediaWiki\User\Hook\UserGetReservedNamesHook;

/**
 * @license MIT
 */
final class HookHandler implements UserGetReservedNamesHook {
	private Config $config;

	public function __construct( Config $config ) {
		$this->config = $config;
	}

	public static function factory( Config $config ): self {
		return new self( $config );
	}

	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UserGetReservedNames
	 * @param array &$reservedUsernames
	 * @return void
	 */
	public function onUserGetReservedNames( &$reservedUsernames ) {
		$reservedUsernames[] = $this->config->get( 'ReservedUsername' );
	}
}
