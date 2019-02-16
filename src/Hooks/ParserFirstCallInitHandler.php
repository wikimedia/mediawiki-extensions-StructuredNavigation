<?php

namespace StructuredNavigation\Hooks;

use OutputPage;
use Parser;
use ParserOutput;
use StructuredNavigation\AttributeQualifier;
use StructuredNavigation\Json\JsonEntityFactory;
use StructuredNavigation\Renderer\NavigationRenderer;
use Title;
use TitleParser;
use TitleValue;

/**
 * @license GPL-2.0-or-later
 */
final class ParserFirstCallInitHandler {

	/** @var string */
	private const PAGE_PROPERTY = 'structurednavigation';

	/** @var AttributeQualifier */
	private $attributeQualifier;

	/** @var JsonEntityFactory */
	private $jsonEntityFactory;

	/** @var NavigationRenderer */
	private $navigationRenderer;

	/** @var TitleParser */
	private $titleParser;

	/**
	 * @param AttributeQualifier $attributeQualifier
	 * @param JsonEntityFactory $jsonEntityFactory
	 * @param NavigationRenderer $navigationRenderer
	 * @param TitleParser $titleParser
	 */
	public function __construct(
		AttributeQualifier $attributeQualifier,
		JsonEntityFactory $jsonEntityFactory,
		NavigationRenderer $navigationRenderer,
		TitleParser $titleParser
	) {
		$this->attributeQualifier = $attributeQualifier;
		$this->jsonEntityFactory = $jsonEntityFactory;
		$this->navigationRenderer = $navigationRenderer;
		$this->titleParser = $titleParser;
	}

	/**
	 * @param string|null $input
	 * @param array $attributes
	 * @param Parser $parser
	 * @return string
	 */
	public function getParserHandler( ?string $input, array $attributes, Parser $parser ) : string {
		$title = $this->titleParser->parseTitle( $attributes['title'], NS_NAVIGATION );

		$titleFromTitleValue = Title::newFromTitleValue( $title );
		if ( !$titleFromTitleValue->exists() ) {
			return false;
		}

		$content = $this->jsonEntityFactory->newFromTitle( $titleFromTitleValue );

		OutputPage::setupOOUI();
		$parserOutput = $parser->getOutput();
		$this->setPageProperty( $parserOutput, $title );
		$this->loadResourceLoaderModules( $parserOutput );

		$renderedNavigation = $this->navigationRenderer->render( $content );
		$this->attributeQualifier->setAttributes( $renderedNavigation, $title, $attributes );

		return $renderedNavigation;
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
	 * @param TitleValue $title
	 * @return void
	 */
	private function setPageProperty( ParserOutput $parserOutput, TitleValue $title ) : void {
		$parserOutput->setProperty( self::PAGE_PROPERTY, $title->getText() );
	}
}
