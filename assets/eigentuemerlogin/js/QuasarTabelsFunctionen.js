$(document).keyup(function(e)
{
    if (e.key === "Escape" && $('.isOpen').html() != '')
    {
        var closer = $('.isOpen').html();

        $('.my-card').addClass('transform');
        $('.isOpen').text('')

        setTimeout(function()
        {
            $('.ban').addClass('display-none');
            $('#' + closer).addClass('display-none');
            $('.' + closer).addClass('display-none');
        }, 200);
    }
    canScroll();
});

if ($('.abrechTabel').length !== 0)
{
    if ($(window).scrollTop() >= $('.abrechTabel').offset().top)
        setFlyHeader()
}

$(document).on("scroll",function()
{
    if ($(window).width() >= 1023)
    {
        loadRecord()
        if ($('.headTabel').length !== 0)
        {
            if ($(window).scrollTop() >= $('.headTabel').offset().top)
                setFlyHeader()
            else
                removeFlyHeader()
        }
    }
});

function setFlyHeader()
{
    $('.headTabel > .q-table__top.relative-position.row.items-center').addClass('tabelTopFly');
    $('.headTabel > .q-table__middle').addClass('margin-fly-header');
}

function removeFlyHeader()
{
    $('.headTabel > .q-table__top.relative-position.row.items-center').removeClass('tabelTopFly');
    $('.headTabel > .q-table__middle').removeClass('margin-fly-header');
}

function canScroll()
{
    $('body').removeClass('no-scroll2');
    var closer = $('.isOpen').html();
}

let supportsOrientationChange = "onorientationchange" in window,
    orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";

window.addEventListener(orientationEvent, function()
{
    canScroll();
}, false);

$(window).on('load', function() {
    loadRecord()
});

function loadRecord()
{
    setTimeout(function() {
        for (let i = 0; i < 10; i++) {
            if ($('.q-table__bottom-item').eq(i).text() == 'Records per page:') {
                $('.q-table__bottom-item').eq(i).text(siteRecords)
            }
        }
    }, 100);
}

$(document).ready(function()
{
    var back_to_top_button = ['<a href="#top" class="back-to-top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>'].join("");
    $("body").append(back_to_top_button)

    $(".back-to-top").hide();

    $(function ()
    {
        $(window).scroll(function ()
        {
            if ($(this).scrollTop() > 100)
                $('.back-to-top').fadeIn();
            else
                $('.back-to-top').fadeOut();
        });

        $('.back-to-top').click(function ()
        {
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });

});

function test() {
    console.log('huis')
}
