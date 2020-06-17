<?php

namespace StructuredNavigation\Hooks;

use Article;
use Parser;
use StructuredNavigation\Services\Services;
use Title;

/**
 * @license MIT
 */
final class HookHandler {
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
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
	 * @param Parser $parser
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
	 */
	public static function onUserGetReservedNames( array &$reservedUsernames ) : void {
		$reservedUsernames[] = Services::getInstance()->getConfig()
			->get( 'ReservedUsername' );
	}
}
