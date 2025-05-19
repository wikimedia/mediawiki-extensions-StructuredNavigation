<?php

namespace StructuredNavigation\Hooks;

use MediaWiki\Config\GlobalVarConfig;
use StructuredNavigation\Api\Action\ApiMetaNavigationExamples;
use StructuredNavigation\Api\Action\ApiMetaNavigationSchema;
use StructuredNavigation\Api\Action\ApiQueryNavigationData;
use StructuredNavigation\Api\Action\ApiQueryNavigationHtml;
use StructuredNavigation\Api\Action\ApiQueryTitlesUsed;

/**
 * @license MIT
 */
class ExtensionCallback {
	private const CONFIG_PREFIX = 'wgStructuredNavigation';

	/**
	 * Callback for ConfigRegistry
	 *
	 * @see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Extension.json/Schema#ConfigRegistry
	 * @return GlobalVarConfig
	 */
	public static function getGlobalVarConfig(): GlobalVarConfig {
		return new GlobalVarConfig( self::CONFIG_PREFIX );
	}

	/**
	 * Extension registration callback
	 *
	 * @see https://www.mediawiki.org/wiki/Special:MyLanguage/Manual:Extension.json/Schema#callback
	 */
	public static function onRegistrationCallback(): void {
		// Must match the name used in the 'ContentHandlers' section of extension.json
		define( 'CONTENT_MODEL_NAVIGATION', 'StructuredNavigation' );

		self::maybeEnableAPI();
	}

	private static function maybeEnableAPI(): void {
		global $wgStructuredNavigationEnableExperimentalAPI;
		if ( $wgStructuredNavigationEnableExperimentalAPI === false ) {
			return;
		}

		global $wgAPIMetaModules;
		$wgAPIMetaModules['structurednavigationexamples'] = [
			'class' => ApiMetaNavigationExamples::class,
			'services' => [
				'StructuredNavigation.DocumentationContent'
			]
		];
		$wgAPIMetaModules['structurednavigationschema'] = [
			'class' => ApiMetaNavigationSchema::class,
			'services' => [
				'StructuredNavigation.DocumentationContent'
			]
		];

		global $wgAPIPropModules;
		$wgAPIPropModules['structurednavigationnavigationdata'] = [
			'class' => ApiQueryNavigationData::class,
			'services' => [
				'StructuredNavigation.NavigationFactory'
			]
		];
		$wgAPIPropModules['structurednavigationnavigationhtml'] = [
			'class' => ApiQueryNavigationHtml::class,
			'services' => [
				'StructuredNavigation.NavigationViewPresenter'
			]
		];
		$wgAPIPropModules['structurednavigationtitlesused'] = [
			'class' => ApiQueryTitlesUsed::class,
			'services' => [
				'StructuredNavigation.NavigationFactory'
			]
		];
	}
}
