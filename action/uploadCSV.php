<?php
ini_set('display_errors', 'On');

require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/parse-php/autoload.php';

$user = ParseUser::getCurrentUser();

//$balance = $user->get("balance");
//$portfolio = $user->get("portfolio");

function isValidFile($_filename) {
    return true;
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

echo('hey!');
// CSV Functionality
if (isset($_POST['submit'])) {
    echo('hey');
    $filename = $_FILES['file-csv']['name'];
    echo $filename;
    if(!isValidFile($filename)) {
        echo "Uploaded file type invalid";
        exit();
    }
    $csv_file = file($_FILES['file-csv']['tmp_name']);
    $csv_array = array_map('str_getcsv', $csv_file);
    $name = $_POST['account-name'];
    //$name = $csv_array[0][0];
    echo $name;
    // Parse 2D array for stock data
    $dates = array(date_create_from_format("n/j/Y", $csv_array[0][0]));
    $values = array($csv_array[0][1]);
    $categories = array($csv_array[0][2]);
    $participants = array($csv_array[0][3]);
    for ($row = 1; $row < count($csv_array); $row++) {
        // Parse row for transaction data
        array_push($date,date_create_from_format("n/j/Y", $csv_array[$row][0]));
        array_push($value,$csv_array[$row][1]);
        array_push($category,$csv_array[$row][2]);
        array_push($participant,$csv_array[$row][3]);

        
        //if(empty($portfolio[$ticker])) $portfolio[$ticker] = $qty;
        //else $portfolio[$ticker] += $qty;
        //$user->setAssociativeArray("portfolio", $portfolio);
        //$user->save();
    }
    $accountdata = ["name"=>$name,"dates"=>$dates,"values"=>$values,"categories"=>$categories,"participants"=>$participants];
    
    
}
?>
