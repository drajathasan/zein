// Register sidepan
$('ul.zein-side-nav > li.submenu > a').click(async function(e){
    e.preventDefault();
    
    $('.submenu').removeClass('active');
    $(e.target.parentNode).addClass('active');

    $('#mainContent').simbioAJAX($(this).attr('href'));
})

// Scroll
let Scrollbar = window.Scrollbar;
Scrollbar.use(window.OverscrollPlugin);
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
    $('.dashboard-stat, #transactionState, #collectionStat').remove();

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

/* Chart and statistic */
// Rest url
let Rest = $('script[name="app"]').attr('resturl');
let StartDate = $('script[name="app"]').attr('startdate');

// Modified from default/home.php
const getTotal = async (url, selector = null) => {
    // set selector default value 
    if(selector !== null) selector.text('0,0');

    // Make a request
    let res = await (await fetch(Rest + url)).json();
    
    // set value if selector is not null
    if(selector !== null) selector.text(new Intl.NumberFormat('id-ID').format(res.data));
    
    // return as promise
    return res.data;
}

if ($('.inner-stat').length > 0)
{
    getTotal('api/biblio/total/all', $('h3[data-stat="totalCollection"]'));
    getTotal('api/item/total/all', $('h3[data-stat="totalItems"]'));
    getTotal('api/item/total/lent', $('h3[data-stat="totalLent"]'));
    getTotal('api/item/total/available', $('h3[data-stat="totalAvailable"]'));
}

// chartData
const chartData = async (Url, Selector, Callback = null) => {
    // Check selector
    if (Selector.length === 0) return;

    // Get data
    let Result = await (await fetch(Rest + Url)).json();

    if (Callback !== null) Callback(Result, Selector);
}

const arrayIncrease = (array) => {
    if (array.length < 8)
    {
        for (let index = array.length; index < 8; index++) {
            array.push((index - index));
        }
    }
    return array;
}

$('.zein-search-input').keyup(async function(){
    try {
        let Request = await fetch('index.php/zein/search/menu?keyword=' + $(this).val());
        let Data = await Request.json();

        let Menu = '<ul class="d-block pl-3 m-0">';
        Data.forEach((menu, index) => {
            Menu += `<li class="list-unstyled"><a class="zein-search-submenu" href="${menu[1]}">${menu[0]}</a></li>`;
        });
        Menu += '</ul>';

        $('.search-target').html(Menu);
        
    } catch (error) {
        console.log(error);
    }
});

$('.search-target').on('click', '.zein-search-submenu', function(e) {
    e.preventDefault();
    
    // set href
    let href = $(this).attr('href');
    // set container
    let container = $('#mainContent');

    // remove statistic
    $('.dashboard-stat, #transactionState, #collectionStat').remove();

    // Reset value
    $('.zein-search-input').val('');

    // modify container
    container.removeClass('mainContentDashboard rounded');
    container.simbioAJAX($(this).attr('href'));
});

$('#mainContent').on('click', 'input[name="updateData"]', function(e){
    if ($('#mainContent').find('#library_name').length > 0)
    {
        fetch('index.php/zein/config/removecache');
    }
});

$('#mainContent').on('change', '.custom-control-input', function(e){
    fetch('index.php/zein/config/removecache');
});

if (document.querySelector('#transactionState') !== null)
{
    chartData(`api/loan/getdate/${StartDate}`, document.querySelector('#transactionState'), (Result, Container) => {
        getTotal(`api/loan/summary/${StartDate}`)
            .then(SummaryResult => {
                var data = {
                    categories: Result.raw,
                    series: [
                        {
                            name: barchart[3],
                            data: arrayIncrease(SummaryResult.extend)
                        },
                        {
                            name: barchart[1],
                            data: arrayIncrease(SummaryResult.loan)
                        },
                        {
                            name: barchart[2],
                            data: arrayIncrease(SummaryResult.return)
                        }
                    ]
                };
                var options = {
                    chart: {
                        width: (Container.offsetWidth - 30),
                        height: 450,
                        title: barchart[0],
                        format: '1,000'
                    },
                    yAxis: {
                        title: 'Jumlah',
                    },
                    xAxis: {
                        title: 'Tanggal'
                    },
                    legend: {
                        align: 'bottom'
                    }
                };
                var theme = {
                    series: {
                        colors: [
                            '#83b14e', '#458a3f', '#295ba0', '#2a4175', '#289399',
                            '#289399', '#617178', '#8a9a9a', '#516f7d', '#dddddd'
                        ]
                    }
                };
                // For apply theme
                // tui.chart.registerTheme('myTheme', theme);
                // options.theme = 'myTheme';
                tui.chart.columnChart(Container, data, options);
            })
    });

    chartData(`api/loan/summary`, document.querySelector('#collectionStat'), (Result, Container) => {
        let Key = Object.keys(Result.data);
        let Value = Object.values(Result.data);


        var data = {
            categories: [],
            series: [
                {
                    name: Key[1],
                    data: Value[1]
                },
                {
                    name: Key[2],
                    data: Value[2]
                },
                {
                    name: Key[3],
                    data: Value[3]
                },
                {
                    name: Key[4],
                    data: Value[4]
                },
            ]
        };
        var options = {
            chart: {
                width: (Container.offsetWidth - 30),
                height: 450,
                title: doughchart[0],
                format: function(value, chartType, areaType, valuetype, legendName) {
                    return value;
                }
            },
            series: {
                radiusRange: ['20%', '100%'],
                showLabel: true,
                borderWidth: 5
            },
            tooltip: {
                suffix: ''
            },
            legend: {
                align: 'bottom'
            }
        };
        var theme = {
            series: {
                series: {
                    colors: [
                        '#83b14e', '#458a3f', '#295ba0', '#2a4175', '#289399',
                        '#289399', '#617178', '#8a9a9a', '#516f7d', '#dddddd'
                    ]
                },
                label: {
                    color: '#fff',
                    fontFamily: 'arial'
                }
            }
        };

        // For apply theme

        // tui.chart.registerTheme('myTheme', theme);
        // options.theme = 'myTheme';

        tui.chart.pieChart(Container, data, options);
    });
}

