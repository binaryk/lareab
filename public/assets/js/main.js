$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("active");
    $("body").toggleClass("sidebar_collapsed");
    $(".navbar-default.sidebar").toggleClass("active");
});