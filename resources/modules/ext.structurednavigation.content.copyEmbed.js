/**
 * @license MIT
 */
let textToCopy = "<mw-navigation title=\"" + mw.config.get( 'wgTitle' ) + "\" />";
let copyEmbed = new mw.widgets.CopyTextLayout( {
	classes: [ 'mw-structurednav-copyEmbedLayout' ],
	align: 'top',
	label: mw.msg( 'structurednavigation-copy-label' ),
	copyText: textToCopy,
	successMessage: mw.msg( 'structurednavigation-copy-state-success' ),
	failMessage: mw.msg( 'structurednavigation-copy-state-fail' )
} );

copyEmbed.$element.insertAfter( '.mw-structurednav-navigation-container' );
