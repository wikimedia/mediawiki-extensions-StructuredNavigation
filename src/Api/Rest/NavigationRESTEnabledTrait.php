<?php

namespace StructuredNavigation\Api\Rest;

use MediaWiki\Rest\LocalizedHttpException;
use StructuredNavigation\Services\Services;
use Wikimedia\Message\MessageValue;

/**
 * @internal
 * @license MIT
 */
trait NavigationRESTEnabledTrait {
	public function showErrorIfDisabled() {
		$isApiEnabled = Services::getInstance()->getConfig()
			->get( 'EnableExperimentalAPI' );

		if ( !$isApiEnabled ) {
			throw new LocalizedHttpException(
				new MessageValue( 'structurednavigation-rest-api-not-enabled' ),
				403
			);
		}
	}
}
