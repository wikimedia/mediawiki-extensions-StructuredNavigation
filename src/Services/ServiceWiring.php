<?php

namespace StructuredNavigation\Services;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\AttributeQualifier;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Json\DocumentationContent;
use StructuredNavigation\Json\JsonEntityFactory;
use StructuredNavigation\Libs\MediaWiki\NamespacedTitleSearcher;
use StructuredNavigation\Title\NavigationTitleValue;
use StructuredNavigation\Title\QueryTitlesUsedLookup;
use StructuredNavigation\View\ContentLinkView;
use StructuredNavigation\View\NavigationView;
use StructuredNavigation\View\NavigationViewPresenter;

/**
 * @license MIT
 */

return [
	Constants::SERVICE_CONFIG => function ( MediaWikiServices $services ) : Config {
		return $services->getConfigFactory()->makeConfig( Constants::CONFIG_NAME );
	},

	Constants::SERVICE_CONTENT_LINK_VIEW => function ( MediaWikiServices $services ) : ContentLinkView {
		return new ContentLinkView(
			$services->getLinkRenderer(),
			$services->getTitleParser()
		);
	},

	Constants::SERVICE_JSON_ENTITY_FACTORY => function ( MediaWikiServices $services ) : JsonEntityFactory {
		return new JsonEntityFactory(
			( new Services( $services ) )->getNavigationTitleValue()
		);
	},

	Constants::SERVICE_NAMESPACED_TITLE_SEARCHER => function ( MediaWikiServices $services ) : NamespacedTitleSearcher {
		return new NamespacedTitleSearcher( $services->newSearchEngine() );
	},

	Constants::SERVICE_NAVIGATION_TITLE_VALUE => function ( MediaWikiServices $services ) : NavigationTitleValue {
		return new NavigationTitleValue( $services->getTitleParser() );
	},

	Constants::SERVICE_NAVIGATION_VIEW => function ( MediaWikiServices $services ) : NavigationView {
		return new NavigationView(
			( new Services( $services ) )->getContentLinkView()
		);
	},

	Constants::SERVICE_NAVIGATION_VIEW_PRESENTER => function ( MediaWikiServices $services ) : NavigationViewPresenter {
		$wrapper = new Services( $services );

		return new NavigationViewPresenter(
			$wrapper->getJsonEntityFactory(),
			$wrapper->getNavigationView()
		);
	},

	Constants::SERVICE_PARSERFIRSTCALLINIT_HANDLER => function ( MediaWikiServices $services ) : ParserFirstCallInitHandler {
		return new ParserFirstCallInitHandler(
			new AttributeQualifier(),
			( new Services( $services ) )->getNavigationViewPresenter()
		);
	},

	Constants::SERVICE_QUERY_TITLES_USED_LOOKUP => function ( MediaWikiServices $services ) : QueryTitlesUsedLookup {
		return new QueryTitlesUsedLookup(
			( new Services( $services ) )->getJsonEntityFactory()
		);
	},

	Constants::SERVICE_DOCUMENTATION_CONTENT => function ( MediaWikiServices $services ) : DocumentationContent {
		return new DocumentationContent(
			$services->getMainConfig()->get( 'ExtensionDirectory' )
		);
	},

];
