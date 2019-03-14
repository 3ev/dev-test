/*
 * Bootstrap popovers and tooltips
 */


var $ = require('jquery')


module.exports = function () {

    // initialise all popovers
    $('body').popover({
        selector: "[data-toggle=popover]",
        container: 'body',
        viewport: { selector: 'body', padding: 20 }
    }).on("show.bs.popover", function(e){
        // hide all other popovers
        $("[data-toggle=popover]").not(e.target).popover("destroy");
        $(".popover").remove();
    });
    
    // Initialise Bootstrap tooltips
    //http://getbootstrap.com/javascript/#tooltips
    $('[data-toggle="tooltip"]').tooltip()
}