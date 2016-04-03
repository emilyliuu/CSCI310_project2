<?php

/**
 * logout.php
 *
 * Logs out current user and invalidates session.
 * This script should not be directly posted to, but called in from AJAX.
 * 
 * @author: Bohui Moon [bohuim]
 */

require_once '../header.php';
use Parse\ParseUser;

$user = ParseUser::getCurrentUser();
if (!$user)
{
    header('Content-type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'No logged in user'
    ]);
    exit();
}


$user->logOut();

header('Content-type: application/json');
echo json_encode([
    'status' => 'success'
]);
exit();