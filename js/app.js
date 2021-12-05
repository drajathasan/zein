$(document).ready(function(){

    // Register sidepan
    $('ul.zein-side-nav > li.submenu > a').click(async function(e){
        e.preventDefault();
        
        $('.submenu').removeClass('active');
        $(e.target.parentNode).addClass('active');

        $('#mainContent').simbioAJAX($(this).attr('href'));
    })

    // Scroll
    let Scrollbar = window.Scrollbar;
    Scrollbar.use(window.OverscrollPlugin)
    Scrollbar.init(document.querySelector('.sidepan'), {
        alwaysShowTracks: false,
        continuousScrolling: false,
        plugins: {
        overscroll: {
            effect: 'glow'
        },
        }
    });

    // Drop Down Menu
    $('.dropdown-menu > a.dropdown-item').click(async function(e){
        // set href
        let href = $(this).attr('href');
        // set container
        let container = $('#mainContent');

        if (href.match(/logout.php/i))
        {
            return;
        }

        // prevent default event
        e.preventDefault();
        
        // remove statistic
        $('.dashboard-stat').remove();

        // modify container
        container.removeClass('mainContentDashboard rounded');
        container.simbioAJAX($(this).attr('href'));
    });

    // Other module
    $('.other-module').click(function(e){
        // prevent default event
        e.preventDefault();
        // set Submenus
        let Submenus = $('.submenu, .submenu-header, zein-side-nav > span');
        let ModuleList = $('.module-list');
        // Hide
        Submenus.attr('style', 'display: none !important');
        $(this).attr('style', 'display: none !important');
        // Show
        ModuleList.removeClass('d-none');
    });
})