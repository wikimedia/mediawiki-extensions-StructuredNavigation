<?php

namespace StructuredNavigation\Json;

use WikiPage;
use Title;

/**
 * @license GPL-2.0-or-later
 */
class JsonEntityFactory {

	/**
	 * @param Title $title
	 * @return JsonEntity
	 */
	public function newFromTitle( Title $title ) : JsonEntity {
		return new JsonEntity(
			WikiPage::factory( $title )->getContent()->getJsonData()
		);
	}

}
