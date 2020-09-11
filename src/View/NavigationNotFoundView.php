<?php

namespace StructuredNavigation\View;

use SpecialPage;
use StructuredNavigation\Libs\OOUI\View\EmptyStateView;
use Title;
use User;
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
	private const MSG_TITLE = 'structurednav-nav-not-found-title';
	private const MSG_SUMMARY = 'structurednav-nav-not-found-summary';
	private const MSG_BUTTON_LABEL = 'structurednav-nav-not-found-button-label';
	private const MSG_SUMMARY_NOT_LOGGED_IN = 'structurednav-nav-not-found-summary-not-logged-in';
	private const MSG_BUTTON_LABEL_NOT_LOGGED_IN = 'structurednav-nav-not-found-button-label-not-logged-in';

	private string $extensionAssetsPath;
	private ITextFormatter $textFormatter;

	public function __construct(
		string $extensionAssetsPath,
		ITextFormatter $textFormatter
	) {
		$this->extensionAssetsPath = $extensionAssetsPath;
		$this->textFormatter = $textFormatter;
	}

	public function getView( Title $title, User $user ) : EmptyStateView {
		$emptyStateConfig = array_merge(
			[
				'imageSource' => "{$this->extensionAssetsPath}/StructuredNavigation/resources/"
				. "images/structured-navigation.svg",
				'title' => $this->getMessage( self::MSG_TITLE, [ $title->getText() ] ),
			],
			$this->getFlavorTextConfig( $title, $user )
		);

		return new EmptyStateView( $emptyStateConfig );
	}

	private function getFlavorTextConfig( Title $title, User $user ) : array {
		$flavorTextConfig = [
			'summary' => $this->getMessage( self::MSG_SUMMARY ),
			'buttonLabel' => $this->getMessage( self::MSG_BUTTON_LABEL ),
			'buttonHref' => $title->getFullURL( [ 'action' => 'edit', 'redlink' => '1' ] ),
		];

		if ( !$user->isLoggedIn() ) {
			$flavorTextConfig['summary'] = $this->getMessage( self::MSG_SUMMARY_NOT_LOGGED_IN );
			$flavorTextConfig['buttonLabel'] = $this->getMessage( self::MSG_BUTTON_LABEL_NOT_LOGGED_IN );
			$flavorTextConfig['buttonHref'] = SpecialPage::getTitleFor( 'UserLogin' )->getFullURL( [
				// Return to this page when the user logs in
				'returnto' => $title->getFullText(),
				'returntoquery' => wfArrayToCgi( [ 'action' => 'edit' ] )
			] );
		}

		return $flavorTextConfig;
	}

	private function getMessage( string $msg, array $params = [] ) : string {
		return $this->textFormatter->format( new MessageValue( $msg, $params ) );
	}
}
