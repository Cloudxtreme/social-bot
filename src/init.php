<?php
/* 
 *	ERROR configuration 
 */
ini_set('display_errors',1);
error_reporting(E_ALL|E_STRICT);

// Exception handler
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
	throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exception_error_handler");


/* 
 *	Library configuration 
 */
require 'vendor/autoload.php';
require 'Bot.php';
require 'lib.php';
require 'FacebookHelper.php';
require 'stringer.php';

/* 
 *	DATABASE configuration 
 */
$DB_USER = 'root'; 
$DB_PASS = '';
$DATABASE = 'socialbot';
$DB_DSN = "mysql:host=127.0.0.1; dbname=$DATABASE; charset=utf8";

$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
// $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$db = new FluentPDO($pdo);

/* 
 *	Auth configuration 
 */

define('FACEBOOK_APP_ID', '784700351595980');
define('FACEBOOK_APP_SECRET', 'dc970312434199e79a1f3826ec458983');
Facebook\FacebookSession::setDefaultApplication(FACEBOOK_APP_ID, FACEBOOK_APP_SECRET);

// $client 2= Discogs\ClientFactory::factory([]);
// $oauth = new GuzzleHttp\Subscriber\Oauth\Oauth1([
//     'consumer_key'    => 'ZIGEtxPKOPoYlhGstLXr',
//     'consumer_secret' => 'rVHITMYRkrQtTJJMJteIIZdtsDMlgwHk',
//     'token'           => 'JZNOErHnqDnjFkCojPOwRcNZbrSoojZdQhgpzXYl',
//     'token_secret'    => 'NvjVJHZEBbbAzLayFiVMvakXmTMjKMCfeGNRtUWd'
// ]);

// $client->getHttpClient()->getEmitter()->attach($oauth);

$logger = new Katzgrau\KLogger\Logger(__DIR__.'/logs');

define("BASE_PATH", "");
define("QUOTES_PATH", "D:\\drive\\marketing\\facebook_fer\\");
define("TMP_PATH", "tmp");
