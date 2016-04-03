/*
 login.js
 --------
 js script used only for login page
 
 @author: Bohui Moon [bohuim]
 */


/* --- VARS --- */
var loginSelected = true;
var message = document.getElementById('message');


/* --- EVENTS --- */
/**
 * Init function for page, called when document finishes loading.
 * Check if 
 */
$(document).ready(function()
{
    if (error === '')
        return;
    
    message.innerHTML = error;//look here
    if (type === 'signup')
        $('#signup-tab').click();
});

/**
 * Called when one of the module tabs gets clicked.
 * Toggle all necessary classes so that tab is switched.
 * Change loginSelected state and reset button text.
 */
$('.module-tab').click(function(e)
{
    var target = e.target;
    var id = target.id;
    
    //end if already selected
    if ( !target.classList.contains('unselected') )
        return;
    
    $('.module-tab').toggleClass('unselected');
    $('.auth-forms').toggleClass('extended');
    $('.auth-form').toggleClass('hidden');
    
    $('button.auth-button').html(loginSelected ? 'Sign up' : 'Login');
    loginSelected = !loginSelected;
});

/**
 * Called when auth button [login/sign up] is pressed.
 * Relay message to auth().
 */
$('button.auth-button').click(function(e)
{    
    auth();
});

/**
 * Called when user presses any key on one of the auth input fields.
 * 
 */
$('.auth-textfield').keypress(function(e)
{
    //return if not enter key
    if (e.which !== 13)
        return;
    
    //depending on state, do action
    if (loginSelected)
    {
        var username = document.getElementById('login-username');
        var password = document.getElementById('login-password');

        if (username.value && password.value)
            auth();
        else if (username.value)
            password.focus();
    }
    else
    {
        var username = document.getElementById('signup-username');
        var password = document.getElementById('signup-password');
        var confirm = document.getElementById('signup-confirm');

        if (username.value && password.value && confirm.value)
            auth();
        else if (username.value && password.value)
            confirm.focus();
        else if (username.value)
            password.focus();
    }
});

/**
 * Depending on login/signup selection state, post appropriate form.
 */
function auth()
{
    message.innerHTML = '';
    
    if (loginSelected)
    {
        var username = document.getElementById('login-username').value;
        var password = document.getElementById('login-password').value;
        $('#login-form').submit();
    }
    else
    {
        var password = document.getElementById('signup-password').value;
        var confirm = document.getElementById('signup-confirm').value;
        if(password.length < 8 || !hasNumbers(password) || (!password.match(/[a-z]/i) && !password.match(/[A-Z]/i) ) ){
            message.innerHTML = 'password must be at least 8 characters, have at least one number, have at least one letter, and have at least one symbol'
            return;
        }
        var passwordNoCharsOrNumbers = password.replace(/[A-Z]|[a-z]|[0-9]/g, '');
        if(passwordNoCharsOrNumbers.length == 0){
            message.innerHTML = 'password must be at least 8 characters, have at least one number, have at least one letter, and have at least one symbol'
            return;

        }
        if (password !== confirm)
        {
            message.innerHTML = 'password does not match';
            return;
        }
        
        $('#signup-form').submit();
    }
}

function hasNumbers(t)
{
    return /\d/.test(t);
}

//AJAX to resetPassword.php
function resetPassword()
{
	var _email = document.getElementById('login-username').value;
    $.post( "../ajax/resetPassword.php", { email:_email}, function(data) {
		$( "#message" ).html( data );
	});
}