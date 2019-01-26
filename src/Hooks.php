<?php

namespace StructuredNavigation;

use Parser;
use StructuredNavigation\Services\Services;

/**
 * @license GPL-2.0-or-later
 */
final class Hooks {

	/** @var string */
	private const PARSER_TAG = 'mw-navigation';

	/** @var string */
	private const PARSER_TAG_METHOD = 'getParserHandler';

	/**
	 * @see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Hooks/ParserFirstCallInit
	 * @param Parser $parser
	 * @return void
	 */
	public static function onParserFirstCallInit( Parser $parser ) : void {
		$parser->setHook( self::PARSER_TAG, [
			Services::getInstance()->getParserFirstCallInitHandler(),
			self::PARSER_TAG_METHOD
		] );
	}

	/**
	 * @see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Hooks/UserGetReservedNames
	 * @param array &$reservedUsernames
	 * @return void
	 */
	public static function onUserGetReservedNames( array &$reservedUsernames ) : void {
		$reservedUsernames[] = Services::getInstance()->getConfig()
			->get( 'ReservedUsername' );
	}

}
