<?php

namespace StructuredNavigation;

use GlobalVarConfig;

/**
 * @license MIT
 */
class ExtensionCallback {

	/** @var string */
	private const CONFIG_PREFIX = 'wgStructuredNavigation';

	/**
	 * Callback for ConfigRegistry
	 *
	 * @see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Extension.json/Schema#ConfigRegistry
	 * @return GlobalVarConfig
	 */
	public static function getGlobalVarConfig() : GlobalVarConfig {
		return new GlobalVarConfig( self::CONFIG_PREFIX );
	}

	/**
	 * Extension registration callback
	 *
	 * @see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Extension.json/Schema#callback
	 * @return void
	 */
	public static function onRegistrationCallback() : void {
		// Must match the name used in the 'ContentHandlers' section of extension.json
		define( 'CONTENT_MODEL_NAVIGATION', 'StructuredNavigation' );
	}
}
