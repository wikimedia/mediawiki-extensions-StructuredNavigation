<?php

namespace StructuredNavigation\Api;

use ApiBase;
use ApiQuery;
use ApiQueryBase;
use OutputPage;
use StructuredNavigation\Json\JsonEntityFactory;
use StructuredNavigation\View\NavigationView;

/**
 * This API module allows querying for the view of a navigation
 * (by title), as an HTML fragment.
 *
 * @license MIT
 */
final class ApiQueryNavigationHtml extends ApiQueryBase {

	private const PARAM_TITLE = 'title';

	private const PREFIX = 'snqnh';

	/** @var JsonEntityFactory */
	private $jsonEntityFactory;

	/** @var NavigationView */
	private $navigationView;

	/**
	 * @param ApiQuery $apiQuery
	 * @param string $moduleName
	 * @param JsonEntityFactory $jsonEntityFactory
	 * @param NavigationView $navigationView
	 */
	public function __construct(
		ApiQuery $apiQuery,
		string $moduleName,
		JsonEntityFactory $jsonEntityFactory,
		NavigationView $navigationView
	) {
		parent::__construct( $apiQuery, $moduleName, self::PREFIX );
		$this->jsonEntityFactory = $jsonEntityFactory;
		$this->navigationView = $navigationView;
	}

	/**
	 * @inheritDoc
	 */
	public function execute() {
		$params = $this->extractRequestParams();
		$title = $params[self::PARAM_TITLE];

		OutputPage::setupOOUI();
		$this->getResult()->addValue(
			'query',
			$this->getModuleName(),
			[
				$title => $this->navigationView->getView(
					$this->jsonEntityFactory->newFromTitle( $title )
				)
			]
		);
	}

	/**
	 * @inheritDoc
	 */
	public function getAllowedParams() {
		return [
			self::PARAM_TITLE => [
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			],
		];
	}

	/**
	 * @inheritDoc
	 */
	public function isInternal() {
		return true;
	}

}
