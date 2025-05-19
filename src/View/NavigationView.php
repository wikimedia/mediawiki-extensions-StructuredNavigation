<?php

namespace MediaWiki\Extension\StructuredNavigation\View;

use MediaWiki\Extension\StructuredNavigation\Navigation;
use MediaWiki\Extension\StructuredNavigation\NavigationGroupLink;
use MediaWiki\Html\TemplateParser;
use MediaWiki\Linker\LinkRenderer;

class NavigationView {
	private const TEMPLATE_NAME = 'Navigation';
	private const PARAM_TITLE_LABEL = 'title_label';
	private const PARAM_GROUPS = 'groups';
	private const PARAM_GROUP_LABEL = 'group_label';
	private const PARAM_LINKS = 'links';
	private const PARAM_LINK = 'link';

	private LinkRenderer $linkRenderer;
	private TemplateParser $templateParser;

	public function __construct(
		LinkRenderer $linkRenderer,
		TemplateParser $templateParser
	) {
		$this->linkRenderer = $linkRenderer;
		$this->templateParser = $templateParser;
	}

	public function getView( Navigation $navigation ): string {
		return $this->templateParser->processTemplate(
			self::TEMPLATE_NAME,
			[
				self::PARAM_TITLE_LABEL => $navigation->getTitleLabel(),
				self::PARAM_GROUPS => $this->getGroups( $navigation )
			]
		);
	}

	private function getGroups( Navigation $navigation ): array {
		$groups = [];
		$navGroups = $navigation->getGroups();
		foreach ( $navGroups as $group ) {
			$links = [];
			foreach ( $group->getLinks() as $link ) {
				$links[] = [ self::PARAM_LINK => $this->getLink( $link ) ];
			}

			$groups[] = [
				self::PARAM_GROUP_LABEL => $group->getLabel(),
				self::PARAM_LINKS => $links
			];
		}

		return $groups;
	}

	private function getLink( NavigationGroupLink $link ): string {
		return $this->linkRenderer->makeLink(
			$link->getTitleValue(),
			$link->getLabel(),
			[ 'class' => 'mw-structurednav-group-content-link' ]
		);
	}
}
