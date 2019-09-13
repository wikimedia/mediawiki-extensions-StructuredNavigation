<?php

namespace StructuredNavigation\Content;

use FormatJson;
use JsonContent;
use Title;
use ParserOptions;
use ParserOutput;
use StructuredNavigation\Services\Services;

/**
 * Content object for representing a structured navigation.
 *
 * @license MIT
 */
final class NavigationContent extends JsonContent {

	/**
	 * @param string $text
	 */
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
					$output,
					FormatJson::decode( $this->getText(), true )
				)
			);

			$output->addModules( 'ext.structurednavigation.content' );
		}
	}

}
