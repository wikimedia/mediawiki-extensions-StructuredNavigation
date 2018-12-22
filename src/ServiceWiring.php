<?php

namespace StructuredNavigation;

use Config;
use MediaWiki\MediaWikiServices;
use StructuredNavigation\Renderer\TableRenderer;

/**
 * @license GPL-2.0-or-later
 */

return [
	'StructuredNavigation.Config' => function ( MediaWikiServices $services ) : Config {
		return $services->getConfigFactory()->makeConfig( 'structurednavigation' );
	},

	'StructuredNavigation.TableRenderer' => function ( MediaWikiServices $services ) : TableRenderer {
		return new TableRenderer(
			$services->getLinkRenderer(),
			$services->getTitleParser()
		);
	},
];
