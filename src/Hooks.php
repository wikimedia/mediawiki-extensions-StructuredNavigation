<?php

namespace StructuredNavigation;

use MediaWiki\MediaWikiServices;
use Parser;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Services\Services;

/**
 * @license GPL-2.0-or-later
 */
final class Hooks {

	/** @var string */
	private const PARSER_TAG = 'mw-navigation';

	/**
	 * @see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Hooks/ParserFirstCallInit
	 * @param Parser $parser
	 * @return void
	 */
	public static function onParserFirstCallInit( Parser $parser ) : void {
		$handler = new ParserFirstCallInitHandler(
			new AttributeQualifier(),
			Services::getInstance()->getNavigationRenderer(),
			MediaWikiServices::getInstance()->getTitleParser()
		);

		$parser->setHook( self::PARSER_TAG, [ $handler, 'getParserHandler' ] );
	}

	/**
	 * @see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Hooks/UserGetReservedNames
	 * @param array &$reservedUsernames
	 * @return void
	 */
	public static function onUserGetReservedNames( array &$reservedUsernames ) : void {
		$config = Services::getInstance()->getConfig();

		$reservedUsernames[] = $config->get( 'ReservedUsername' );
	}

}
