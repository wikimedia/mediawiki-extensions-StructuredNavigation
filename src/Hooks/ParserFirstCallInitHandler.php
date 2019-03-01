<?php

namespace StructuredNavigation\Hooks;

use OutputPage;
use Parser;
use ParserOutput;
use StructuredNavigation\AttributeQualifier;
use StructuredNavigation\Json\JsonEntityFactory;
use StructuredNavigation\Title\NavigationTitleValue;
use StructuredNavigation\View\NavigationView;
use Title;
use TitleValue;

/**
 * @license MIT
 */
final class ParserFirstCallInitHandler {

	/** @var string */
	private const PAGE_PROPERTY = 'structurednavigation';

	/** @var AttributeQualifier */
	private $attributeQualifier;

	/** @var JsonEntityFactory */
	private $jsonEntityFactory;

	/** @var NavigationView */
	private $navigationView;

	/** @var NavigationTitleValue */
	private $navigationTitleValue;

	/**
	 * @param AttributeQualifier $attributeQualifier
	 * @param JsonEntityFactory $jsonEntityFactory
	 * @param NavigationTitleValue $navigationTitleValue
	 * @param NavigationView $navigationView
	 */
	public function __construct(
		AttributeQualifier $attributeQualifier,
		JsonEntityFactory $jsonEntityFactory,
		NavigationTitleValue $navigationTitleValue,
		NavigationView $navigationView
	) {
		$this->attributeQualifier = $attributeQualifier;
		$this->jsonEntityFactory = $jsonEntityFactory;
		$this->navigationTitleValue = $navigationTitleValue;
		$this->navigationView = $navigationView;
	}

	/**
	 * @param string|null $input
	 * @param array $attributes
	 * @param Parser $parser
	 * @return string
	 */
	public function getParserHandler( ?string $input, array $attributes, Parser $parser ) : string {
		$title = $this->navigationTitleValue->getTitleValue( $attributes['title'] );

		$titleFromTitleValue = Title::newFromTitleValue( $title );
		if ( !$titleFromTitleValue->exists() ) {
			return false;
		}

		$content = $this->jsonEntityFactory->newFromTitle( $titleFromTitleValue );

		OutputPage::setupOOUI();
		$parserOutput = $parser->getOutput();
		$this->setPageProperty( $parserOutput, $title );
		$this->loadResourceLoaderModules( $parserOutput );

		$renderedNavigation = $this->navigationView->render( $content );
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
