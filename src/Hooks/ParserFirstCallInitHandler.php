<?php

namespace StructuredNavigation\Hooks;

use Error;
use OutputPage;
use Parser;
use ParserOutput;
use StructuredNavigation\AttributeQualifier;
use StructuredNavigation\Json\JsonEntityFactory;
use StructuredNavigation\Title\NavigationTitleValue;
use StructuredNavigation\View\NavigationView;
use Title;

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
		$userPassedTitle = $attributes['title'];
		$title = $this->navigationTitleValue->getTitleValue( $userPassedTitle );

		try {
			$content = $this->jsonEntityFactory->newFromTitle( Title::newFromTitleValue( $title ) );
		} catch ( Error $e ) {
			// The passed title doesn't exist, so it attempts
			// to create a new Content object which ends up
			// being null since there's no actual content.
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
