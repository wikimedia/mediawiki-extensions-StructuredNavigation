<?php

namespace StructuredNavigation\Json;

use WikiPage;
use Title;

/**
 * @license MIT
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
