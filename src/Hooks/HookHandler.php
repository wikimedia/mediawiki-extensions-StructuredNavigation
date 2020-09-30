<?php

namespace StructuredNavigation\Hooks;

use StructuredNavigation\Api\Action\ApiMetaNavigationExamples;
use StructuredNavigation\Api\Action\ApiMetaNavigationSchema;
use StructuredNavigation\Api\Action\ApiQueryNavigationData;
use StructuredNavigation\Api\Action\ApiQueryNavigationHtml;
use StructuredNavigation\Api\Action\ApiQueryTitlesUsed;
use StructuredNavigation\Services\Services;
use Title;

/**
 * @license MIT
 */
final class HookHandler {
	public static function onRegistration() {
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
	public static function onUserGetReservedNames( array &$reservedUsernames ) : void {
		$reservedUsernames[] = Services::getInstance()->getConfig()
			->get( 'ReservedUsername' );
	}
}
