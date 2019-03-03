<?php

namespace StructuredNavigation\Hooks;

use OutputPage;
use Parser;
use ParserOutput;
use StructuredNavigation\AttributeQualifier;
use StructuredNavigation\Json\JsonEntityFactory;
use StructuredNavigation\View\NavigationView;

/**
 * @license MIT
 */
final class ParserFirstCallInitHandler {

	private const PAGE_PROPERTY = 'structurednavigation';

	/** @var AttributeQualifier */
	private $attributeQualifier;

	/** @var JsonEntityFactory */
	private $jsonEntityFactory;

	/** @var NavigationView */
	private $navigationView;

	/**
	 * @param AttributeQualifier $attributeQualifier
	 * @param JsonEntityFactory $jsonEntityFactory
	 * @param NavigationView $navigationView
	 */
	public function __construct(
		AttributeQualifier $attributeQualifier,
		JsonEntityFactory $jsonEntityFactory,
		NavigationView $navigationView
	) {
		$this->attributeQualifier = $attributeQualifier;
		$this->jsonEntityFactory = $jsonEntityFactory;
		$this->navigationView = $navigationView;
	}

	/**
	 * @param string|null $input
	 * @param array $attributes
	 * @param Parser $parser
	 * @return string
	 */
	public function getParserHandler( ?string $input, array $attributes, Parser $parser ) : string {
		$userPassedTitle = $attributes['title'];
		$content = $this->jsonEntityFactory->newFromTitle( $userPassedTitle );

		if ( $content === false ) {
			return false;
		}

		OutputPage::setupOOUI();
		$parserOutput = $parser->getOutput();
		$this->setPageProperty( $parserOutput, $userPassedTitle );
		$this->loadResourceLoaderModules( $parserOutput );

		$navigation = $this->navigationView->getView( $content );
		$this->attributeQualifier->setAttributes( $navigation, $attributes );

		return $navigation;
	}

	/**
	 * @param ParserOutput $parserOutput
	 * @return void
	 */
	private function loadResourceLoaderModules( ParserOutput $parserOutput ) : void {
		$parserOutput->addModuleStyles( [
			'ext.structurednavigation.ui.structurednavigation.styles',
			'ext.structurednavigation.ui.structurednavigation.separator.styles'
		] );
	}

	/**
	 * @param ParserOutput $parserOutput
	 * @param string $title
	 * @return void
	 */
	private function setPageProperty( ParserOutput $parserOutput, string $title ) : void {
		$parserOutput->setProperty( self::PAGE_PROPERTY, htmlspecialchars( $title, ENT_QUOTES ) );
	}

}
