<?php

namespace StructuredNavigation\Hooks;

use Article;
use StructuredNavigation\View\EmptyStateView;

/**
 * @license GPL-2.0-or-later
 */
class BeforeDisplayNoArticleTextHandler {

	/** @var string */
	private const RESOURCELOADER_MODULE = 'ext.structurednavigation.view.emptystate.styles';

	/** @var Article */
	private $article;

	/**
	 * @param Article $article
	 */
	public function __construct( Article $article ) {
		$this->article = $article;
	}

	/**
	 * @return bool
	 */
	public function getHandler() : bool {
		if ( $this->article->getPage()->getContentModel() !== CONTENT_MODEL_NAVIGATION ) {
			return true;
		}

		$this->getView();

		return false;
	}

	/**
	 * @return void
	 */
	private function getView() : void {
		$context = $this->article->getContext();
		$output = $context->getOutput();

		$output->enableOOUI();
		$output->addModuleStyles( self::RESOURCELOADER_MODULE );
		$output->addHTML(
			( new EmptyStateView(
				$context->getConfig()->get( 'ExtensionAssetsPath' ),
				$context,
				$this->article->getTitle()
			) )->getView()
		);
	}

}
