<?php

namespace StructuredNavigation\Services;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\AttributeQualifier;
use StructuredNavigation\DocumentationContent;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Libs\MediaWiki\NamespacedTitleSearcher;
use StructuredNavigation\NavigationFactory;
use StructuredNavigation\Title\NavigationTitleValue;
use StructuredNavigation\Title\QueryTitlesUsedLookup;
use StructuredNavigation\View\NavigationView;
use StructuredNavigation\View\NavigationViewPresenter;

/**
 * @license MIT
 */
return [
	'StructuredNavigation.Config'
		=> function ( MediaWikiServices $services ) : Config {
		return $services->getConfigFactory()->makeConfig( 'structurednavigation' );
		},

	'StructuredNavigation.NavigationFactory'
		=> function ( MediaWikiServices $services ) : NavigationFactory {
		return new NavigationFactory(
			$services->getTitleParser(),
			( new Services( $services ) )->getNavigationTitleValue()
		);
		},

	'StructuredNavigation.NamespacedTitleSearcher'
		=> function ( MediaWikiServices $services ) : NamespacedTitleSearcher {
		return new NamespacedTitleSearcher( $services->newSearchEngine() );
		},

	'StructuredNavigation.NavigationTitleValue'
		=> function ( MediaWikiServices $services ) : NavigationTitleValue {
		return new NavigationTitleValue( $services->getTitleParser() );
		},

	'StructuredNavigation.NavigationView'
		=> function ( MediaWikiServices $services ) : NavigationView {
		return new NavigationView(
			$services->getLinkRenderer()
		);
		},

	'StructuredNavigation.NavigationViewPresenter'
		=> function ( MediaWikiServices $services ) : NavigationViewPresenter {
		$wrapper = new Services( $services );

		return new NavigationViewPresenter(
			$wrapper->getNavigationFactory(),
			$wrapper->getNavigationView()
		);
		},

	'StructuredNavigation.ParserFirstCallInitHandler'
		=> function ( MediaWikiServices $services ) : ParserFirstCallInitHandler {
		return new ParserFirstCallInitHandler(
			new AttributeQualifier(),
			( new Services( $services ) )->getNavigationViewPresenter()
		);
		},

	'StructuredNavigation.QueryTitlesUsedLookup'
		=> function ( MediaWikiServices $services ) : QueryTitlesUsedLookup {
		return new QueryTitlesUsedLookup(
			( new Services( $services ) )->getNavigationFactory()
		);
		},

	'StructuredNavigation.DocumentationContent'
		=> function ( MediaWikiServices $services ) : DocumentationContent {
		return new DocumentationContent(
			$services->getMainConfig()->get( 'ExtensionDirectory' )
		);
		},
];
