(function ($) {

    //-----------------------------------------------------------
    $("body").on("click", ".pk-form-edit", function (e) {
        e.preventDefault();
        var target = $(this).attr("data-target");
        $(target).toggleClass("active");
    });
    //-----------------------------------------------------------
    $("body").on("click", ".pk-form-cancel", function (e) {
        e.preventDefault();
        var target = $(this).attr("data-target");
        $(target).toggleClass("active");
    });
    //-----------------------------------------------------------
    alertify.logPosition("bottom right");
    //-----------------------------------------------------------
    //-----------------------------------------------------------
})(jQuery);// end of jquery



