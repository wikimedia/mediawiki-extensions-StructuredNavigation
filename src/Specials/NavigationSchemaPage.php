<?php

namespace StructuredNavigation\Specials;

use OOUI\Tag;
use SpecialPage;
use StructuredNavigation\Json\DocumentationContent;

/**
 * This special page allows viewing the schema used by the extension
 * for validating the JSON structure of a navigation.
 *
 * @license MIT
 */
final class NavigationSchemaPage extends SpecialPage {
	private const PAGE_NAME = 'NavigationSchema';
	private const MESSAGE_SUBTITLE = 'specials-navigationschema-subtitle';

	private DocumentationContent $documentationContent;

	public function __construct( DocumentationContent $documentationContent ) {
		parent::__construct( self::PAGE_NAME );
		$this->documentationContent = $documentationContent;
	}

	/** @inheritDoc */
	protected function getGroupName() {
		return Constants::SPECIAL_PAGE_GROUP;
	}

	/** @inheritDoc */
	public function execute( $subPage ) {
		$this->setHeaders();
		$this->getOutput()->setSubtitle( $this->msg( self::MESSAGE_SUBTITLE )->text() );
		$this->getOutput()->addHTML(
			$this->getEmbeddedCodeView( $this->documentationContent->getSchemaContent() )
		);
	}

	private function getEmbeddedCodeView( string $content ) : Tag {
		return ( new Tag( 'pre' ) )
			->appendContent( $content );
	}
}
