var $container;
var resetpage = false;

jQuery(document).ready(function () {

    jQuery('.fewo_list_image').hover(function () {
        jQuery(this).find(".fewo_slidernav").addClass("active");
    }, function () {
        jQuery(this).find(".fewo_slidernav").removeClass("active");
    });
});

function bildZurueck(imgitem) {
    var img = jQuery("#" + imgitem);
    var arrimg = JSON.parse(img.attr('data-images'));
    var pos = parseInt(img.attr('data-posid'));
    pos = pos - 1;
    if (pos < 0)
        pos = arrimg.length - 1;
    img.attr('src', arrimg[pos]['path']);
    img.attr('title', arrimg[pos]['title']);
    img.attr('alt', arrimg[pos]['title']);
    img.attr('data-posid', pos);
}

function bildWeiter(imgitem) {
    var img = jQuery("#" + imgitem);
    var arrimg = JSON.parse(img.attr('data-images'));
    var pos = parseInt(img.attr('data-posid'));
    pos = pos + 1;
    if (pos == arrimg.length)
        pos = 0;
    img.attr('src', arrimg[pos]['path']);
    img.attr('title', arrimg[pos]['title']);
    img.attr('alt', arrimg[pos]['title']);
    img.attr('data-posid', pos);
}

function getURLParameter(name) {
    var value = decodeURIComponent((RegExp(name + '=' + '(.+?)(&|$)').exec(location.search) || [, ""])[1]);
    return (value !== 'null') ? value : false;
}
