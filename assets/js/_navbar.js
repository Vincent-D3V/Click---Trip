if(document.getElementById("padding-for-navbar")){
    document.getElementsByTagName("nav")[0].className = "nav container affix";
    document.getElementById("padding-for-navbar").style.paddingTop="85px";
} else {
    window.onscroll = () => {
        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        document.getElementsByTagName("nav")[0].className = "nav container affix";
        } else {
        document.getElementsByTagName("nav")[0].className = "nav container";
        }
    };
}

$('.navTrigger').click(function () {
    $(this).toggleClass('active');
    $("#mainListDiv").toggleClass("show_list");
    $("#mainListDiv").fadeIn();

});

$(function() {
    $('.footer-links-holder h3').click(function () {
        $(this).parent().toggleClass('active');
    });
});