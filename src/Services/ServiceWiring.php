<?php

namespace StructuredNavigation\Services;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\AttributeQualifier;
use StructuredNavigation\NavigationLinkRenderer;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Json\JsonEntityFactory;
use StructuredNavigation\Title\NavigationTitleValue;
use StructuredNavigation\View\NavigationView;

/**
 * @license MIT
 */

return [
	Constants::SERVICE_CONFIG => function ( MediaWikiServices $services ) : Config {
		return $services->getConfigFactory()->makeConfig( Constants::CONFIG_NAME );
	},

	Constants::SERVICE_NAVIGATION_LINK_RENDERER => function ( MediaWikiServices $services ) : NavigationLinkRenderer {
		return new NavigationLinkRenderer(
			$services->getLinkRenderer(),
			$services->getTitleParser()
		);
	},

	Constants::SERVICE_NAVIGATION_TITLE_VALUE => function ( MediaWikiServices $services ) : NavigationTitleValue {
		return new NavigationTitleValue( $services->getTitleParser() );
	},

	Constants::SERVICE_NAVIGATION_VIEW => function ( MediaWikiServices $services ) : NavigationView {
		return new NavigationView(
			( new Services( $services ) )->getNavigationLinkRenderer()
		);
	},

	Constants::SERVICE_PARSERFIRSTCALLINIT_HANDLER => function ( MediaWikiServices $services ) : ParserFirstCallInitHandler {
		$wrapper = new Services( $services );

		return new ParserFirstCallInitHandler(
			new AttributeQualifier(),
			new JsonEntityFactory(),
			$wrapper->getNavigationTitleValue(),
			$wrapper->getNavigationView()
		);
	},
];
