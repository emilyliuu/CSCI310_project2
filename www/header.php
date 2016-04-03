<?php

/**
 * header.php
 *
 * Defines things that most files will need.
 * host & uri point to current domain for redirectnig.
 * Parse initialization with appropriate keys
 *
 * @author: Bohui Moon [bohuim]
 */


/* parse */
require_once $_SERVER['DOCUMENT_ROOT'] . '/Stockr/www/modules/parse-php/autoload.php';
use Parse\ParseClient;

session_start();
ParseClient::initialize('6coM4vYK3mt4YD6fNC8hXm2WAAQZ7ZIaDIR4F04Z', 
                        'TIZe8qfP7L6F21SwKcqVZnvcvT2wDp5UO2tPGaDx', 
                        'QtaEvugC4anbeRe72EDsDCbOuYPCggGq22Ow01ot');