<?php

namespace MediaWiki\Extension\StructuredNavigation\Hooks;

use MediaWiki\Extension\StructuredNavigation\Services\Services;
use MediaWiki\User\Hook\UserGetReservedNamesHook;

/**
 * @license MIT
 */
final class HookHandler implements UserGetReservedNamesHook {
	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UserGetReservedNames
	 * @param array &$reservedUsernames
	 * @return void
	 */
	public function onUserGetReservedNames( &$reservedUsernames ) {
		$reservedUsernames[] = Services::getInstance()->getConfig()
			->get( 'ReservedUsername' );
	}
}
