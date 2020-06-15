<?php

namespace StructuredNavigation\Rest;

use MediaWiki\Rest\SimpleHandler;
use StructuredNavigation\Title\QueryTitlesUsedLookup;
use Wikimedia\ParamValidator\ParamValidator;

/**
 * @license MIT
 */
class NavigationTitlesUsedHandler extends SimpleHandler {
	private QueryTitlesUsedLookup $queryTitlesUsedLookup;

	public function __construct( QueryTitlesUsedLookup $queryTitlesUsedLookup ) {
		$this->queryTitlesUsedLookup = $queryTitlesUsedLookup;
	}

	public function run( string $title ) {
		return $this->queryTitlesUsedLookup->getTitlesUsed( $title );
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
