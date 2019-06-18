<?php

namespace StructuredNavigation\Hooks;

use Parser;
use ParserOutput;
use StructuredNavigation\AttributeQualifier;
use StructuredNavigation\View\NavigationViewPresenter;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
 * @license MIT
 */
final class ParserFirstCallInitHandler {

	private const PAGE_PROPERTY = 'structurednavigation';

	/** @var AttributeQualifier */
	private $attributeQualifier;

	/** @var NavigationViewPresenter */
	private $navigationViewPresenter;

	/**
	 * @param AttributeQualifier $attributeQualifier
	 * @param NavigationViewPresenter $navigationViewPresenter
	 */
	public function __construct(
		AttributeQualifier $attributeQualifier,
		NavigationViewPresenter $navigationViewPresenter
	) {
		$this->attributeQualifier = $attributeQualifier;
		$this->navigationViewPresenter = $navigationViewPresenter;
	}

	/**
	 * @param string|null $input
	 * @param array $attributes
	 * @param Parser $parser
	 * @return \OOUI\Tag|false
	 */
	public function getParserHandler( ?string $input, array $attributes, Parser $parser ) {
		$userPassedTitle = $attributes['title'];
		$parserOutput = $parser->getOutput();
		$this->setPageProperty( $parserOutput, $userPassedTitle );

		$navigation = $this->navigationViewPresenter->getFromTitle( $parserOutput, $userPassedTitle );
		if ( $navigation === false ) {
			return false;
		}

		$this->attributeQualifier->setAttributes( $navigation, $attributes );

		return $navigation;
	}

	/**
	 * @param ParserOutput $parserOutput
	 * @param string $title
	 */
	private function setPageProperty( ParserOutput $parserOutput, string $title ) : void {
		$parserOutput->setProperty( self::PAGE_PROPERTY, htmlspecialchars( $title, ENT_QUOTES ) );
	}

}
