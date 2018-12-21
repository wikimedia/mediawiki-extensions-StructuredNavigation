<?php

namespace StructuredNavigation\Libs\OOUI;

use OOUI\CheckboxInputWidget;
use OOUI\Tag;

/**
 * PHP implementation of the OOUI JS-based ToggleSwitchWidget.
 *
 * @license GPL-2.0-or-later
 * @author Samantha Nguyen < samanthanguyen1116@gmail.com >
 */
class ToggleSwitchInputWidget extends CheckboxInputWidget {

	/** @var array */
	private $cssClasses = [
		'widget' => 'ooui-ui-libs-toggleSwitchInputWidget',
		'checkbox' => 'ooui-ui-libs-toggleSwitchInputWidget-checkbox',
		'slider' => 'ooui-ui-libs-toggleSwitchInputWidget-slider'
	];

	/**
	 * @param array $config
	 */
	public function __construct( array $config = [] ) {
		parent::__construct( $config );

		// clear stuff that's been inherited and not wanted:
		// a CSS class, and an \OOUI\IconWidget
		$this->removeClasses( [ 'oo-ui-checkboxInputWidget' ] );

		$this->addClasses( [ $this->cssClasses['widget'] ] );
	}

	/**
	 * @param array $config
	 * @return Tag
	 */
	protected function getInputElement( $config ) {
		return ( new Tag( 'label' ) )
			->appendContent( [
				$this->getFakeCheckbox(),
				$this->getSlider()
			] );
	}

	/**
	 * @return Tag
	 */
	private function getFakeCheckbox() : Tag {
		return ( new Tag( 'input' ) )
			->setAttributes( [ 'type' => 'checkbox' ] )
			->addClasses( [ $this->cssClasses['checkbox' ] ] );
	}

	/**
	 * @return Tag
	 */
	private function getSlider(): Tag {
		return ( new Tag( 'span' ) )
			->addClasses( [ $this->cssClasses['slider'] ] );
	}
}
