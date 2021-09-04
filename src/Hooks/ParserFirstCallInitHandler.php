<?php

namespace StructuredNavigation\Hooks;

use Parser;
use ParserOutput;
use StructuredNavigation\Services\Services;
use StructuredNavigation\View\NavigationViewPresenter;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
 * @license MIT
 */
final class ParserFirstCallInitHandler {
	private const PAGE_PROPERTY = 'structurednavigation';
	private const PARSER_TAG = 'mw-navigation';
	private const PARSER_TAG_METHOD = 'getParserHandler';

	private NavigationViewPresenter $navigationViewPresenter;

	public function __construct( NavigationViewPresenter $navigationViewPresenter ) {
		$this->navigationViewPresenter = $navigationViewPresenter;
	}

	/**
	 * @param Parser $parser
	 */
	public static function onParserFirstCallInit( Parser $parser ): void {
		$parser->setHook( self::PARSER_TAG, [
			Services::getInstance()->getParserFirstCallInitHandler(),
			self::PARSER_TAG_METHOD
		] );
	}

	/**
	 * @param string|null $input
	 * @param string[] $attributes
	 * @param Parser $parser
	 *
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

	private function setPageProperty( ParserOutput $parserOutput, string $title ): void {
		$parserOutput->setProperty( self::PAGE_PROPERTY, htmlspecialchars( $title, ENT_QUOTES ) );
	}
}
