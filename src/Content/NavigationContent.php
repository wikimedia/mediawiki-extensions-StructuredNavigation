<?php

namespace StructuredNavigation\Content;

use FormatJson;
use JsonContent;
use ParserOptions;
use ParserOutput;
use Status;
use StructuredNavigation\Schema\NavigationSchemaValidationError;
use StructuredNavigation\Schema\NavigationSchemaValidator;
use StructuredNavigation\Services\Services;
use Title;
use User;
use WikiPage;

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
		if ( $generateHtml && $this->isValidStatus()->isGood() ) {
			$navigationViewPresenter = Services::getInstance()->getNavigationViewPresenter();
			$output->setText(
				$navigationViewPresenter->getFromSource(
					FormatJson::decode( $this->getText(), true )
				)
			);

			$navigationViewPresenter->loadModules( $output );
			$output->addModules( 'ext.structuredNav.content' );
		} else {
			$output->setText( '' );
		}
	}

	public function isValidStatus() {
		/** @var NavigationSchemaValidator */
		$schemaValidator = Services::getInstance()->getNavigationSchemaValidator();
		try {
			$schemaValidator->validate( $this->getData()->getValue() );
			return Status::newGood();
		} catch ( NavigationSchemaValidationError $e ) {
			return Status::newFatal(
				'structurednav-schema-invalid',
				implode( "\n", $e->getErrors() )
			);
		}
	}

	/** @inheritDoc */
	public function prepareSave(
		WikiPage $page,
		$flags,
		$parentRevId,
		User $user
	) {
		return $this->isValidStatus();
	}
}
