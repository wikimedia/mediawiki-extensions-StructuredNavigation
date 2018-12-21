<?php

namespace StructuredNavigation;

use Config;
use MediaWiki\MediaWikiServices;

/**
 * @license GPL-2.0-or-later
 */

return [
	'StructuredNavigation.Config' => function ( MediaWikiServices $services ) : Config {
		return $services->getConfigFactory()->makeConfig( 'structurednavigation' );
	},
];
