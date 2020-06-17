<?php

namespace StructuredNavigation\Hooks;

use Article;
use StructuredNavigation\Services\Services;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforeDisplayNoArticleText
 * @license MIT
 */
final class BeforeDisplayNoArticleTextHandler {
	private Article $article;

	public function __construct( Article $article ) {
		$this->article = $article;
	}

	public function getHandler() : bool {
		if (
			$this->article->getPage()->getContentModel()
			!== CONTENT_MODEL_NAVIGATION
		) {
			return true;
		}

		$this->getView();
		return false;
	}

	private function getView() : void {
		$context = $this->article->getContext();
		$output = $context->getOutput();

		$output->enableOOUI();
		$output->addModuleStyles( 'ext.structuredNav.NavigationNotFoundView.styles' );
		$output->addHTML(
			Services::getInstance()
				->getNavigationNotFoundView()
				->getView( $this->article->getTitle() )
		);
	}
}
