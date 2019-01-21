/*
 * Bootstrap popovers and tooltips
 */

var $ = require('jquery');

module.exports = function () {
	let selectedPopover;

	$body = $('body') || {};
	$popovers = $('[data-toggle="popover"]');

	// initialise all popovers
	$body.popover({
		selector: '[data-toggle="popover"]',
		container: 'body',
		viewport: {
			selector: 'body',
			padding : 20
		}
	});

	// https://github.com/twbs/bootstrap/issues/16732
	$body.on('hidden.bs.popover', function (e) {
		$(e.target).data("bs.popover").inState.click = false;
	});

	// set current Popover state
	$popovers.on('show.bs.popover', function (e) {
		$target = $(e.currentTarget);
		if(selectedPopover) {
			selectedPopover.popover('hide');
		}
		selectedPopover = $target;
	});

	// clear state when hidden
	$popovers.on('shown.bs.hide', function (e) {
		selectedPopover = null;
	});
}
