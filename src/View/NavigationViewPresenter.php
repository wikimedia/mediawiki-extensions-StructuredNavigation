<?php

namespace StructuredNavigation\View;

use OOUI\Tag;
use OutputPage;
use ParserOutput;
use StructuredNavigation\NavigationFactory;

/**
 * @license MIT
 */
final class NavigationViewPresenter {
	private NavigationFactory $navigationFactory;
	private NavigationView $navigationView;

	public function __construct(
		NavigationFactory $navigationFactory,
		NavigationView $navigationView
	) {
		$this->navigationFactory = $navigationFactory;
		$this->navigationView = $navigationView;
	}

	/**
	 * @param ParserOutput|OutputPage $output
	 * @param string $title
	 * @return Tag|false
	 */
	public function getFromTitle( $output, string $title ) {
		$this->doSetup( $output );
		$jsonEntity = $this->navigationFactory->newFromTitle( $title );
		if ( $jsonEntity === false ) {
			return false;
		}

		return $this->navigationView->getView( $jsonEntity );
	}

	/**
	 * @param ParserOutput|OutputPage $output
	 * @param array $content
	 * @return Tag
	 */
	public function getFromSource( $output, array $content ) : Tag {
		$this->doSetup( $output );
		return $this->navigationView->getView(
			$this->navigationFactory->newFromSource( $content )
		);
	}

	/**
	 * @param ParserOutput|OutputPage $output
	 */
	private function doSetup( $output ) : void {
		OutputPage::setupOOUI();
		$output->addModuleStyles( [
			'ext.structurednavigation.ui.structurednavigation.styles',
			'ext.structurednavigation.ui.structurednavigation.separator.styles'
		] );
	}
}
