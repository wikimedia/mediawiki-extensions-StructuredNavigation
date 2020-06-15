<?php

namespace StructuredNavigation\Specials;

use FormSpecialPage;
use HTMLForm;
use HTMLTitleTextField;
use StructuredNavigation\Libs\MediaWiki\NamespacedTitleSearcher;
use StructuredNavigation\Libs\OOUI\Element\UnorderedList;
use StructuredNavigation\Title\NavigationTitleValue;
use StructuredNavigation\NavigationFactory;

/**
 * This special page allows looking up all the titles used for
 * a given navigation by name.
 *
 * @license MIT
 */
final class TitlesUsedInNavigation extends FormSpecialPage {
	private const FIELD_TITLE = 'title';
	private const MESSAGE_LEGEND = 'specials-titlesusedinnavigation-legend';
	private const MESSAGE_TITLE_LABEL = 'specials-titlesusedinnavigation-field-title-label';
	private const MESSAGE_TITLE_PLACEHOLDER = 'specials-titlesusedinnavigation-field-title-placeholder';
	private const PAGE_NAME = 'TitlesUsedInNavigation';

	private NavigationFactory $navigationFactory;
	private NamespacedTitleSearcher $namespacedTitleSearcher;
	private NavigationTitleValue $navigationTitleValue;

	public function __construct(
		NavigationFactory $navigationFactory,
		NamespacedTitleSearcher $namespacedTitleSearcher,
		NavigationTitleValue $navigationTitleValue
	) {
		parent::__construct( self::PAGE_NAME );

		$this->navigationFactory = $navigationFactory;
		$this->namespacedTitleSearcher = $namespacedTitleSearcher;
		$this->navigationTitleValue = $navigationTitleValue;
	}

	/** @inheritDoc */
	protected function getGroupName() {
		return Constants::SPECIAL_PAGE_GROUP;
	}

	/** @inheritDoc */
	public function alterForm( HTMLForm $htmlForm ) {
		$htmlForm
			->setWrapperLegendMsg( $this->msg( self::MESSAGE_LEGEND ) );
	}

	/** @inheritDoc */
	protected function getDisplayFormat() {
		return Constants::HTMLFORM_FORMAT_OOUI;
	}

	/** @inheritDoc */
	public function onSubmit( array $formData, $htmlForm = null ) {
		$htmlForm->setPostText(
			$this->getTitleList( $formData[self::FIELD_TITLE] )
		);
	}

	/** @inheritDoc */
	protected function getFormFields() {
		return [
			self::FIELD_TITLE => [
				'class' => HTMLTitleTextField::class,
				'default' => $this->par ?
					$this->navigationTitleValue
						->getTitleValue( $this->par )
						->getText() : '',
				'label-message' => self::MESSAGE_TITLE_LABEL,
				'placeholder-message' => self::MESSAGE_TITLE_PLACEHOLDER,
				'namespace' => NS_NAVIGATION,
				'exists' => true,
				'relative' => true,
				'creatable' => true
			],
		];
	}

	/** @inheritDoc */
	public function prefixSearchSubpages( $search, $limit, $offset ) {
		return $this->namespacedTitleSearcher
			->getTitlesInNamespace( $search, $limit, $offset, NS_NAVIGATION );
	}

	private function getTitleList( string $title ) : UnorderedList {
		return new UnorderedList( [
			'items' => $this->navigationFactory->newFromTitle( $title )->getAllLinks()
		] );
	}
}
