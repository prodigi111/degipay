<?php
error_reporting(0);
if(!isset($_SESSION)) session_start();
date_default_timezone_set('Asia/Jakarta');
ini_set('memory_limit', '512M');
$date = date("Y-m-d");
$time = date("H:i:s");
$datetime = date("Y-m-d H:i:s");

$aiy = [
    'host' => 'localhost',
    'user' => 'alleroni_degipay', # Username Database
    'pass' => 'degipay2025!', # Password Database
    'name' => 'alleroni_degipay'  # Nama Database
];
$call = mysqli_connect($aiy['host'],$aiy['user'],$aiy['pass'],$aiy['name']);
if(!$call) { die("Connection Failed!"); error_log("Connection Failed : ".mysqli_connect_error()); }
function _DIR_($path,$x = 'php') {
    global $_SERVER;
    if($x == 'php') return (stristr($path,'.php')) ? $_SERVER['DOCUMENT_ROOT'].'/'.$path : $_SERVER['DOCUMENT_ROOT'].'/'.$path.'.php';
    else return $_SERVER['DOCUMENT_ROOT'].'/'.$path;
}

require _DIR_('library/mainfunction');
require _DIR_('library/customfunction');
require _DIR_('library/function/csrf_token');
require _DIR_('library/function/licence');
require _DIR_('library/function/cURL');
require _DIR_('library/function/mailer');
require _DIR_('library/function/SimCardDetector');

$page = '';

$_CONFIG = [
    'title'         => conf('webcfg',1),
    'description'   => conf('webcfg',2),
    'keyword'       => conf('webcfg',3),
    'banner'        => conf('webcfg',4),
    'icon'          => conf('webcfg',5),
    'mt'            => [
        'web' => conf('webmt',1),
        'api' => conf('webmt',2),
        'bot' => conf('webmt',3),
    ],
    'reCAPTCHA'     => [
        'site' => '',
        'secret' => ''
    ],
    'SweetAlert'    => conf('webcfg',6),
];

$_META = [
    'robots' => 'index, follow',
    'revisit' => '1 days',
    'bing_site' => 'D00E1C1DD990CCE27CFAB8A295D202C4',
    'google_site' => 'nuqTjnjDZ-4ufOiWTdhnsLKRkE2PIolE0Op-ZUW07cM',
    'google_tagmanager' => 'GTM-TAGCODE',
    'geo_placename' => 'Indonesia',
    'geo_country' => 'Id'
];

$_MAILER = [
    'host' => conf('mailer',1),
    'user' => conf('mailer',2),
    'pass' => conf('mailer',3),
    'from' => conf('mailer',4),
];

// -- |[ BCA CONFIGURATION REQUIRED ]| -- //
require _DIR_('library/function/class.bca');
$BCA = new BCA([
    'id'  => conf('account-bank', 1),
    'password'  => conf('account-bank' ,2)]);
// -- |[ BNI CONFIGURATION REQUIRED ]| -- //
require _DIR_('library/function/class.bni');
// -- |[ ATL-WHATSAPP CONFIGURATION REQUIRED ]| -- //
require _DIR_('library/function/Whatsapp');
$WATL = new Whatsapp();

// -- |[ DIGIFLAZZ CONFIGURATION REQUIRED ]| -- //
require _DIR_('library/function/Digiflazz.php');
$DIGI = new DigiFlazz([
    'username' => $call->query("SELECT * FROM provider WHERE code = 'DIGI'")->fetch_assoc()['uid'],
    'apikey' => $call->query("SELECT * FROM provider WHERE code = 'DIGI'")->fetch_assoc()['ukey']
]);

// -- |[ OVO CONFIGURATION REQUIRED ]| -- //
require _DIR_('library/function/class.ovo');

require _DIR_('library/function/FCM/lib.php');
$FCM = new FCM();
