<?php

namespace StructuredNavigation\Services;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\AttributeQualifier;
use StructuredNavigation\Hooks\ParserFirstCallInitHandler;
use StructuredNavigation\Renderer\NavigationRenderer;

/**
 * @license GPL-2.0-or-later
 */

return [
	Constants::SERVICE_CONFIG => function ( MediaWikiServices $services ) : Config {
		return $services->getConfigFactory()->makeConfig( Constants::CONFIG_NAME );
	},

	Constants::SERVICE_NAVIGATION_RENDERER => function ( MediaWikiServices $services ) : NavigationRenderer {
		return new NavigationRenderer(
			$services->getLinkRenderer(),
			$services->getTitleParser()
		);
	},

	Constants::SERVICE_PARSERFIRSTCALLINIT_HANDLER => function ( MediaWikiServices $services ) : ParserFirstCallInitHandler {
		return new ParserFirstCallInitHandler(
			new AttributeQualifier(),
			$services->getService( Constants::SERVICE_NAVIGATION_RENDERER ),
			$services->getTitleParser()
		);
	}
];
