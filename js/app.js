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

    // Chart and statistic
    // Modified from default/home.php
    const getTotal = async (url, selector = null) => {
        // Rest url
        let Rest = $('script[name="app"]').attr('resturl');
        // set selector default value 
        if(selector !== null) selector.text('0,0');
        // Make a request
        let res = await (await fetch(Rest + url)).json();
        // set value if selector is not null
        if(selector !== null) selector.text(new Intl.NumberFormat('id-ID').format(res.data));
        // return as promise
        return res.data;
    }

    getTotal('api/biblio/total/all', $('h3[data-stat="totalCollection"]'));
    getTotal('api/item/total/all', $('h3[data-stat="totalItems"]'));
    getTotal('api/item/total/lent', $('h3[data-stat="totalLent"]'));
    getTotal('api/item/total/available', $('h3[data-stat="totalAvailable"]'));
})