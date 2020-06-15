<?php

namespace StructuredNavigation\Api\Rest;

use MediaWiki\Rest\SimpleHandler;
use StructuredNavigation\NavigationFactory;
use Wikimedia\ParamValidator\ParamValidator;

/**
 * @license MIT
 */
class NavigationTitlesUsedHandler extends SimpleHandler {
	private NavigationFactory $navigationFactory;

	public function __construct( NavigationFactory $navigationFactory ) {
		$this->navigationFactory = $navigationFactory;
	}

	public function run( string $title ) {
		return $this->navigationFactory->newFromTitle( $title )->getAllLinks();
	}

	/** @inheritDoc */
	public function needsWriteAccess() : bool {
		return false;
	}

	/** @inheritDoc */
	public function getParamSettings() : array {
		return [
			'title' => [
				self::PARAM_SOURCE => 'path',
				ParamValidator::PARAM_TYPE => 'string',
				ParamValidator::PARAM_REQUIRED => true,
			],
		];
	}
}
