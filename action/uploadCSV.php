<?php
ini_set('display_errors', 'On');

require_once $_SERVER['DOCUMENT_ROOT'] . '/modules/parse-php/autoload.php';

use Parse\ParseClient;

session_start();
ParseClient::initialize('6coM4vYK3mt4YD6fNC8hXm2WAAQZ7ZIaDIR4F04Z', 
                        'TIZe8qfP7L6F21SwKcqVZnvcvT2wDp5UO2tPGaDx', 
                        'QtaEvugC4anbeRe72EDsDCbOuYPCggGq22Ow01ot');

use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseObject;
use Parse\ParseQuery;

$user = ParseUser::getCurrentUser();
$contain = $user->get("acc_container");

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

if (isset($_POST['delete'])) {
    echo('deleting');
    $name = $_POST['account-name'];
    $contain->delete($name);
    $user->set("acc_container",$contain);
    $user->save();
}

// CSV Functionality
if (isset($_POST['add'])) {
    echo('adding');
    $filename = $_FILES['file-csv']['name'];
    echo $filename;
    if(!isValidFile($filename)) {
        echo "Uploaded file type invalid";
        exit();
    }
    $csv_file = file($_FILES['file-csv']['tmp_name']);
    $csv_array = array_map('str_getcsv', $csv_file);
    $name = $_POST['account-name'];
    echo $name;
    // Parse 2D array for transaction data
    $dates = array(date_create_from_format("n/j/Y", $csv_array[0][0]));
    $values = array($csv_array[0][1]);
    $categories = array($csv_array[0][2]);
    $participants = array($csv_array[0][3]);
    for ($row = 1; $row < count($csv_array); $row++) {
        // Parse rows for transaction data
        array_push($dates,date_create_from_format("n/j/Y", $csv_array[$row][0]));
        array_push($values,$csv_array[$row][1]);
        array_push($categories,$csv_array[$row][2]);
        array_push($participants,$csv_array[$row][3]);
    }
    $accountdata = ["dates"=>$dates,"values"=>$values,"categories"=>$categories,"participants"=>$participants];
    $contain->setAssociativeArray($name,$accountdata);
    $user->set("acc_container",$contain);
    $user->save();
}
?>
