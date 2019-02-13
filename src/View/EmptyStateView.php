<?php

namespace StructuredNavigation\View;

use MessageLocalizer;
use OOUI\ButtonWidget;
use OOUI\PanelLayout;
use OOUI\Tag;
use Title;

/**
 * @license GPL-2.0-or-later
 */
final class EmptyStateView {

	/** @var string */
	private const MESSAGE_TITLE = 'structurednavigation-view-emptystate-title';

	/** @var string */
	private const MESSAGE_SUMMARY = 'structurednavigation-view-emptystate-summary';

	/** @var string */
	private const MESSAGE_BUTTON_LABEL = 'structurednavigation-view-emptystate-button-label';

	/** @var array */
	private const CSS_CLASS = [
		'view-container' => 'mw-structurednav-view-emptystate-container',
		'view-illustration' => 'mw-structurednav-view-emptystate-illustration',
		'view-title' => 'mw-structurednav-view-emptystate-title',
		'view-summary' => 'mw-structurednav-view-emptystate-summary',
		'view-action' => 'mw-structurednav-view-emptystate-action'
	];

	/** @var string */
	private $extensionAssetsPath;

	/** @var MessageLocalizer */
	private $messageLocalizer;

	/** @var Title */
	private $title;

	/**
	 * @param string $extensionAssetsPath
	 * @param MessageLocalizer $messageLocalizer
	 * @param Title $title
	 */
	public function __construct(
		string $extensionAssetsPath,
		MessageLocalizer $messageLocalizer,
		Title $title
	) {
		$this->extensionAssetsPath = $extensionAssetsPath;
		$this->messageLocalizer = $messageLocalizer;
		$this->title = $title;
	}

	/**
	 * @return PanelLayout
	 */
	public function getView() : PanelLayout {
		return new PanelLayout( [
			'expanded' => false,
			'framed' => false,
			'classes' => [ self::CSS_CLASS['view-container'] ],
			'content' => [
				$this->getIllustration(),
				$this->getTitle(),
				$this->getSummary(),
				$this->getAction()
			],
		] );
	}

	/**
	 * @return Tag
	 */
	private function getIllustration() : Tag {
		return ( new Tag( 'img' ) )
			->addClasses( [ self::CSS_CLASS['view-illustration'] ] )
			->setAttributes( [
				'src' => "{$this->extensionAssetsPath}/StructuredNavigation/resources/"
					. "images/illustration-grayscale.png"
			] );
	}

	/**
	 * @return Tag
	 */
	private function getTitle() : Tag {
		return ( new Tag( 'h3' ) )
			->addClasses( [ self::CSS_CLASS['view-title'] ] )
			->appendContent(
				$this->messageLocalizer->msg( self::MESSAGE_TITLE )->plain()
			);
	}

	/**
	 * @return Tag
	 */
	private function getSummary() : Tag {
		return ( new Tag( 'div' ) )
			->addClasses( [ self::CSS_CLASS['view-summary'] ] )
			->appendContent(
				$this->messageLocalizer->msg( self::MESSAGE_SUMMARY )->plain()
			);
	}

	/**
	 * @return ButtonWidget
	 */
	private function getAction() : ButtonWidget {
		return new ButtonWidget( [
			'label' => $this->messageLocalizer->msg( self::MESSAGE_BUTTON_LABEL )->plain(),
			'href' => $this->title->getFullURL( [ 'action' => 'edit', 'redlink' => '1' ] ),
			'flags' => [ 'primary', 'progressive' ],
			'classes' => [ self::CSS_CLASS['view-action'] ]
		] );
	}

}
