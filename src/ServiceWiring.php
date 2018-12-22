<?php

namespace StructuredNavigation;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\Renderer\TableRenderer;

/**
 * @license GPL-2.0-or-later
 */

return [
	Constants::SERVICE_CONFIG => function ( MediaWikiServices $services ) : Config {
		return $services->getConfigFactory()->makeConfig( 'structurednavigation' );
	},

	Constants::SERVICE_TABLE_RENDERER => function ( MediaWikiServices $services ) : TableRenderer {
		return new TableRenderer(
			$services->getLinkRenderer(),
			$services->getTitleParser()
		);
	},
];
