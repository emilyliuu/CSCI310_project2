/**
 * dash.js
 *
 * main js file for dashboard.
 * handles all events/actions related to user interaction on dash.
 */


/* CONST */

var quote_url = 'http://dev.markitondemand.com/MODApis/Api/v2/Quote/jsonp?symbol=';


/* VARS */
var clock = document.getElementById('clock');
var canvas = document.getElementById('graph');

var portfolioMap = new Map();
var watchlistMap = new Map();

var currenStockName = "";
var oldestDate = "";


/**
 * Init function for page, called when document is loaded.
 */
$(document).ready(function()
{    
    updatePortfolio();
    updateWatchlist();
    
    update();
    window.setInterval(update, 1000 * 60);
});


/* --- GRAPH --- */
/**
 *
 */
function updateGraph(m, d, name)
{
    if(!name)
        return;
    
    var currentTime = new Date();
    var startDate = "";
    
    currenStockName = name;
    
    if(m == -1){
       startDate = "&" + oldestDate;
    }else{
        var month = currentTime.getMonth()+1;
        var date = currentTime.getDate();
        var exmonth = currentTime.getMonth() + 1-m;
        var exdate = currentTime.getDate()-d;
        var exyear = currentTime.getFullYear();
        if(exdate == 0){ 
            exdate = 30;
            exmonth -= 1;
        }else if(exdate < 0){
            exdate = 30+exdate;
            exmonth-=1;
        }
        if(exmonth == 0){
            exmonth = 12;
            exyear-=1;
        }else if(exmonth < 0){
            exmonth = 12+exmonth;
            exyear -= 1;
        }
       if(exmonth<10){
            exmonth = "0"+exmonth;
        }
        if(exdate < 10){
            exdate = "0"+exdate;
        }
       startDate = "&trim_start=" + exyear + "-"+exmonth+"-"+exdate;
   }

      if(month<10){
          month = "0"+month;

      }
      if(date < 10){
        date = "0"+date;
      }
      var now = "&"+currentTime.getFullYear()+"-"+month+"-"+date;
    
          $.ajax({
              dataType: 'json',
               url: "https://www.quandl.com/api/v3/datasets/WIKI/"+name+".json?api_key=yqPp2XtrdD682uj_LGxg"+startDate+now,
              success: updateCanvas});
};
/* 
function updateCanvas(data){
    console.log(data);
    oldestDate = data.dataset.oldest_available_date;
    var price = [];
    var date = [];
    console.log(data.length);
    var increment = 1;
    if(data.dataset.data.length >= 30){
        increment = Math.floor(data.dataset.data.length / 10);
    }
    var counter = 0;
    for(i=data.dataset.data.length-1; i>=0; i-=increment){
          var tempDate = data.dataset.data[i][0].substring(5);
          tempDate = tempDate.replace("-", "/");
          date[counter] = tempDate;
          price[counter] = data.dataset.data[i][4];
          counter++;
      }
    drawGraph(price, date);
}
*/

/**
 * Update every minute
 */
function update()
{
    //clock
    clock.innerHTML = moment().utcOffset(-300).format('HH:mm');

}


/* --- EVENTS --- */
/**
 * Called when user clicks csv upload button.
 * Relay click to hidden csv-input.
 */
$('#csv').click(function(e)
{
//    $('#csv-input').click();
});

/**
 * Called when user selects a file to upload
 */
$('#csv-input').change(function(e)
{
    //$('#csv-form').submit();
});

/** 
 * Called when user clicks search bar. 
 * For stock suggestions.
 */
$('#search').click(function(e)
{
    $('#search').autocomplete({
        source: companies,
        select: function(event, ui)
        {
            var company = ui.item.value;
            var ticker = company.substring(
                            company.lastIndexOf("(") + 1,
                            company.lastIndexOf(")")
                        );
            
            if (watchlist.indexOf(ticker) < 0)
            {
                watchlist.push(ticker);
                updateWatchlist();
            }
        }
    });

});

/**
 * Called when user clicks help/user manual button.
 * Brings up new window/tab with help page.
 */
$('#help').click(function(e)
{
    //var win = window.open('help', '_blank');
    //win.focus();
	
	$('#user_manual').bPopup();
});

/**
 * Called when user clicks logout.
 * AJAX post to the logout script and reload the page upon success
 * (which will redirect to the login page)
 */
$('#logout').click(function(e)
{
    $.post('login/logout.php', function(data)
    {
        if (data.status === 'success')
            location.reload();
    }, 'json');
});


/**
 * Called when a graph-tab is clicked.
 * Stop page from reloding 
 */
$('.graph-tab').click(function(e)
{
    e.preventDefault();
    
    e.target.blur();
    e.target.parentNode.blur();
    
    $('.graph-tab').removeClass('active');
    e.target.parentNode.classList.add('active');
});

/**
 * Called when user selects a graph interval span.
 */
