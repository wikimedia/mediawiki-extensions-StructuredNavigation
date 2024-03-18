<?php

namespace StructuredNavigation\Services;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\DocumentationContent;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Libs\MediaWiki\NamespacedTitleSearcher;
use StructuredNavigation\NavigationFactory;
use StructuredNavigation\Schema\NavigationSchemaValidator;
use StructuredNavigation\View\NavigationNotFoundView;
use StructuredNavigation\View\NavigationView;
use StructuredNavigation\View\NavigationViewPresenter;
use TemplateParser;

/**
 * @license MIT
 */
return [
	'StructuredNavigation.Config'
		=> static function ( MediaWikiServices $services ): Config {
			return $services->getConfigFactory()->makeConfig( 'structurednavigation' );
		},

	'StructuredNavigation.NavigationFactory'
		=> static function ( MediaWikiServices $services ): NavigationFactory {
			return new NavigationFactory(
				$services->getRevisionLookup(),
				$services->getTitleParser()
			);
		},

	'StructuredNavigation.NamespacedTitleSearcher'
		=> static function ( MediaWikiServices $services ): NamespacedTitleSearcher {
			return new NamespacedTitleSearcher( $services->newSearchEngine() );
		},

	'StructuredNavigation.NavigationView'
		=> static function ( MediaWikiServices $services ): NavigationView {
			return new NavigationView(
				$services->getLinkRenderer(),
				new TemplateParser(
					$services->getMainConfig()->get( 'ExtensionDirectory' )
					. '/StructuredNavigation/templates'
				)
			);
		},

	'StructuredNavigation.NavigationNotFoundView'
		=> static function ( MediaWikiServices $services ): NavigationNotFoundView {
			$mainConfig = $services->getMainConfig();
			return new NavigationNotFoundView(
				$mainConfig->get( 'ExtensionAssetsPath' ),
				$services->getMessageFormatterFactory()->getTextFormatter(
					$mainConfig->get( 'LanguageCode' )
				)
			);
		},

	'StructuredNavigation.NavigationViewPresenter'
		=> static function ( MediaWikiServices $services ): NavigationViewPresenter {
			$wrapper = new Services( $services );

			return new NavigationViewPresenter(
				$wrapper->getNavigationFactory(),
				$wrapper->getNavigationView()
			);
		},

	'StructuredNavigation.ParserFirstCallInitHandler'
		=> static function ( MediaWikiServices $services ): ParserFirstCallInitHandler {
			return new ParserFirstCallInitHandler(
				( new Services( $services ) )->getNavigationViewPresenter()
			);
		},

	'StructuredNavigation.DocumentationContent'
		=> static function ( MediaWikiServices $services ): DocumentationContent {
			return new DocumentationContent(
				$services->getMainConfig()->get( 'ExtensionDirectory' )
			);
		},

	'StructuredNavigation.SchemaValidator'
		=> static function ( MediaWikiServices $services ): NavigationSchemaValidator {
			return new NavigationSchemaValidator(
				$services->getMainConfig()->get( 'ExtensionDirectory' )
			);
		}
];
