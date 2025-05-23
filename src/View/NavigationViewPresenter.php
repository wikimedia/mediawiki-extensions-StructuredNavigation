<?php

namespace MediaWiki\Extension\StructuredNavigation\View;

use MediaWiki\Extension\StructuredNavigation\NavigationFactory;
use MediaWiki\Output\OutputPage;
use MediaWiki\Parser\ParserOutput;

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
	 * @todo Refactor to return Status so it's more informative
	 * @param string $title
	 * @return string|false
	 */
	public function getFromTitle( string $title ) {
		$navigation = $this->navigationFactory->newFromTitle( $title );
		return $navigation === false
			? false
			: $this->navigationView->getView( $navigation );
	}

	/**
	 * @param array $content
	 * @return string
	 */
	public function getFromSource( array $content ): string {
		return $this->navigationView->getView(
			$this->navigationFactory->newFromSource( $content )
		);
	}

	/**
	 * @param ParserOutput|OutputPage $output
	 */
	public function loadModules( $output ): void {
		$output->addModuleStyles( [
			'ext.structuredNav.NavigationView.styles',
			'ext.structuredNav.NavigationView.separator.styles',
			'ext.structuredNav.wiki.styles'
		] );
		$output->addModules( [
			'ext.structuredNav.wiki',
		] );
	}
}
