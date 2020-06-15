<?php

namespace StructuredNavigation\Api\Action;

use ApiBase;
use ApiQuery;
use ApiQueryBase;
use StructuredNavigation\View\NavigationViewPresenter;

/**
 * This API module allows querying for the view of a navigation
 * (by title), as an HTML fragment.
 *
 * @license MIT
 */
final class ApiQueryNavigationHtml extends ApiQueryBase {
	private const PARAM_TITLE = 'title';
	private const PREFIX = 'snqnh';

	private NavigationViewPresenter $navigationViewPresenter;

	/** @inheritDoc */
	public function __construct(
		ApiQuery $apiQuery,
		string $moduleName,
		NavigationViewPresenter $navigationViewPresenter
	) {
		parent::__construct( $apiQuery, $moduleName, self::PREFIX );
		$this->navigationViewPresenter = $navigationViewPresenter;
	}

	/** @inheritDoc */
	public function execute() {
		$params = $this->extractRequestParams();
		$title = $params[self::PARAM_TITLE];

		$this->getResult()->addValue(
			'query',
			$this->getModuleName(),
			[
				$title => $this->navigationViewPresenter->getFromTitle( $title )
			]
		);
	}

	/** @inheritDoc */
	public function getAllowedParams() {
		return [
			self::PARAM_TITLE => [
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			],
		];
	}

	/** @inheritDoc */
	public function isInternal() {
		return true;
	}

	/** @inheritDoc */
	public function getExamplesMessages() {
		return [
			"action=query&prop={$this->getModuleName()}&snqnhtitle=Dontnod_Entertainment"
				=> 'apihelp-query+structurednavigationnavigationhtml-example',
		];
	}
}
