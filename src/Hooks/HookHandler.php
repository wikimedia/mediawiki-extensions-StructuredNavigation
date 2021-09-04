<?php

namespace StructuredNavigation\Hooks;

use StructuredNavigation\Services\Services;
use Title;

/**
 * @license MIT
 */
final class HookHandler {
	/**
	 * @see https://www.mediawiki.org/wiki/Extension:CodeEditor/Hooks/CodeEditorGetPageLanguage
	 * @param Title $title
	 * @param string|null &$lang
	 * @return bool
	 */
	public static function onCodeEditorGetPageLanguage( Title $title, ?string &$lang ) {
		if ( $title->hasContentModel( 'StructuredNavigation' ) ) {
			$lang = 'json';
			return false;
		}

		return true;
	}

	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UserGetReservedNames
	 * @param array &$reservedUsernames
	 */
	public static function onUserGetReservedNames( array &$reservedUsernames ): void {
		$reservedUsernames[] = Services::getInstance()->getConfig()
			->get( 'ReservedUsername' );
	}
}
