<?php

namespace StructuredNavigation\View;

use StructuredNavigation\Libs\OOUI\View\EmptyStateView;
use Title;
use Wikimedia\Message\ITextFormatter;
use Wikimedia\Message\MessageValue;

/**
 * Represents an empty state screen for when a user visits a navigation
 * that doesn't exist. It prompts the user with an action to create
 * a new navigation with the given title.
 *
 * @license MIT
 */
final class NavigationNotFoundView {
	private const MESSAGE_TITLE = 'structurednav-nav-not-found-title';
	private const MESSAGE_SUMMARY = 'structurednav-nav-not-found-summary';
	private const MESSAGE_BUTTON_LABEL = 'structurednav-nav-not-found-button-label';

	private string $extensionAssetsPath;
	private ITextFormatter $textFormatter;

	public function __construct(
		string $extensionAssetsPath,
		ITextFormatter $textFormatter
	) {
		$this->extensionAssetsPath = $extensionAssetsPath;
		$this->textFormatter = $textFormatter;
	}

	public function getView( Title $title ) : EmptyStateView {
		return new EmptyStateView( [
			'imageSource' => "{$this->extensionAssetsPath}/StructuredNavigation/resources/"
				. "images/structured-navigation.svg",
			'title' => $this->getMessage( self::MESSAGE_TITLE ),
			'summary' => $this->getMessage( self::MESSAGE_SUMMARY ),
			'buttonLabel' => $this->getMessage( self::MESSAGE_BUTTON_LABEL ),
			'buttonHref' => $title->getFullURL( [ 'action' => 'edit', 'redlink' => '1' ] ),
		] );
	}

	private function getMessage( string $msg ) : string {
		return $this->textFormatter->format( new MessageValue( $msg ) );
	}
}
