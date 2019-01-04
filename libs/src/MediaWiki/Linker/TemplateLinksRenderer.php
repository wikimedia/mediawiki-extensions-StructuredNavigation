<?php

namespace StructuredNavigation\Libs\MediaWiki\Linker;

use MediaWiki\Linker\LinkRenderer;
use MWNamespace;
use TitleValue;

/**
 * Renders the classic "view · talk · edit" links for navigation maps.
 *
 * @todo Ideally we wouldn't have be using the global wfMessage() function here...
 * @see https://github.com/SamanthaNguyen/mediawiki-extensions-StructuredNavigation/issues/10
 * @license GPL-2.0-or-later
 * @author Samantha Nguyen < samanthanguyen1116@gmail.com >
 */
class TemplateLinksRenderer {

	/** @var LinkRenderer */
	private $linkRenderer;

	/**
	 * @param LinkRenderer $linkRenderer
	 */
	public function __construct( LinkRenderer $linkRenderer ) {
		$this->linkRenderer = $linkRenderer;
	}

	/**
	 * @param int $namespace
	 * @param string $title
	 * @param string $separatorSymbol
	 * @return string
	 */
	public function getPreparedLinks(
		int $namespace,
		string $title,
		string $separatorSymbol = '|'
	) : string {
		$preparedLinks = [];

		foreach ( $this->getLinks( $namespace, $title ) as $link ) {
			array_push( $preparedLinks, $link );
		}

		return implode( $separatorSymbol, $preparedLinks );
	}

	/**
	 * Users of the class can decide how to output these pages.
	 *
	 * @param int $namespace
	 * @param string $title
	 * @return array
	 */
	public function getLinks( int $namespace, string $title ) : array {
		return [
			'view' => $this->linkRenderer->makeLink(
				$this->getTitleValue( $namespace, $title ),
				$this->getMessage( 'view' ),
				[ 'title' => $this->getTitleAttribute( 'view' ) ]
			),
			'talk' => $this->linkRenderer->makeLink(
				$this->getTitleValue( MWNamespace::getTalk( $namespace ), $title ),
				$this->getMessage( 'talk' ),
				[ 'title' => $this->getTitleAttribute( 'talk' ) ]
			),
			'edit' => $this->linkRenderer->makeLink(
				$this->getTitleValue( $namespace, $title ),
				$this->getMessage( 'edit' ),
				[ 'title' => $this->getTitleAttribute( 'edit' ) ],
				[ 'action' => 'edit' ]
			),
		];
	}

	/**
	 * @return TitleValue
	 */
	private function getTitleValue( int $namespace, string $title ) : TitleValue {
		return new TitleValue( $namespace, $title );
	}

	/**
	 * @param string $messageKey
	 * @return string
	 */
	private function getMessage( string $messageKey ) : string {
		return wfMessage( "mw-templatelinks-link-{$messageKey}" )->escaped();
	}

	/**
	 * @param string $messageKey
	 * @return string
	 */
	private function getTitleAttribute( string $messageKey ) : string {
		return wfMessage( "mw-templatelinks-link-{$messageKey}-title" )->escaped();
	}
}
