<?php

namespace StructuredNavigation\Specials;

use OOUI\Tag;
use SpecialPage;

/**
 * @license GPL-2.0-or-later
 */
class NavigationSchemaPage extends SpecialPage {

	public function __construct() {
		parent::__construct( 'NavigationSchema' );
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
