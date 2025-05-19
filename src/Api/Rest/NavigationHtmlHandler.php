<?php

namespace MediaWiki\Extension\StructuredNavigation\Api\Rest;

use MediaWiki\Extension\StructuredNavigation\View\NavigationViewPresenter;
use MediaWiki\Rest\SimpleHandler;
use Wikimedia\ParamValidator\ParamValidator;

/**
 * @license MIT
 */
class NavigationHtmlHandler extends SimpleHandler {
	use NavigationRESTEnabledTrait;

	private NavigationViewPresenter $navigationViewPresenter;

	public function __construct( NavigationViewPresenter $navigationViewPresenter ) {
		$this->navigationViewPresenter = $navigationViewPresenter;
	}

	public function run( string $title ) {
		$this->showErrorIfDisabled();

		return $this->navigationViewPresenter->getFromTitle( $title );
	}

	/** @inheritDoc */
	public function needsWriteAccess(): bool {
		return false;
	}

	/** @inheritDoc */
	public function getParamSettings(): array {
		return [
			'title' => [
				self::PARAM_SOURCE => 'path',
				ParamValidator::PARAM_TYPE => 'string',
				ParamValidator::PARAM_REQUIRED => true,
			],
		];
	}
}
