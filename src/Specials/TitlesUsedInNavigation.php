<?php

namespace StructuredNavigation\Specials;

use HTMLForm;
use HTMLTitleTextField;
use SpecialPage;
use StructuredNavigation\Libs\OOUI\Element\UnorderedList;
use StructuredNavigation\Title\QueryTitlesUsedLookup;

/**
 * @license MIT
 */
final class TitlesUsedInNavigation extends SpecialPage {

	private const FIELD_TITLE = 'title';

	private const MESSAGE_LEGEND = 'specials-titlesusedinnavigation-legend';

	private const MESSAGE_TITLE_LABEL = 'specials-titlesusedinnavigation-field-title-label';

	private const MESSAGE_TITLE_PLACEHOLDER = 'specials-titlesusedinnavigation-field-title-placeholder';

	private const PAGE_NAME = 'TitlesUsedInNavigation';

	/** @var QueryTitlesUsedLookup */
	private $queryTitlesUsedLookup;

	/**
	 * @param QueryTitlesUsedLookup $queryTitlesUsedLookup
	 */
	public function __construct( QueryTitlesUsedLookup $queryTitlesUsedLookup ) {
		parent::__construct( self::PAGE_NAME );

		$this->queryTitlesUsedLookup = $queryTitlesUsedLookup;
	}

	/**
	 * @inheritDoc
	 */
	protected function getGroupName() {
		return Constants::SPECIAL_PAGE_GROUP;
	}

	/**
	 * @param string|null $subPage
	 */
	public function execute( $subPage ) {
		$this->setHeaders();

		$htmlForm = HTMLForm::factory( 'ooui', $this->getFormFields(), $this->getContext() )
			->setWrapperLegendMsg( $this->msg( self::MESSAGE_LEGEND ) )
			->setSubmitCallback( [ $this, 'onSubmitCallback' ] )
			->show();
	}

	/**
	 * @param array $formData
	 * @return false|void
	 */
	public function onSubmitCallback( array $formData ) {
		$this->getOutput()->addHTML(
			$this->getTitleList( $formData[self::FIELD_TITLE] )
		);
	}

	/**
	 * @return array
	 */
	private function getFormFields() : array {
		return [
			self::FIELD_TITLE => [
				'class' => HTMLTitleTextField::class,
				'default' => '',
				'label-message' => self::MESSAGE_TITLE_LABEL,
				'placeholder-message' => self::MESSAGE_TITLE_PLACEHOLDER,
				'namespace' => NS_NAVIGATION,
				'exists' => true,
				'relative' => true,
				'creatable' => true
			],
		];
	}

	/**
	 * @param string $title
	 * @return UnorderedList
	 */
	private function getTitleList( string $title ) : UnorderedList {
		return new UnorderedList( [
			'items' => $this->queryTitlesUsedLookup
				->getTitlesUsed( $title )
		] );
	}
}
