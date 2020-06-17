<?php

namespace StructuredNavigation\Content;

use FormatJson;
use JsonContent;
use ParserOptions;
use ParserOutput;
use StructuredNavigation\Services\Services;
use Title;

/**
 * Content object for representing a structured navigation.
 *
 * @license MIT
 */
final class NavigationContent extends JsonContent {
	public function __construct( string $text ) {
		parent::__construct( $text, CONTENT_MODEL_NAVIGATION );
	}

	/** @inheritDoc */
	protected function fillParserOutput(
		Title $title,
		$revId,
		ParserOptions $options,
		$generateHtml,
		ParserOutput &$output
	) {
		if ( $generateHtml ) {
			$navigationViewPresenter = Services::getInstance()->getNavigationViewPresenter();
			$output->setText(
				$navigationViewPresenter->getFromSource(
					FormatJson::decode( $this->getText(), true )
				)
			);

			$navigationViewPresenter->loadModules( $output );
			$output->addModules( 'ext.structuredNav.content' );
		}
	}
}