$('.interval').click(function(e)
{
    var parent = e.target.parentNode;
    var id = parent.id;
    
    $('.interval').removeClass('active');
    $(parent).addClass('active');
    
    if(id === '1d')
    {  
        console.log('hi');
        
        canvas.remove();
        $('#gContainer').append('<canvas id="graph" width = 570 height = 300></canvas>');
        canvas = document.querySelector('#graph');
        updateGraph(0,1,currenStockName);
    }
    if(id == '5d')
    {
        // window.alert("run");
        canvas.remove();
        $('#gContainer').append('<canvas id="graph" width = 570 height = 300></canvas>');
        canvas = document.querySelector('#graph');
        updateGraph(0,5,currenStockName);
    }
    if(id == '1m')
    {
        // window.alert("run");
        canvas.remove();
        $('#gContainer').append('<canvas id="graph" width = 570 height = 300></canvas>');
        canvas = document.querySelector('#graph');
        updateGraph(1,0,currenStockName);
    }
    if(id == '3m')
    {
        // window.alert("run");
        canvas.remove();
        $('#gContainer').append('<canvas id="graph" width = 570 height = 300></canvas>');
        canvas = document.querySelector('#graph');
        updateGraph(3,0,currenStockName);
    }
    if(id == '6m')
    {
       //  window.alert("run");
        canvas.remove();
        $('#gContainer').append('<canvas id="graph" width = 570 height = 300></canvas>');
        canvas = document.querySelector('#graph');
        updateGraph(6,0,currenStockName);
    }
    if(id == 'all')
    {
       // window.alert("run");
        canvas.remove();
        $('#gContainer').append('<canvas id="graph" width = 570 height = 300></canvas>');
        canvas = document.querySelector('#graph');
        updateGraph(-1,0,currenStockName);
    }
});

/**
 * Called when watch item remove button is called
 */
$('body').on('click', '.watch-item .remove', function(e)
{
    var ticker = $(this).parent().parent().attr('title');
    
    $('.watch-item[title="' + ticker + '"]').remove();
    watchlistMap.delete(ticker);
    
    var index = watchlist.indexOf(ticker);
    if (index >= 0)
        watchlist.splice(index, 1);
    
    updateWatchlist();
});

$('body').on('click', '.watch-item .view', function(e)
{
    var ticker = $(this).parent().parent().attr('title');
    
    $('.interval').removeClass('active');
    $('#6m').addClass('active');
    
    updateGraph(6, 0, ticker);
});



/**
 *
 */
function drawGraph(priceArray, daysArray)
{
    console.log(priceArray);
    console.log(daysArray);
    var p = priceArray;
    var d = daysArray;

    var lineChartData = {
            labels : d,
            datasets : [
                {
                    label: "Stock Data",
                    fillColor : "rgba(220,220,220,0.2)",
                    strokeColor : "#9400D3",
                    pointColor : "rgba(220,220,220,1)",
                    pointStrokeColor : "#000",
                    pointHighlightFill : "#000",
                    pointHighlightStroke : "rgba(220,220,220,1)",
                    data : p
                }           
            ]
        }
        var options = {};

         var ctx = canvas.getContext("2d");
        var myLineChart = new Chart(ctx).Line(lineChartData, {responsive: true, maintainAspectRatio: true});
}

function updateCanvas(data){
    console.log(data);
    var price = [];
    var date = [];
    console.log(data.length);
    var increment = 1;
    if(data.dataset.data.length >= 30){
        increment = Math.floor(data.dataset.data.length / 10);
    }
    var counter = 0;
    for(i=0; i<data.dataset.data.length; i+=increment){
        var tempDate = data.dataset.data[i][0].substring(5);
        console.log(increment);
        tempDate = tempDate.replace("-", "/");
        date[counter] = tempDate;
        price[counter] = data.dataset.data[i][4];
        counter++;
    }
    drawGraph(price, date);
}


/* --- TRANSACTION --- */

var myfile = document.getElementById('file-csv');
var accountName = document.getElementById('account-name');

/**
 * Called when user clicks add or remove button for account
 */
$('.transaction-button').click(function(e)
{
    var button = e.target.id;
    var account = accountName.value;
    var file = myfile.value;
    if (button == 'delete') {
        
    }
    else if (button == 'add') {
        //$('#form-csv').submit();
    }
    
    accountName.value='';
    
    //message.innerHTML = 'processing...';
    //transaction(buy, ticker.toUpperCase(), company.toUpperCase(), qty);
});



/**
 * Takes in "buy" or "sell" string for option.
 * Will scrape values from the transaction module text fields.
 * Returns a success or error message, which prints to #transaction_message.
 */
function transaction(buy, ticker, company, qty)
{
    $.post('/action/transaction.php', 
    {
        company: company,
        ticker: ticker,
        qty: qty,
        buy: buy
    },
    function(json)
    {
        data = JSON.parse(json);
        console.log(data);
        
        if (data.status === 'error')
            message.innerHTML = data.message;
        else //success
        {
            message.innerHTML = 'transaction successful';
            
            $('#balance-amount').html('$' + data.balance);
            $('#netValue-amount').html('$' + data.netValue);
            
            portfolio = data.portfolio;
            owned = Object.keys(portfolio);
            
            var removed = data.removed;
            if (removed && portfolioMap.has(removed))
            {
                $( portfolioMap.get(removed) ).remove();
                portfolioMap.delete(removed);
            }
            updatePortfolio();
        }
    });
}


