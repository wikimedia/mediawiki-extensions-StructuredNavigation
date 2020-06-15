<?php

namespace StructuredNavigation\Rest;

use MediaWiki\Rest\SimpleHandler;
use RequestContext;
use StructuredNavigation\View\NavigationViewPresenter;
use Wikimedia\ParamValidator\ParamValidator;

/**
 * @license MIT
 */
class NavigationHtmlHandler extends SimpleHandler {
	private NavigationViewPresenter $navigationViewPresenter;

	public function __construct( NavigationViewPresenter $navigationViewPresenter ) {
		$this->navigationViewPresenter = $navigationViewPresenter;
	}

	public function run( string $title ) {
		return $this->navigationViewPresenter->getFromTitle(
			// should inject RC somehow, or refactor NavigationViewPresenter
			RequestContext::getMain()->getOutput(), 
			$title
		)->toString();
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
