

<!DOCTYPE html>
<html lang='en'>
<head>    
    <!-- Meta -->
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible” content=”IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <title>Nancin</title>
    
    <!-- CSS -->
    <link rel='stylesheet' href='/modules/bootstrap/css/bootstrap.css'> <!--removed bootstrap.min.css and put bootstrap.css 04/01.16 -->
    <link rel='stylesheet' href='/css/dash.css'>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    
    

    <!-- JS -->
    <script src='/modules/jquery.min.js'></script>
    <script src='/modules/jquery.bpopup.min.js'></script>
    <script src='/modules/jquery-ui.min.js'></script>
    <script src='/modules/bootstrap/js/bootstrap.min.js'></script>
    <script src='/modules/chart.min.js'></script>
    <script src='/modules/moment.min.js'></script>
    
    <script src='/js/dash.js'></script>

</head>
<body>

    <div class='container'>
    
        <div class='row header'>
            <div class='col col-xs-3 col-side name flex-ver'>
                <h1 id='appname' class=''>Nancin</h1>
            </div>
            <div class='col col-xs-6 banner flex-ver'>
                <p id='clock' class='time'>16:00</p>
                <p class='timezone'>Eastern Standard</p>
            </div>
            <div class='col col-xs-3 col-side account flex-ver'>
                <p id='username' class='label'>
                    
                    </p>
                <p id='balance' class='label'>
                    <span class='sublabel'>balance</span>
                    <span id="balance-amount"></span>
                    </p>
                <p id='net-value' class='label'> 
                    <span class='sublabel'>net value</span>
                    <span id="netValue-amount"></span>
                    </p>
            </div>
        </div>
        
        <div class='row toolbar'>
            <div class='col col-xs-3 col-side toolbar-left flex-hor'>
                <button id='csv' class='tool button' title='CSV Upload'>
                    <span class="glyphicon glyphicon-open-file" aria-hidden="true"></span>
                </button>
                
                <form id="csv-form" action="/action/uploadCSV.php" method="post" enctype="multipart/form-data">
                    <input id='csv-file' type='file' name='csv-file'>
                    <input type='submit' value='upload' name='submit'>
                </form>
                
            </div>
            <div class='col col-xs-6'>
                <input id='search' class='tool textfield'
                       type='text' placeholder='Search for a financial account'/>
            </div>
            <div class='col col-xs-3 col-side toolbar-right flex-hor'>
                <button id='help' class='tool button' title='User Manual'>
                    <span class='glyphicon glyphicon-info-sign' aria-hidden='true'></span>
                </button>
                <button id='logout' class='tool button' title='Log out'>
                    <span class='glyphicon glyphicon-log-out' aria-hidden='true'></span>
                </button>
            </div>
        </div>
        
        <div class='row content'>
            <div class='col col-xs-3 col-side'>
                <ul id='portfolio' class='module stock-list'>
                    
                    
                    
                </ul>
            </div>
            <div class='col col-xs-6'>
                <div id='graph-view' class='module graph-module flex-ver'>
                    <ul class="nav nav-tabs graph-tabs">
                        <li class='graph-tab' active><a href=''>Portfolio</a></li>
                        <li class='graph-tab'><a href=''>Watchlist</a></li>
                    </ul>
                    <div id="gContainer">
                    <canvas id='graph' width = 570 height = 300></canvas>
                    </div>
                    <ul id='interval-list' class='flex-hor'>
                        <li id='1d' class='interval'><a>1d</a></li>
                        <li id='5d' class='interval'><a>5d</a></li>
                        <li id='1m' class='interval'><a>1m</a></li>
                        <li id='3m' class='interval'><a>3m</a></li>
                        <li id='6m' class='interval'><a>6m</a></li>
                        <li id='all' class='interval'><a>All</a></li>
                    </ul>
                </div>
            </div>
            <div class='col col-xs-3 col-side'>
                <div class='module'>
                    <div id='legend'></div>
                    <ul id='watchlist' class='stock-list'>
                        
                        
                        
                    </ul>
                </div>
            </div>
        </div>
        
        <div class='row footer'>
            <div class='col col-xs-3 col-side'>
                <div id='transaction' class='module flex-ver'>
                    <div id='' class='target-row flex-hor'>
                        
                    </div>
                    <div id='' class='qty-row flex-hor'>
                        <input id='qty-input' class='transaction-qty'
                               type='text' placeholder='Account Name'>
                    </div>
                    <div id='' class='msg-row'>
                        <p id='transaction-message' class='message'></p>
                    </div>
                    <div id='' class='confirm-row flex-hor'>
                        <button id='buy' class='transaction-button'>Add</button>
                        <button id='sell' class='transaction-button'>Delete</button>
                    </div>
                </div>
            </div>
            <div class='col col-xs-6'>
                <div id='details' class='module'></div>
            </div>
            <div class='col col-xs-3 col-side'>
                <div id='recommendation' class='module'></div>
            </div>
        </div>
    </div>
	
	<!-- User Manual (starts with display:none) -->
	<div id="user_manual" style="display:none;background-color:white;color:#111111;width:600px;height:500px;border-radius:4px;border:2px solid #3BBEAF">
		<div style="margin:25px auto;width:500px;height:450px;overflow:auto;overflow-x:hidden;">
			<strong>How to use Stockr (User Manual)</strong>
			<br><br>
			Reset Password
			<br><br>
			If at any time in the future you forget your password, press the 'forgot password' link in the login
			screen in order to reset it.
			<br><br>
			Selling a stock
			<br><br>
			To sell a stock, a user inputs the number of shares to be sold in the text box associated
			with the stock the user wants to sell in his portfolio.
			Pressing the “Sell” button on the left module brings up a confirmation dialogue to give
			the user a chance to review their transaction before going through with his order. If the
			transaction is confirmed on the dialogue, the shares will be sold, and the associated
			value will be added to the user’s account balance. Multiple types of stocks can be sold
			at once by entering values in the text boxes associated with different stocks in the
			user’s portfolio, before selecting the “Sell” button. The transaction confirmation
			process is the same as that of selling a single stock.
			<br><br>
			Buying a stock
			<br><br>
			To buy a stock, a user inputs the number of shares to be bought in the text box
			associated with the stock the user wants to buy among the available stocks in the right
			module. Pressing the “Buy” button on the right module brings up a
			confirmation dialogue to give the user a chance to review their transaction before going
			through with his order. If the transaction is confirmed on the dialogue, the shares will be
			bought, if the user has sufficient funds. Multiple types of stocks can be bought at once
			13
			by entering values in the text boxes associated with different stocks in the right
			module, before selecting the “Buy” button. The transaction confirmation process is the
			same as that of buying a single stock.
			<br><br>
			Viewing a stock
			<br><br>
			If the user double clicks a stock, that stock’s information should be displayed in the
			graph and bottom modules. Multiple stocks can be selected at a time.
			Buttons in the top region of the central module will allow the user to change the time
			period shown, from the default options of today, yesterday, 5 days, 1 month, 3 months,
			6 months, and all time. The user may also specify a time interval to view through the
			graph. A legend will be placed below the graph, helping the user distinguish the
			company name for each of the colored lines.
			The bottom module displays various other information that about the selected stock(s).
			This information includes price, percentage change from last closing price, and
			percentage change relative to a stock’s respective market.
		</div>
	</div>

    
    
</body>
</html>