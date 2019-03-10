<?php

namespace StructuredNavigation;

use Article;
use Parser;
use StructuredNavigation\Hooks\BeforeDisplayNoArticleTextHandler;
use StructuredNavigation\Services\Services;

/**
 * @license MIT
 */
final class Hooks {

	private const PARSER_TAG = 'mw-navigation';

	private const PARSER_TAG_METHOD = 'getParserHandler';

	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforeDisplayNoArticleText
	 * @param Article $article
	 * @return bool
	 */
	public static function onBeforeDisplayNoArticleText( Article $article ) : bool {
		return ( new BeforeDisplayNoArticleTextHandler( $article ) )->getHandler();
	}

	/**
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
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
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UserGetReservedNames
	 * @param array &$reservedUsernames
	 * @return void
	 */
	public static function onUserGetReservedNames( array &$reservedUsernames ) : void {
		$reservedUsernames[] = Services::getInstance()->getConfig()
			->get( 'ReservedUsername' );
	}

}
