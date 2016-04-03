<?php

require_once '../header.php';
use Parse\ParseUser;

$user = ParseUser::getCurrentUser();
if ($user)
{
    header('Location: ../index.php');
    exit();
}


$type = isset($_SESSION['type']) ? $_SESSION['type'] : null;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;

?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <title>Stockr Login</title>
    
    <!-- Meta -->
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible” content=”IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <!-- CSS -->
    <link rel='stylesheet' type='text/css' href='/css/main.css'>
    <link rel='stylesheet' type='text/css' href='/css/login.css'>
</head>
<body class='flex-ver'>

    <h1 class='app-name'>Stockr</h1>
    <div class='module auth-module flex-ver'>
        
        <div class='module-tabs flex-hor'>
            <a id='login-tab'  class='module-tab pressable'>Login</a>
            <a id='signup-tab' class='module-tab pressable unselected'>Sign up</a>
        </div>
        
        <div class='auth-forms transition'>
            <form id='login-form' class='auth-form flex-ver' action='auth.php' method='post'>
                <input type='hidden' name='auth-type' value='login'>
                
                <div class='auth-input flex-ver'>
                    <label class='auth-label'>Email</label>
                    <input type='email' name='username' 
                           id='login-username' class='auth-textfield' required>
                </div>
                <div class='auth-input flex-ver'>
                    <label class='auth-label'>Password</label>
                    <input type='password' name='password'
                           id='login-password' class='auth-textfield' required>
                    <p class='auth-sublabel'>
                        <a class='auth-subinput pressable' onclick="resetPassword()">Forgot your password?</a>
                    </p>
                </div>
            </form>
            
            <form id='signup-form' class='auth-form flex-ver hidden' action='auth.php' method='post'>
                <input type='hidden' name='auth-type' value='signup'>
                
                <div class='auth-input flex-ver'>
                    <label class='auth-label'>Email</label>
                    <input type='email' name='username' 
                           id='signup-username' class='auth-textfield' required>
                </div>
                <div class='auth-input flex-ver'>
                    <label class='auth-label'>Password</label>
                    <input type='password' name='password'
                           id='signup-password' class='auth-textfield' required>
                </div>
                <div class='auth-input flex-ver'>
                    <label class='auth-label'>Confirm Password</label>
                    <input type='password'
                           id='signup-confirm' class='auth-textfield' required>
                </div>
            </form>
        </div>    
            
        <button class='auth-button pressable'>Login</button>
    </div>

    <p id='message'></p>
    
    
    <!-- JS -->
    <script src='/modules/jquery.min.js'></script>
    <script src='/js/login.js'></script>
    
    <script>
        var type = '<? echo $type ?>';
        var error = '<? echo $error ?>';
    </script>
</body>    
</html>


<?php 

unset($_SESSION['type']);
unset($_SESSION['error']);

?>