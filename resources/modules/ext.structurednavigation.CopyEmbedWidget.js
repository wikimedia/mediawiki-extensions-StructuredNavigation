/**
 * @license MIT
 */

/**
 * @class
 * @constructor
 * @extends mw.widgets.CopyTextLayout
 * @param {Object} config
 */
mw.structuredNav.CopyEmbedWidget = function MwStructuredNavCopyEmbed( config ) {
	config = $.extend( {
		align: 'top',
		label: mw.msg( 'structurednavigation-copy-label' ),
		copyText: this.getTextToCopy(),
	}, config );

	mw.structuredNav.CopyEmbedWidget.parent.call( this, config );

	this.successMessage = mw.msg( 'structurednavigation-copy-state-success' );
	this.failMessage = mw.msg( 'structurednavigation-copy-state-fail' );

	this.$element.addClass( 'mw-structurednav-copyEmbedWidget' );
};

OO.inheritClass( mw.structuredNav.CopyEmbedWidget, mw.widgets.CopyTextLayout );

/**
 * @param {string} selector
 * @return {string}
 */
mw.structuredNav.CopyEmbedWidget.prototype.getTextToCopy = function () {
	return '<mw-navigation title="' + mw.config.get( 'wgTitle' ) + '" />';
};
