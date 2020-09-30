<?php

namespace StructuredNavigation\Api\Rest;

use MediaWiki\Rest\SimpleHandler;
use StructuredNavigation\NavigationFactory;
use Wikimedia\ParamValidator\ParamValidator;

/**
 * @license MIT
 */
class NavigationDataHandler extends SimpleHandler {
	use NavigationRESTEnabledTrait;

	private NavigationFactory $navigationFactory;

	public function __construct( NavigationFactory $navigationFactory ) {
		$this->navigationFactory = $navigationFactory;
	}

	public function run( string $title ) {
		$this->showErrorIfDisabled();

		return $this->navigationFactory->newFromTitle( $title )->getContent();
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
