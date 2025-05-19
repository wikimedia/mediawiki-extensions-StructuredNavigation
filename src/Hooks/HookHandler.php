<?php

namespace StructuredNavigation\Hooks;

use MediaWiki\User\Hook\UserGetReservedNamesHook;
use StructuredNavigation\Services\Services;

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
