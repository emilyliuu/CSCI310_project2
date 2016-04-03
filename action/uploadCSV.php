<?php

require_once 'header.php';
use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseObject;
use Parse\ParseQuery;

$user = ParseUser::getCurrentUser();
$balance = $user->get("balance");
$portfolio = $user->get("portfolio");

function isValidFile($_filename) {
    $ext = strtolower(end(explode('.', $_filename)));
    if($ext != "csv") {
        return false;
    } else {
        return true;
    }
}

function isValidTransaction($_ticker, $_date, $_price, $_qty) {

    if( empty($_ticker) || empty($_date) || empty($_price) || empty($_qty)) {
        return false;
    }
    $transaction_date = date_create_from_format("n/j/Y", $_date);
    $current_date = date("n/j/Y");
    if($transaction_date > $current_date) {
        return false;
    } 
    return true;
}

//checks if the input ticker is supported through Stockr.
function isValidTicker($_ticker) {
    $_ticker = strtoupper($_ticker);
    switch($_ticker) {
        case "MSFT":
        case "AAPL":
        case "GOOGL":
        case "FB":
        case "TSLA":
        case "BRK.A":
        case "NFLX":
            return true;
        default:
            return false;
    }
}


// CSV Functionality
if (isset($_POST['submit'])) {
    
    $filename = $_FILES['csv-file']['name'];
    echo $filename;
    if(!isValidFile($filename)) {
        echo "Uploaded file type invalid";
        exit();
    }
    
    $csv_file = file($_FILES['csv-file']['tmp_name']);
    $csv_array = array_map('str_getcsv', $csv_file);
    
    
    // Parse 2D array for stock data
    for ($row = 1; $row < count($csv_array); $row++) {
        // Parse row for transaction data
        
        $ticker = $csv_array[$row][0];
        $date = $csv_array[$row][1];
        $price = $csv_array[$row][2];
        $qty = $csv_array[$row][3];

        if(!isValidTransaction($ticker, $date, $price, $qty)) {
            echo $ticker;
            echo "Uploaded transaction is invalid.";
            continue;
        } if(!isValidTicker($ticker)) { //invalid ticker symbol
            echo $ticker;
            echo "Sorry, that ticker company is not available through Stockr.";
            exit();
        }
        $ticker = strtoupper($ticker);
        $date = date_create_from_format("n/j/Y", $date);

        if(empty($portfolio[$ticker])) $portfolio[$ticker] = $qty;
        else $portfolio[$ticker] += $qty;
        $user->setAssociativeArray("portfolio", $portfolio);
        $user->save();
    }
    
}
?>
