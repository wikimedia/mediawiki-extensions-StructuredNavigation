<?php

namespace StructuredNavigation\View;

use MediaWiki\Linker\LinkRenderer;
use StructuredNavigation\Navigation;
use TemplateParser;

class NavigationView {
	private const TEMPLATE_NAME = 'Navigation';
	private const PARAM_TITLE_LABEL = 'title_label';
	private const PARAM_GROUPS = 'groups';
	private const PARAM_GROUP_LABEL = "group_label";
	private const PARAM_LINKS = "links";
	private const PARAM_LINK = "link";

	private LinkRenderer $linkRenderer;
	private TemplateParser $templateParser;

	public function __construct(
		LinkRenderer $linkRenderer,
		TemplateParser $templateParser
	) {
		$this->linkRenderer = $linkRenderer;
		$this->templateParser = $templateParser;
	}

	public function getView( Navigation $navigation ) : string {
		$groups = [];
		foreach( $navigation->getGroups() as $group ) {
			$links = [];
			foreach ( $group->getLinks() as $link ) {
				$links[] = [ self::PARAM_LINK =>
					$this->linkRenderer->makeLink(
						$link->getTitleValue(),
						$link->getLabel(),
						[ 'class' => 'mw-structurednav-group-content-link' ]
					)
				];
			}

			$groups[] = [
				self::PARAM_GROUP_LABEL => $group->getLabel(),
				self::PARAM_LINKS => $links
			];
		}

		return $this->templateParser->processTemplate(
			self::TEMPLATE_NAME,
			[
				self::PARAM_TITLE_LABEL => $navigation->getTitleLabel(),
				self::PARAM_GROUPS => $groups
			]
		);
	}
}
