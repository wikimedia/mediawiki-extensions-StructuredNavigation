<?php

namespace StructuredNavigation;

use GlobalVarConfig;
use Parser;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use User;

/**
 * @license GPL-2.0-or-later
 */
final class Hooks {

	/**
	 * Callback for ConfigRegistry
	 *
	 * @see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Extension.json/Schema#ConfigRegistry
	 * @return GlobalVarConfig
	 */
	public static function getGlobalVarConfig() : GlobalVarConfig {
		return new GlobalVarConfig( 'wgStructuredNavigation' );
	}

	/**
	 * Extension registration callback
	 *
	 * @see http://mediawiki.org/wiki/Special:MyLanguage/Manual:Extension.json/Schema#callback
	 * @return void
	 */
	public static function onRegistrationCallback() : void {
		// Must match the name used in the 'ContentHandlers' section of extension.json
		define( 'CONTENT_MODEL_NAVIGATION', 'StructuredNavigation' );
	}

	/**
	 * @see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Hooks/ParserFirstCallInit
	 * @param Parser &$parser
	 * @return void
	 */
	public static function onParserFirstCallInit( Parser &$parser ) : void {
		$handler = new ParserFirstCallInitHandler(
			Services::getInstance()->getNavigationRenderer()
		);

		$parser->setHook( Constants::PARSER_TAG, [ $handler, 'getParserHandler' ] );
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
