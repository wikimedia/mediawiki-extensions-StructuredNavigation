<?php

namespace StructuredNavigation\View;

use MessageLocalizer;
use StructuredNavigation\Libs\OOUI\View\EmptyStateView;
use Title;

/**
 * Represents an empty state screen for when a user visits a navigation
 * that doesn't exist. It prompts the user with an action to create
 * a new navigation with the given title.
 *
 * @license MIT
 */
final class NonExistentView {

	private const MESSAGE_TITLE = 'structurednavigation-view-emptystate-title';
	private const MESSAGE_SUMMARY = 'structurednavigation-view-emptystate-summary';
	private const MESSAGE_BUTTON_LABEL = 'structurednavigation-view-emptystate-button-label';

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
	 * @return EmptyStateView
	 */
	public function getView() : EmptyStateView {
		return new EmptyStateView( [
			'imageSource' => "{$this->extensionAssetsPath}/StructuredNavigation/resources/"
				. "images/structured-navigation.svg",
			'title' => $this->getMessage( self::MESSAGE_TITLE ),
			'summary' => $this->getMessage( self::MESSAGE_SUMMARY ),
			'buttonLabel' => $this->getMessage( self::MESSAGE_BUTTON_LABEL ),
			'buttonHref' => $this->title->getFullURL( [ 'action' => 'edit', 'redlink' => '1' ] ),
		] );
	}

	/**
	 * @return string
	 */
	private function getMessage( string $msg ) : string {
		return $this->messageLocalizer->msg( $msg )->plain();
	}

}
