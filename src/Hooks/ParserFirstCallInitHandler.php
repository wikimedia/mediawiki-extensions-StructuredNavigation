<?php

namespace StructuredNavigation\Hooks;

use Parser;
use ParserOutput;
use StructuredNavigation\View\NavigationViewPresenter;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
 * @license MIT
 */
final class ParserFirstCallInitHandler {
	private const PAGE_PROPERTY = 'structurednavigation';

	private NavigationViewPresenter $navigationViewPresenter;

	public function __construct( NavigationViewPresenter $navigationViewPresenter ) {
		$this->navigationViewPresenter = $navigationViewPresenter;
	}

	/**
	 * @return string|false
	 */
	public function getParserHandler( ?string $input, array $attributes, Parser $parser ) {
		$userPassedTitle = $attributes['title'];
		$parserOutput = $parser->getOutput();
		$this->setPageProperty( $parserOutput, $userPassedTitle );

		$navigation = $this->navigationViewPresenter->getFromTitle( $userPassedTitle );
		if ( $navigation === false ) {
			return false;
		}

		$this->navigationViewPresenter->loadModules( $parserOutput );
		return $navigation;
	}

	private function setPageProperty( ParserOutput $parserOutput, string $title ) : void {
		$parserOutput->setProperty( self::PAGE_PROPERTY, htmlspecialchars( $title, ENT_QUOTES ) );
	}
}
