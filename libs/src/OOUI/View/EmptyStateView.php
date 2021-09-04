<?php

namespace StructuredNavigation\Libs\OOUI\View;

use OOUI\ButtonWidget;
use OOUI\Layout;
use OOUI\Tag;

/**
 * Represents a generic empty state screen. An empty state consists of
 * a graphical/visual illustration, title, short summary, as well as
 * a prominent CTA that the viewing user can take.
 *
 * @license MIT
 * @author Samantha Nguyen < samanthanguyen1116@gmail.com >
 */
class EmptyStateView extends Layout {
	private const CSS_CLASS = [
		'view-container' => 'oo-ui-view-emptystate-container',
		'view-illustration' => 'oo-ui-view-emptystate-illustration',
		'view-title' => 'oo-ui-view-emptystate-title',
		'view-summary' => 'oo-ui-view-emptystate-summary',
		'view-action' => 'oo-ui-view-emptystate-action'
	];

	private string $imageSource;
	private string $title;
	private string $summary;
	private string $buttonLabel;
	private string $buttonHref;

	/**
	 * @param array $config
	 * 	string $config['imageSource'] Represents the path to the graphical/visual illustration.
	 * 	string $config['title'] Represents the title shown to the user.
	 * 	string $config['summary'] Represents the short summary message shown to the user.
	 * 	string $config['buttonLabel'] Represents the label on the button.
	 * 	string $config['buttonHref'] Represents the URL that the button takes the user to.
	 */
	public function __construct( array $config = [] ) {
		parent::__construct( $config );

		$this->addClasses( [ self::CSS_CLASS['view-container'] ] );
		$this->imageSource = $config['imageSource'];
		$this->title = $config['title'];
		$this->summary = $config['summary'];
		$this->buttonLabel = $config['buttonLabel'];
		$this->buttonHref = $config['buttonHref'];

		$this->appendContent( [
			$this->getIllustration(),
			$this->getTitle(),
			$this->getSummary(),
			$this->getAction()
		] );
	}

	private function getIllustration(): Tag {
		return ( new Tag( 'img' ) )
			->addClasses( [ self::CSS_CLASS['view-illustration'] ] )
			->setAttributes( [
				'src' => $this->imageSource,
				'role' => 'presentation',
				'alt' => ''
			] );
	}

	private function getTitle(): Tag {
		return ( new Tag( 'h3' ) )
			->addClasses( [ self::CSS_CLASS['view-title'] ] )
			->appendContent( $this->title );
	}

	private function getSummary(): Tag {
		return ( new Tag( 'div' ) )
			->addClasses( [ self::CSS_CLASS['view-summary'] ] )
			->appendContent( $this->summary );
	}

	private function getAction(): ButtonWidget {
		return new ButtonWidget( [
			'label' => $this->buttonLabel,
			'href' => $this->buttonHref,
			'flags' => [ 'primary', 'progressive' ],
			'classes' => [ self::CSS_CLASS['view-action'] ]
		] );
	}
}
