<?php

namespace StructuredNavigation\Libs\MediaWiki;

use MediaWiki\MediaWikiServices;
use StructuredNavigation\Libs\MediaWiki\Linker\TemplateLinksRenderer;

/**
 * @license GPL-2.0-or-later
 */
return [
	'MediaWiki.Libs.TemplateLinksRenderer' => function ( MediaWikiServices $services ) : TemplateLinksRenderer {
		return new TemplateLinksRenderer( $services->getLinkRenderer() );
	}
];
