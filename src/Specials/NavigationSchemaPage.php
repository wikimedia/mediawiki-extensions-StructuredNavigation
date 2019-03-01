<?php

namespace StructuredNavigation\Specials;

use OOUI\Tag;
use SpecialPage;

/**
 * @license MIT
 */
final class NavigationSchemaPage extends SpecialPage {

	private const PAGE_NAME = 'NavigationSchema';

	public function __construct() {
		parent::__construct( self::PAGE_NAME );
	}

	/**
	 * @param string|null $subPage
	 */
	public function execute( $subPage ) {
		$fileContent = file_get_contents( __DIR__ . '/../../docs/schema/schema.v1.json' );

		$this->setHeaders();
		$this->getOutput()->addHTML(
			$this->getEmbeddedCodeView( $fileContent )
		);
	}

	/**
	 * @param string $content
	 * @return Tag
	 */
	private function getEmbeddedCodeView( string $content ) : Tag {
		return ( new Tag( 'pre' ) )
			->appendContent( $content );
	}
}
