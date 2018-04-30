$("document").ready(function() {
    $("#season").change(function(e){
        let seasonNum = $(this).find('option:selected').val();

        if (seasonNum === "all") {
            $(".episode").each(function() {
                $(this).css("display", "block")
            })
        } else {
            $(".episode").each(function() {
                $(this).css("display", "block")
                $(this).not("." + seasonNum).css("display", "none");
            })
        }
    })
});