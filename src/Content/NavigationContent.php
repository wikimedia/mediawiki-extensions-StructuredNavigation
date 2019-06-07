<?php

namespace StructuredNavigation\Content;

use FormatJson;
use JsonContent;
use Title;
use OutputPage;
use ParserOptions;
use ParserOutput;
use StructuredNavigation\Services\Services;
use StructuredNavigation\Json\JsonEntity;

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

	/**
	 * @inheritDoc
	 */
	protected function fillParserOutput(
		Title $title,
		$revId,
		ParserOptions $options,
		$generateHtml,
		ParserOutput &$output
	) {
		if ( $generateHtml ) {
			$navigationView = Services::getInstance()->getNavigationView();
			$jsonEntity = new JsonEntity( FormatJson::decode( $this->getText(), true ) );

			OutputPage::setupOOUI();
			$output->addModuleStyles( [
				'ext.structurednavigation.ui.structurednavigation.styles',
				'ext.structurednavigation.ui.structurednavigation.separator.styles'
			] );

			$output->setText( $navigationView->getView( $jsonEntity ) );
		}
	}
}