/* --- STOCK --- */
/**
 * Update portfolio visually.
 * For every owned stock symbol, request current quote and pass to portfolioHandler().
 */
function updatePortfolio()
{
    for (let symbol of owned)
    {
        $.ajax({
            dataType: 'jsonp',
            url: quote_url + symbol,
            success: portfolioHanlder
        });
    }
}

/**
 * Called by updatePortfolio.
 * Create a new element using the fetched data.
 * Query through portfolio map to see if symbol is new.
 * If not, replace the element. Otherwise newly append it.
 * In both cases, set the new element to the map.
 */
function portfolioHanlder(data)
{
    var symbol = data.Symbol;
    var element = getOwnedItem(data.Name, symbol, data.LastPrice, data.ChangePercent, portfolio[symbol]);
    
    if ( !portfolioMap.has(symbol) )
    {
        portfolioMap.set(symbol, element);
        $('#portfolio').append(element);
    }
    else
    {
        var old = portfolioMap.get(symbol);
        portfolioMap.set(symbol, element);
        $(old).replaceWith(element);
    }
}

/**
 * 
 */
function updateWatchlist()
{
    for (let symbol of watchlist)
    {
        $.ajax({
            dataType: 'jsonp',
            url: quote_url + symbol,
            success: watchlistHandler
        });
    }
}

/**
 *
 */
function watchlistHandler(data)
{
    var symbol = data.Symbol;
    var element = getWatchItem(data.Name, symbol, data.LastPrice, data.ChangePercent);
    
    if ( !watchlistMap.has(symbol) )
    {
        watchlistMap.set(symbol, element);
        $('#watchlist').append(element);
    }
    else
    {
        var old = watchlistMap.get(symbol);
        watchlistMap.set(symbol, element);
        $(old).replaceWith(element);
    }
}

/**
 * Returns html string for portfolio item given the params
 */
function getOwnedItem(company, ticker, price, change, qty)
{
    change = change.toFixed(2);
    
    var sign = 'neutral';
    if (change > 0) sign = 'pos';
    if (change < 0) sign = 'neg';
    
    var template = ""
    + "<li class='stock-item owned-item flex-hor'>"
    +   "<div class='input-col flex-ver'>"
    +       "<button class='stock-button view'>"
    +           "<span class='glyphicon glyphicon-eye-open'></span></button></div>"
    +       "<div class='data-col'>"
    +           "<p class='data-row name-row'>"
    +               "<span class='company name-part'>{company}</span>"
    +               "<span class='ticker name-art'> ({ticker})</span></p>"
    +           "<p class='data-row price-row'>"
    +               "<span class='live-price price-part'>${price}</span>"
    +               "<span class='per-change price-part {sign}'>{change}%</span></p>"
    +           "<p class='data-row owned-row'>"
    +               "<span class='owned-qty'>{qty} owned</span></p>"
    +   "</div>"
    + "</li>";
    
    var html = template
        .split('{company}').join(company)
        .split('{ticker}').join(ticker)
        .split('{price}').join(price)
        .split('{change}').join(change)
        .split('{sign}').join(sign)
        .split('{qty}').join(qty);
    
    return elementFromString(html);
}

/**
 * Returns html string for watchlist item given the params
 */
function getWatchItem(company, ticker, price, change)
{
    change = change.toFixed(2);
    
    var sign = 'neutral';
    if (change > 0) sign = 'pos';
    if (change < 0) sign = 'neg';
    
    var template = ""
    + "<li class='stock-item watch-item flex-hor' title='{ticker}'>"
    +   "<div class='data-col'>"
    +       "<p class='data-row name-row'>"
    +           "<span class='company name-part'>{company}</span>"
    +           "<span class='ticker name-art'> ({ticker})</span></p>"
    +       "<p class='data-row price-row'>"
    +           "<span class='live-price price-part'>${price}</span>"
    +           "<span class='per-change price-part {sign}'>{change}%</span></p></div>"
    +   "<div class='input-col'>"
    +       "<button class='stock-button view'>"
    +           "<span class='glyphicon glyphicon-eye-open'></span></button>"
    +       "<button class='stock-button remove'>"
    +           "<span class='glyphicon glyphicon-remove'></span></button>"
    +   "</div>"
    + "</li>";
    
    var html = template
        .split('{company}').join(company)
        .split('{ticker}').join(ticker)
        .split('{price}').join(price)
        .split('{change}').join(change)
        .split('{sign}').join(sign);
    
    return elementFromString(html);
}



/* --- HELPER --- */
/**
 * Returns whether given param is an int
 */
function isInt(n)
{ 
    return n % 1 === 0;
    //return parseInt(n) === n;
}

/**
 * Return new element from given html string
 */
function elementFromString(html)
{
    var d = document.createElement('div');
    d.innerHTML = html;
    return d.firstChild;
}


