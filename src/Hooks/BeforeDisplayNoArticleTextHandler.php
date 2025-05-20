<?php

namespace MediaWiki\Extension\StructuredNavigation\Hooks;

use Article;
use MediaWiki\Extension\StructuredNavigation\View\NavigationNotFoundView;
use MediaWiki\Page\Hook\BeforeDisplayNoArticleTextHook;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforeDisplayNoArticleText
 * @license MIT
 */
final class BeforeDisplayNoArticleTextHandler implements BeforeDisplayNoArticleTextHook {
	private NavigationNotFoundView $notFoundView;

	public function __construct( NavigationNotFoundView $notFoundView ) {
		$this->notFoundView = $notFoundView;
	}

	public static function factory( NavigationNotFoundView $notFoundView ): self {
		return new self( $notFoundView );
	}

	/**
	 * @param Article $article
	 * @return bool
	 */
	public function onBeforeDisplayNoArticleText( $article ) {
		if (
			$article->getPage()->getContentModel()
			!== CONTENT_MODEL_NAVIGATION
		) {
			return true;
		}

		$this->getView( $article );
		return false;
	}

	private function getView( Article $article ): void {
		$context = $article->getContext();
		$output = $context->getOutput();

		$output->enableOOUI();
		$output->addModuleStyles( 'ext.structuredNav.NavigationNotFoundView.styles' );
		$output->addHTML(
			$this->notFoundView->getView(
				$context->getTitle(),
				$context->getUser()
			)
		);
	}
}
