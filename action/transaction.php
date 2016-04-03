<?php

require_once '../header.php';
use Parse\ParseUser;
use Parse\ParseQuery;
use Parse\ParseObject;
use Parse\ParseException;


//response data
$response = [];

function error($_message)
{
	$response['status'] = 'error';
	$response['message'] = $_message;
	echo json_encode($response);
	exit();
}

//post data
$company = $_POST['company'];
$ticker = $_POST['ticker'];
$qty = intval($_POST['qty']);
$buy = $_POST['buy'] === 'buy';


//user
$user = ParseUser::getCurrentUser();
$balance = $user->get("balance");
$netValue = $user->get('netValue');
$portfolio = $user->get("portfolio");


//query for ticker/company
$query = new ParseQuery("Company");
$query->equalTo("ticker", $ticker);
if ( !$query->first() )
	error('ticker not found');


//fetch current price
$data = file_get_contents("http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=" . $ticker);
$json = json_decode($data);
$sharePrice = intval($json->LastPrice);

$total = $sharePrice * $qty;


//check valid transaction
if( $buy )
{
	if ($balance < $total)
		error('not enough balance');
}
else
{
	if ( empty($portfolio[$ticker]) || $portfolio[$ticker] < $qty)
		error('not enough shares'); 
}


//update balance
$balance += $buy ? -$total : $total;
$user->set("balance", $balance);

//update portfolio
if ($buy)
{
	if( empty($portfolio[$ticker]) ) 
		$portfolio[$ticker] = 0;
	
	$portfolio[$ticker] += $qty;
}
else
{
	$portfolio[$ticker] -= $qty;

	if ( $portfolio[$ticker] == 0)
	{
		$response['removed'] = $ticker;
		unset( $portfolio[$ticker] );
	}
}

$user->setAssociativeArray("portfolio", $portfolio);
$user->save();


//log transcation
$transaction = new ParseObject("Transaction");
$transaction->set("buy", $buy);
$transaction->set("quantity", $qty);
$transaction->set("ticker", $ticker);
$transaction->set("user", $user);
$transaction->save();


$response['status'] = 'success';
$response['balance'] = $balance;
$response['netValue'] = $netValue;
$response['portfolio'] = $portfolio;
echo json_encode($response);
exit();

