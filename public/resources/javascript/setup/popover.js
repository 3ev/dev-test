/*
 * Bootstrap popovers and tooltips
 */


var $ = require('jquery')


module.exports = function () {

    // initialise all popovers
    $('body').popover({
        selector: '[data-toggle="popover"]',
        container: 'body',
        viewport: { selector: 'body', padding: 20 }
    })
    
    // Initialise Bootstrap tooltips
    //http://getbootstrap.com/javascript/#tooltips
    $('[data-toggle="tooltip"]').tooltip()

    // Hide Bootstrap Popover
    $('.media-object').on('click', function (e) {
        $('.media-object').not(this).popover('hide');
    });
}