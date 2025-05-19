<?php

namespace StructuredNavigation\Hooks;

use MediaWiki\Extension\CodeEditor\Hooks\CodeEditorGetPageLanguageHook;
use MediaWiki\Title\Title;

/**
 * @see https://www.mediawiki.org/wiki/Extension:CodeEditor/Hooks/CodeEditorGetPageLanguage
 * @license MIT
 */
class CodeEditorHooks implements CodeEditorGetPageLanguageHook {
	/**
	 * @return bool|void
	 */
	public function onCodeEditorGetPageLanguage( Title $title, ?string &$lang, string $model, string $format ) {
		if ( $title->hasContentModel( CONTENT_MODEL_NAVIGATION ) ) {
			$lang = 'json';
			return false;
		}

		return true;
	}
}
