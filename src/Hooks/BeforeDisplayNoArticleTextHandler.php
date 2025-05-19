<?php

namespace StructuredNavigation\Hooks;

use Article;
use MediaWiki\Page\Hook\BeforeDisplayNoArticleTextHook;
use StructuredNavigation\Services\Services;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforeDisplayNoArticleText
 * @license MIT
 */
final class BeforeDisplayNoArticleTextHandler implements BeforeDisplayNoArticleTextHook {
	/**
	 * @param Article $article
	 * @return bool
	 */
	public function onBeforeDisplayNoArticleText( $article ) {
		return ( new self() )->getHandler( $article );
	}

	public function getHandler( Article $article ): bool {
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
			Services::getInstance()
				->getNavigationNotFoundView()
				->getView( $context->getTitle(), $context->getUser() )
		);
	}
}
