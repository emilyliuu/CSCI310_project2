/*
 login.js
 --------
 js script used only for login page
 
 @author: Bohui Moon [bohuim]
 */


/* --- VARS --- */
var loginSelected = true;


/* --- EVENTS --- */
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
 * Depending on the state, request appropriate auth aciton.
 */
$('button.auth-button').click(function(e)
{
    
});