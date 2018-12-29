<?php

namespace StructuredNavigation\Renderer;

use Html;
use MediaWiki\Linker\LinkRenderer;
use OOUI\HtmlSnippet;
use OOUI\Tag;
use StructuredNavigation\Json\JsonEntity;
use StructuredNavigation\Libs\OOUI\Element\DescriptionList;
use StructuredNavigation\Libs\OOUI\Element\UnorderedList;
use TitleParser;
use TitleValue;

/**
 * Renders a structured navigation view. This by default does
 * not load any modules on the rendering event, it simply
 * provides a base HTML structure that's meant to be semantic
 * and flexible. Consumers are expected to provide their own
 * ResourceLoader modules (as of now)
 *
 * @license GPL-2.0-or-later
 */
final class NavigationRenderer {

	/** @var LinkRenderer */
	private $linkRenderer;

	/** @var TitleParser */
	private $titleParser;

	/**
	 * @var array Conveniently keeps all CSS class keys in one place.
	 */
	private $cssClasses = [
		'groups' => 'mw-structurednav-groups-container',
		'group' => 'mw-structurednav-group',
		'group-title' => 'mw-structurednav-group-title',
		'group-content' => 'mw-structurednav-group-content',
		'group-content-list' => 'mw-structurednav-group-content-list',
		'group-content-item' => 'mw-structurednav-group-content-item',
		'group-content-link' => 'mw-structurednav-group-content-link',
		'header' => 'mw-structurednav-header',
		'header-title' => 'mw-structurednav-header-title',
		'nav' => 'mw-structurednav-navigation-container'
	];

	/**
	 * @param LinkRenderer $linkRenderer
	 * @param TitleParser $titleParser
	 */
	public function __construct(
		LinkRenderer $linkRenderer,
		TitleParser $titleParser
	) {
		$this->linkRenderer = $linkRenderer;
		$this->titleParser = $titleParser;
	}

	/**
	 * @param JsonEntity $jsonEntity
	 * @return Tag
	 */
	public function render( JsonEntity $jsonEntity ) : Tag {
		return ( new Tag( 'nav' ) )
			->addClasses( [ $this->cssClasses['nav'] ] )
			->appendContent( new HtmlSnippet(
				$this->doRenderHeader( $jsonEntity ) .
				$this->doRenderGroups( $jsonEntity )
			) );
	}

	/**
	 * @param JsonEntity $jsonEntity
	 * @return Tag
	 */
	private function doRenderHeader( JsonEntity $jsonEntity ) : Tag {
		return ( new Tag( 'header' ) )
			->addClasses( [ $this->cssClasses['header'] ] )
			->appendContent( new HtmlSnippet(
				( new Tag( 'h2' ) )
					->addClasses( [ $this->cssClasses['header-title'] ] )
					->appendContent( $jsonEntity->getName() )
					->toString()
			) );
	}

	/**
	 * @param JsonEntity $jsonEntity
	 * @return DescriptionList
	 */
	private function doRenderGroups( JsonEntity $jsonEntity ) : DescriptionList {
		$allGroups = [];

		foreach ( $jsonEntity->getGroups() as $group ) {
			array_push(
				$allGroups,
				[
					'term' => $jsonEntity->getGroupTitle( $group ),
					'detail' => $this->doRenderContent( $jsonEntity->getGroupContent( $group ) )
				]
			);
		}

		return new DescriptionList( [
			'items' => $allGroups,
			'container-attributes' => [ 'class' => $this->cssClasses['group'] ],
			'term-attributes' => [ 'class' => $this->cssClasses['group-title'] ],
			'detail-attributes' => [ 'class' => $this->cssClasses['group-content'] ],
		] );
	}

	/**
	 * @param array $content
	 * @return UnorderedList
	 */
	private function doRenderContent( array $content ) : UnorderedList {
		$allContent = [];

		foreach ( $content as $contentItem ) {
			$html = '';

			if ( is_array( $contentItem ) ) {
				$html = $this->doRenderContentItem(
					$this->titleParser->parseTitle( $contentItem[0] ),
					$contentItem[1]
				);
			} else {
				$title = $this->titleParser->parseTitle( $contentItem );
				$html = $this->doRenderContentItem( $title, $title->getText() );
			}

			array_push( $allContent, $html );
		}

		return new UnorderedList( [
			'items' => $allContent,
			'item-attributes' => [ 'class' => $this->cssClasses['group-content-item'] ],
			'classes' => [ $this->cssClasses['group-content-list'] ]
		] );
	}

	/**
	 * @param TitleValue $title
	 * @param string $text
	 * @return string
	 */
	private function doRenderContentItem( TitleValue $title, string $text ) : string {
		return $this->linkRenderer->makeLink(
			$title, $text,
			[ 'class' => $this->cssClasses['group-content-link'] ]
		);
	}
}
