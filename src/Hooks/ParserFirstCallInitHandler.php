<?php

namespace MediaWiki\Extension\StructuredNavigation\Hooks;

use MediaWiki\Extension\StructuredNavigation\View\NavigationViewPresenter;
use MediaWiki\Hook\ParserFirstCallInitHook;
use MediaWiki\Parser\Parser;
use MediaWiki\Parser\ParserOutput;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
 * @license MIT
 */
final class ParserFirstCallInitHandler implements ParserFirstCallInitHook {
	private const PAGE_PROPERTY = 'structurednavigation';
	private const PARSER_TAG = 'mw-navigation';
	private const PARSER_TAG_METHOD = 'getParserHandler';

	private NavigationViewPresenter $navigationViewPresenter;

	public function __construct(
		NavigationViewPresenter $navigationViewPresenter
	) {
		$this->navigationViewPresenter = $navigationViewPresenter;
	}

	public static function factory(
		NavigationViewPresenter $navigationViewPresenter
	): self {
		return new self(
			$navigationViewPresenter
		);
	}

	/**
	 * @param Parser $parser
	 * @return void
	 */
	public function onParserFirstCallInit( $parser ) {
		$parser->setHook( self::PARSER_TAG, [
			$this,
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
		$parserOutput->setPageProperty( self::PAGE_PROPERTY, htmlspecialchars( $title, ENT_QUOTES ) );
	}
}
