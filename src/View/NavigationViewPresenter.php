<?php

namespace StructuredNavigation\View;

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
	 * @param string $title
	 * @return string|false
	 */
	public function getFromTitle( string $title ) {
		$navigation = $this->navigationFactory->newFromTitle( $title );
		if ( $navigation === false ) {
			return false;
		}

		return $this->navigationView->getView( $navigation );
	}

	/**
	 * @param array $content
	 * @return string
	 */
	public function getFromSource( array $content ) : string {
		return $this->navigationView->getView(
			$this->navigationFactory->newFromSource( $content )
		);
	}

	/**
	 * @param ParserOutput|OutputPage $output
	 */
	public function loadModules( $output ) : void {
		$output->addModuleStyles( [
			'ext.structurednavigation.ui.structurednavigation.styles',
			'ext.structurednavigation.ui.structurednavigation.separator.styles',
			'ext.structurednavigation.wiki.styles'
		] );
		$output->addModules( [
			'ext.structurednavigation.wiki',
		] );
	}
}
