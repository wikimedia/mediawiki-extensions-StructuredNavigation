<?php

namespace StructuredNavigation\Libs\MediaWiki\Linker;

use MediaWiki\Linker\LinkRenderer;
use Message;
use MessageLocalizer;
use MWNamespace;
use TitleValue;

/**
 * Renders the classic "view · talk · edit" links for navigation maps.
 *
 * @license GPL-2.0-or-later
 * @author Samantha Nguyen < samanthanguyen1116@gmail.com >
 */
class TemplateLinksRenderer {

	/** @var LinkRenderer */
	private $linkRenderer;

	/** @var MessageLocalizer */
	private $messageLocalizer;

	/**
	 * @param LinkRenderer $linkRenderer
	 * @param MessageLocalizer $messageLocalizer
	 */
	public function __construct(
		LinkRenderer $linkRenderer,
		MessageLocalizer $messageLocalizer
	) {
		$this->linkRenderer = $linkRenderer;
		$this->messageLocalizer = $messageLocalizer;
	}

	/**
	 * @param int $namespace
	 * @param Title $title
	 * @param string $separatorSymbol
	 * @return string
	 */
	public function getPreparedLinks( int $namespace, Title $title, string $separatorSymbol = '|' ) : string {
		$preparedLinks = [];

		foreach ( $this->getLinks() as $link ) {
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
	 * @return Message
	 */
	private function getMessage( string $messageKey ) : Message {
		return $this->messageLocalizer->msg( "mw-templatelinks-link-{$messageKey}" );
	}

	/**
	 * @param string $messageKey
	 * @return Message
	 */
	private function getTitleAttribute( string $messageKey ) : Message {
		return $this->messageLocalizer->msg( "mw-templatelinks-link-{$messageKey}-title" );
	}
}
