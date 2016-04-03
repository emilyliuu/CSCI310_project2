<?php

//echo "Debug: Starting auth...<br>";

require_once '../header.php';
use Parse\ParseUser;
use Parse\ParseException;


/* Post Data */
$type = $_POST['auth-type'];
$username = $_POST['username'];
$password = $_POST['password'];

//echo "Debug: username: $username, password: $password <br>";


$user = null;
try
{ 
    if (strcmp($type,'login') === 0)
	{
        $user = ParseUser::logIn($username, $password);
	}
    else if (strcmp($type,'signup') === 0)
    {
        //basic auth
        $user = new ParseUser();
        $user->set("email", $username);
        $user->set("username", $username);
        $user->set("password", $password);
        
        //default values
        $user->set('balance', 10000);
        $user->set('netValue', 10000);
        $user->setAssociativeArray('portfolio', []);
        $user->setArray('watchlist', ['MSFT', 'AAPL', 'GOOG', 'FB']);
        
        $user->signUp();
    }
    
    header("Location: ../");
    exit();
}
catch (ParseException $e)
{
    $_SESSION['type'] = $type;
    $_SESSION['error'] = $e->getMessage();
	
	//echo "Debug: Encountered error: " . $_SESSION['error'] . "<br>";
    
    header("Location: ../login");
    exit();
}

