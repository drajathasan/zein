$(document).ready(function(){

    // Register sidepan
    $('ul.zein-side-nav > li.submenu > a').click(async function(e){
        e.preventDefault();
        
        $('.submenu').removeClass('active');
        $(e.target.parentNode).addClass('active');

        $('#mainContent').simbioAJAX($(this).attr('href'));
    })

})