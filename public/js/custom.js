/**
 * Created by Maen Terawasi on 2/08/2015.
 */
$(document).ready(function() {
    /*-----------slow scrolling jquery---------*/
    $(".homeScrollLink").click(function() {
        $('html, body').stop().animate({
            scrollTop: $(".mainBanner").offset().top
        }, 1000);
    });
    $(".newsScrollLink").click(function() {
        $('html, body').stop().animate({
            scrollTop: $(".firstSection").offset().top
        }, 1000);
    });
    $(".eventsScrollLink").click(function() {
        $('html, body').stop().animate({
            scrollTop: $(".secondSection").offset().top
        }, 1000);
    });
    $(".roadWorksScrollLink").click(function() {
        $('html, body').stop().animate({
            scrollTop: $(".thirdSection").offset().top
        }, 1000);
    });
    $(".weatherScrollLink").click(function() {
        $('html, body').stop().animate({
            scrollTop: $(".fourthSection").offset().top
        }, 1000);
    });
});